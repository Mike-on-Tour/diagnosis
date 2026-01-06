<?php
/**
*
* @package MoT phpBB Diagnosis v0.1.0
* @copyright (c) 2025 - 2026 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\diagnosis\migrations;

class v_0_1_0 extends \phpbb\db\migration\migration
{
	/**
	* If our first ACP module already exists in the db skip this migration.
	*/
	public static function depends_on()
	{
		return ['\mot\diagnosis\migrations\v_0_0_1'];
	}

	public function update_data()
	{
		return [
			// Add the attachements module to the parent module (ACP_MOT_DIAGNOSIS)
			['module.add', [
				'acp',
				'ACP_MOT_DIAGNOSIS',
				[
					'module_basename'	=> '\mot\diagnosis\acp\mot_diagnosis_acp_module',
					'module_langname'	=> 'ACP_MOT_DIAGNOSIS_ATTACHMENTS',
					'module_mode'		=> 'attachments',
					'module_auth'		=> 'ext_mot/diagnosis && acl_a_board',
				],
			]],
		];
	}
}
