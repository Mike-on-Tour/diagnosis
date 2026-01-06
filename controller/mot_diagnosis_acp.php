<?php
/**
*
* @package MoT phpBB Diagnosis v0.0.1
* @copyright (c) 2025 - 2026 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\diagnosis\controller;

class mot_diagnosis_acp
{
	public function __construct(protected \phpbb\cache\service $cache, protected \phpbb\config\config $config, protected \phpbb\db\driver\driver_interface $db, protected \phpbb\language\language $language,
								protected \phpbb\pagination $pagination, protected \phpbb\extension\manager $phpbb_extension_manager, protected \phpbb\request\request_interface $request,
								protected \phpbb\template\template $template, protected \phpbb\user $user, protected $mot_diagnosis_cron_manager, protected $root_path)
	{
		$this->md_manager = $this->phpbb_extension_manager->create_extension_metadata_manager('mot/diagnosis');
		$this->diagnosis_version = $this->md_manager->get_metadata('version');
	}

	public function cronstatus()
	{
		$task_names = $this->mot_diagnosis_cron_manager->get_task_names();
		$task_classes = $this->mot_diagnosis_cron_manager->get_task_classes();
// var_dump($this->mot_diagnosis_cron_manager->find_all_ready_tasks());
		$sql = "SELECT * FROM " . CONFIG_TABLE . "
				WHERE config_name LIKE '%_gc%'
				OR config_name LIKE '%_last_cron'
				OR config_name LIKE '%_lock'
				OR config_name LIKE '%_cron_interval'";
		$result = $this->db->sql_query($sql);
		$cron_info = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$cron_tasks = [];
		$i = 0;
		foreach ($task_names as $task)
		{
			$gc = $last_gc = -1;
			$name = substr($task, strrpos($task, '.') + 1);

			foreach ($cron_info as $k => $sub_array)
			{
				// The two if clauses check for config names which hold either the cron job name or the cron job name with another config suffix (update_hashes) or the cron job name with a leading '_tidy' (core jobs cache, database, plupload, search and warnings)
				if (in_array($sub_array['config_name'], [$name . '_gc', $name . '_lock', 'text_reparser.' . $name . '_cron_interval']) || 'tidy_' . $sub_array['config_name'] == $name . '_gc')
				{
					$gc = $sub_array['config_value'];
					unset ($cron_info[$k]);
				}

				if (in_array($sub_array['config_name'], [$name . '_last_gc', $name . '_last_cron', 'text_reparser.' . $name . '_last_cron']) || 'tidy_' . $sub_array['config_name'] == $name . '_last_gc')
				{
					$last_gc = $sub_array['config_value'];
					unset ($cron_info[$k]);
				}

				// The next two if clauses handle the special case of the 'tidy_sessions' cron task since the CONFIG_TABLE entries are named 'session_' (I do not now whether the missing trailing 's' is a mistake or intended)
				if ($name == 'tidy_sessions' && $sub_array['config_name'] == 'session_gc')
				{
					$gc = $sub_array['config_value'];
					unset ($cron_info[$k]);
				}
				if ($name == 'tidy_sessions' && $sub_array['config_name'] == 'session_last_gc')
				{
					$last_gc = $sub_array['config_value'];
					unset ($cron_info[$k]);
				}

				// The next two if clauses handle the special case of the 'prune_notifications' cron task since the CONFIG_TABLE entries are named 'read_notification_'
				if ($name == 'prune_notifications' && $sub_array['config_name'] == 'read_notification_gc')
				{
					$gc = $sub_array['config_value'];
					unset ($cron_info[$k]);
				}
				if ($name == 'prune_notifications' && $sub_array['config_name'] == 'read_notification_last_gc')
				{
					$last_gc = $sub_array['config_value'];
					unset ($cron_info[$k]);
				}
			}

			$cron_tasks[] = [
				'name'			=> $task,
				'active'		=> @$this->mot_diagnosis_cron_manager->check_runnable($task),
				'should_run'	=> @$this->mot_diagnosis_cron_manager->check_should_run($task),
				'class'			=> $task_classes[$i],
				'gc'			=> $gc >= 0 ? $gc : '-',
				'last_gc'		=> $last_gc >= 0 ? $this->user->format_date($last_gc) : '-',
			];

			$i++;
		}

		$config_tasks = [];
		foreach ($cron_info as $sub_array)
		{
			$gc = $last_gc = -1;
			if (str_contains($sub_array['config_name'], '_last_gc') || str_contains($sub_array['config_name'], '_last_cron'))
			{
				$name = str_replace('_last_gc', '', $sub_array['config_name']);
				$last_gc = $sub_array['config_value'];

				foreach ($cron_info as $k => $row)
				{
					if (in_array($row['config_name'], [$name . '_gc', $name . '_cron_interval']))
					{
						$gc = $row['config_value'];
						unset ($cron_info[$k]);
						break;
					}
				}

				$config_tasks[] = [
					'name'		=> $name,
					'gc'		=> $gc >= 0 ? $gc : '-',
					'last_gc'	=> $last_gc >= 0 ? $this->user->format_date($last_gc) : '-',
				];
			}
		}

		$this->template->assign_vars([
			'ACP_MOT_DIAGNOSIS_CRON_TASKS'		=> $cron_tasks,
			'ACP_MOT_DIAGNOSIS_CONFIG_TASKS'	=> $config_tasks,
			'ACP_MOT_DIAGNOSIS_VERSION'			=> $this->language->lang('ACP_MOT_DIAGNOSIS_VERSION', $this->diagnosis_version, date('Y')),
		]);
	}

	public function attachments()
	{
		$cache_ttl = 300;	// Time-to-live for cached data
		$limit = $this->config['posts_per_page'];
		$start = $this->request->variable('start', 0);
		$attachment_selected = $this->request->variable('mot_diagnosis_attachment_select', 'orphaned_items');
		$dir = $this->root_path . 'files';

		// Check whether orphaned DB items are to be deleted
		$del_items = $this->request->is_set('mot_diagnosis_del_marked_items');
		if ($del_items)
		{
			$del_items_arr = $this->request->variable('mot_diagnosis_items_mark_delete', [0]);
			if (count ($del_items_arr) > 0)
			{
				if (confirm_box(true))
				{
					$sql = 'DELETE FROM ' . ATTACHMENTS_TABLE . '
							WHERE ' . $this->db->sql_in_set('attach_id', $del_items_arr);
					$this->db->sql_query($sql);

					// Remove the attachments from the cache to get the actual ones
					$this->cache->destroy('attachments');
					// Remove the orphaned items from the cache to get the actual ones
					$this->cache->destroy('orphaned_items');
					trigger_error($this->language->lang('ACP_MOT_DIAGNOSIS_ITEMS_DELETED', count($del_items_arr)) . adm_back_link($this->u_action), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, $this->language->lang('ACP_MOT_DIAGNOSIS_CONFIRM_ITEM_DEL', count ($del_items_arr)), build_hidden_fields([
						'mot_diagnosis_del_marked_items'		=> $del_items,
						'mot_diagnosis_items_mark_delete'		=> $del_items_arr,
						'mot_diagnosis_attachment_select'		=> $attachment_selected,
						'u_action'								=> $this->u_action,
					]));
				}
			}
			else
			{
				trigger_error($this->language->lang('ACP_MOT_DIAGNOSIS_NO_ITEM_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}

		// Check whether orphaned files are to be deleted
		$del_files = $this->request->is_set('mot_diagnosis_del_marked_files');
		if ($del_files)
		{
			$del_files_arr = $this->request->variable('mot_diagnosis_files_mark_delete', ['']);
			if (count ($del_files_arr) > 0)
			{
				if (confirm_box(true))
				{
					foreach ($del_files_arr as $element)
					{
						unlink($dir . '/' . $element);
					}

					// Remove the attm_files from the cache to get the actual ones from the '/files' directory
					$this->cache->destroy('attm_files');
					// Remove the orphaned files from the cache to get the actual ones
					$this->cache->destroy('orphaned_files');
					trigger_error($this->language->lang('ACP_MOT_DIAGNOSIS_FILES_DELETED', count($del_files_arr)) . adm_back_link($this->u_action . '&amp;mot_diagnosis_attachment_select=orphaned_files'), E_USER_NOTICE);
				}
				else
				{
					confirm_box(false, $this->language->lang('ACP_MOT_DIAGNOSIS_CONFIRM_FILE_DEL', count ($del_files_arr)), build_hidden_fields([
						'mot_diagnosis_del_marked_files'		=> $del_files,
						'mot_diagnosis_files_mark_delete'		=> $del_files_arr,
						'mot_diagnosis_attachment_select'		=> $attachment_selected,
						'u_action'								=> $this->u_action,
					]));
				}
			}
			else
			{
				trigger_error($this->language->lang('ACP_MOT_DIAGNOSIS_NO_FILE_SELECTED') . adm_back_link($this->u_action . '&amp;mot_diagnosis_attachment_select=orphaned_files'), E_USER_WARNING);
			}
		}

		// Get all attachments from DB
		if (! $this->cache->_exists('attachments'))
		{
			$sql_ary = [
				'SELECT'	=> 'a.attach_id, a.physical_filename, a.real_filename, p.post_id, pm.msg_id',

				'FROM'		=> [ATTACHMENTS_TABLE => 'a'],

				'LEFT_JOIN'	=> [
						[
								'FROM'	=> [POSTS_TABLE	=> 'p',],
								'ON'	=> 'p.post_id = a.post_msg_id AND a.in_message = 0',
						],
						[
								'FROM'	=> [PRIVMSGS_TABLE	=> 'pm',],
								'ON'	=> 'pm.msg_id = a.post_msg_id AND a.in_message = 1',
						],
				],

				'ORDER_BY'	=> 'a.post_msg_id ASC',
			];
			$sql = $this->db->sql_build_query('SELECT', $sql_ary);
			// $sql = 'SELECT attach_id, physical_filename, real_filename, post_msg_id, in_message FROM ' . ATTACHMENTS_TABLE;
			$result = $this->db->sql_query($sql);
			$attachments = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			$this->cache->put('attachments', $attachments, $cache_ttl);
		}
		else
		{
			$attachments = $this->cache->get('attachments');
		}

		// Get all files (except .htaccess and index.htm) from the /files directory and store their names in an array
		$attm_files = [];
		$path = scandir($dir);

		if (! $this->cache->_exists('attm_files'))
		{
			foreach ($path as $element)
			{
				if (is_file ($dir . '/' . $element) && !in_array($element, ['.htaccess', 'index.htm']))
				{
					$attm_files[] = $element;
				}
			}

			$this->cache->put('attm_files', $attm_files, $cache_ttl);
		}
		else
		{
			$attm_files = $this->cache->get('attm_files');
		}

		$orphaned_items = [];	// Holds all (physical) filenames of those files which are indexed in the DB but do not exist in the /files directory
		$physical_files = [];	// Holds all (physical) filenames of those files which are indexed in the DB

		if (! $this->cache->_exists('orphaned_items'))
		{
			foreach ($attachments as $row)
			{
				if (!in_array($row['physical_filename'], $attm_files))
				{
					$orphaned_items[] = $row;
				}
				$physical_files[] = $row['physical_filename'];
			}

			$this->cache->put('orphaned_items', $orphaned_items, $cache_ttl);
			$this->cache->put('physical_files', $physical_files, $cache_ttl);
		}
		else
		{
			$orphaned_items = $this->cache->get('orphaned_items');
			$physical_files = $this->cache->get('physical_files');
		}

		$orphaned_files = [];
		if (! $this->cache->_exists('orphaned_files'))
		{
			foreach ($attm_files as $file)
			{
				if (!in_array($file, $physical_files))
				{
					$orphaned_files[] = $file;
				}
			}

			$this->cache->put('orphaned_files', $orphaned_files, $cache_ttl);
		}
		else
		{
			$orphaned_files = $this->cache->get('orphaned_files');
		}

		$attachment_select = [
			'ACP_MOT_DIAGNOSIS_ORPHANED_ITEMS'		=> 'orphaned_items',
			'ACP_MOT_DIAGNOSIS_ORPHANED_FILES'		=> 'orphaned_files',
		];

		$orphaned_items_count = count ($orphaned_items);
		$orphaned_files_count = count ($orphaned_files);

		//base url for pagination, filtering and sorting
		$base_url = $this->u_action . '&amp;mot_diagnosis_attachment_select=' . $attachment_selected;

		// Load pagination
		if ($attachment_selected == 'orphaned_items')
		{
			$start = $this->pagination->validate_start($start, $limit, $orphaned_items_count);
			$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $orphaned_items_count, $limit, $start);
		}
		if ($attachment_selected == 'orphaned_files')
		{
			$start = $this->pagination->validate_start($start, $limit, $orphaned_files_count);
			$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $orphaned_files_count, $limit, $start);
		}

		$this->template->assign_vars([
			'ACP_MOT_DIAGNOSIS_ATTM_SELECT'				=> $this->select_struct($attachment_selected, $attachment_select),
			'ACP_MOT_DIAGNOSIS_ATTM_SELECTED'			=> $attachment_selected,
			'ACP_MOT_DIAGNOSIS_ORPHANED_ITEMS'			=> array_slice($orphaned_items, $start, $limit),
			'ACP_MOT_DIAGNOSIS_ORPHANED_ITEMS_COUNT'	=> $orphaned_items_count,
			'ACP_MOT_DIAGNOSIS_ORPHANED_FILES'			=> array_slice($orphaned_files, $start, $limit),
			'ACP_MOT_DIAGNOSIS_ORPHANED_FILES_COUNT'	=> $orphaned_files_count,
			'ACP_MOT_DIAGNOSIS_SCRIPT_PATH'				=> $this->config['script_path'],
			'ACP_MOT_DIAGNOSIS_VERSION'					=> $this->language->lang('ACP_MOT_DIAGNOSIS_VERSION', $this->diagnosis_version, date('Y')),
			'U_ACTION'									=> $this->u_action,
		]);
	}

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Set custom form action.
	 *
	 * @param	$u_action	Custom form action
	 * @return 	$this		This controller for chaining calls
	 */
	public function set_page_url(string $u_action) : object
	{
		$this->u_action = $u_action;

		return $this;
	}

	/*
	* Prepare options array for dropdown select fields
	*/
	private function select_struct(mixed $cfg_value, array $options): array
	{
		$options_tpl = [];

		foreach ($options as $opt_key => $opt_value)
		{
			if (!is_array($opt_value))
			{
				$opt_value = [$opt_value];
			}
			$options_tpl[] = [
				'label'		=> $opt_key,
				'value'		=> $opt_value[0],
				'bold'		=> $opt_value[1] ?? false,
				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
			];
		}

		return $options_tpl;
	}
}
