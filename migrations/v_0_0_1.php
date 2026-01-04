<?php
/**
*
* @package MoT phpBB Diagnosis v0.0.1
* @copyright (c) 2025 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\diagnosis\migrations;

class v_0_0_1 extends \phpbb\db\migration\migration
{
	/**
	* If our first ACP module already exists in the db skip this migration.
	*/
	public function effectively_installed()
	{
		return $this->check_module('acp', 'ACP_MOT_DIAGNOSIS', 'ACP_MOT_DIAGNOSIS_CRONSTATUS');
	}

	public function update_data()
	{
		return [
			// Add a parent module (ACP_MOT_DIAGNOSIS) to the Extensions tab (ACP_CAT_DOT_MODS)
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MOT_DIAGNOSIS'
			]],

			// Add the cronstatus module to the parent module (ACP_MOT_DIAGNOSIS)
			['module.add', [
				'acp',
				'ACP_MOT_DIAGNOSIS',
				[
					'module_basename'	=> '\mot\diagnosis\acp\mot_diagnosis_acp_module',
					'module_langname'	=> 'ACP_MOT_DIAGNOSIS_CRONSTATUS',
					'module_mode'		=> 'cronstatus',
					'module_auth'		=> 'ext_mot/diagnosis && acl_a_board',
				],
			]],
		];
	}

	/*
	*	Checks whether a modul identified by it's module_langname exists under a given parent (also identified by the module_langname) and in a given module class
	*
	*	@params	$class	Name of the module class, e.g.' acp'
	*			$parent	Langname of the parent to be checked
	*			$module	Langname of the module to be checked
	*
	*	@return			True if the module doesn't exist, false if either the parent doesn't exist or the module already exists
	*/
	private function check_module(string $class, string $parent, string $module) : bool
	{
		// check if parent exists
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $this->db->sql_escape($class) . "'
			AND module_langname = '" . $this->db->sql_escape($parent) . "'";
		$result = $this->db->sql_query($sql);
		$parent_id = $this->db->sql_fetchfield('module_id', false, $result); // sql_fetchfield() returns either the id or false if this module doesn't exist
		$this->db->sql_freeresult($result);
		// Parent doesn't exist -> module can not be given to this parent so we return a false
		if (!$parent_id)
		{
			return false;
		}

		// Parent exists, now check if this module already exists under this parent
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $this->db->sql_escape($class) . "'
			AND parent_id = " . (int) $parent_id . "
			AND module_langname = '" . $this->db->sql_escape($module) . "'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id', false, $result);
		$this->db->sql_freeresult($result);

		if (!$module_id)
		{
			return true;	// Module doesn't exist -> return true to enable adding this module
		}
		else
		{
			return false;	// Module already exists -> no need to adding it a second time
		}
	}
}
