<?php
/**
*
* @package MoT phpBB Diagnosis v0.0.1
* @copyright (c) 2025 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\diagnosis\controller;

class mot_diagnosis_acp
{
	public function __construct(protected \phpbb\db\driver\driver_interface $db, protected \phpbb\template\template $template, protected \phpbb\user $user,
								protected $mot_diagnosis_cron_manager)
	{
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
// var_dump($cron_info);
		$this->template->assign_vars([
			'ACP_MOT_DIAGNOSIS_CRON_TASKS'		=> $cron_tasks,
			'ACP_MOT_DIAGNOSIS_CONFIG_TASKS'	=> $config_tasks,
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
}
