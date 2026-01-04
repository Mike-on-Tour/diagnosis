<?php
/**
*
* @package MoT phpBB Diagnosis v0.0.1
* @copyright (c) 2025 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, [
	'ACP_MOT_DIAGNOSIS'						=> 'MoT phpBB Diagnosis',

	// Cron Status
	'ACP_MOT_DIAGNOSIS_CRONSTATUS'			=> 'Cron Status',
	'ACP_MOT_DIAGNOSIS_CRON_TABLE_EXPL'		=> 'The following table contains all cron tasks which were found within the service container. If the program was able to deduce the
												period between two runs and the time of the last run contained in the CONFIG_TABLE from the name those values will be diplayed
												as well.
												Active cron tasks are printed in green letters, inactive ones in darkblue.<br>
												An asterisk behind the cron task name indicates that this task satisfies all condition to run and waits for a trigger to start it,
												this can even be the case with inactice cron tasks.',
	'ACP_MOT_DIAGNOSIS_CRON_NAME'			=> 'Cron task name',
	'ACP_MOT_DIAGNOSIS_CRON_CLASS'			=> 'Cron task class including path',
	'ACP_MOT_DIAGNOSIS_CRON_GC'				=> 'Period between two runs in s',
	'ACP_MOT_DIAGNOSIS_CRON_LAST_GC'		=> 'Last run',
	'ACP_MOT_DIAGNOSIS_NO_ENTRIES'			=> 'No cron tasks found',
	'ACP_MOT_DIAGNOSIS_CONFIG_TABLE_EXPL'	=> 'The following table lists all entries concerning the period between two runs and the time of the last run from the CONFIG_TABLE
												which do not fit one of the cron tasks found in the service container. The name displayed is deduced from the naming of those
												entries.',
	'ACP_MOT_DIAGNOSIS_CONFIG_NAME'			=> 'Deduced name of the cron task',
]);
