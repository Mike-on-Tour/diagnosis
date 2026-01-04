<?php
/**
*
* @package MoT phpBB Diagnosis v0.0.1
* @copyright (c) 2025 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\diagnosis\acp;

class mot_diagnosis_acp_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	/**
	 * Main ACP module
	 *
	 * @params	$id		The module identifier (\mot\diagnosis\acp\mot_diagnosis_acp_module)
	 *		$mode	The module mode
	 *
	 * @throws \Exception
	 */
	public function main(string $id, string $mode)
	{
		global $phpbb_container;

		/** @var \mot.pages.controller.acp $acp_config_controller */
		$acp_controller = $phpbb_container->get('mot.diagnosis.controller.mot_diagnosis_acp');

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_mot_diagnosis_' . $mode;

		// Set the page title for our ACP page
		$this->page_title = $language->lang('ACP_MOT_DIAGNOSIS') . ' - ' . $language->lang('ACP_MOT_DIAGNOSIS_' . mb_strtoupper($mode));

		// Make the $u_action url available in our ACP controller
		$acp_controller->set_page_url($this->u_action)->{$mode}();
	}
}
