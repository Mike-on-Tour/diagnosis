<?php
/**
*
* @package MoT phpBB Diagnosis v0.0.1
* @copyright (c) 2025 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\diagnosis\acp;

class mot_diagnosis_acp_info
{
	public function module()
	{
		return [
			'filename'	=> '\mot\diagnosis\acp\mot_diagnosis_acp_module',
			'title'		=> 'ACP_MOT_DIAGNOSIS',
			'modes'		=> [
				'settings'			=> [
					'title'	=> 'ACP_MOT_DIAGNOSIS_CRONSTATUS',
					'auth'	=> 'ext_mot/diagnosis && acl_a_board',
					'cat'	=> ['ACP_MOT_DIAGNOSIS'],
				],
			],
		];
	}
}
