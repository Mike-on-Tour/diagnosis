<?php
/**
*
* @package MoT phpBB Diagnosis v0.3.3
* @copyright (c) 2025 - 2026 Mike-on-Tour
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
	'ACP_MOT_DIAGNOSIS_VERSION'				=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" alt=""><br>&copy; 2025 - %2$d by Mike-on-Tour',

	// Cron status
	'ACP_MOT_DIAGNOSIS_CRONSTATUS'			=> 'Cron status',
	'ACP_MOT_DIAGNOSIS_CRON_TABLE_EXPL'		=> 'The following table contains all cron tasks which were found within the service container. If the program was able to deduce the
												period between two runs and the time of the last run contained in the CONFIG_TABLE from the task`s name those values will be
												diplayed as well.
												Active cron tasks are printed in green letters, inactive ones in darkblue.<br>
												An asterisk behind the cron task name indicates that this task satisfies all conditions to run and waits for a trigger to start it,
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

	// Attachements
	'ACP_MOT_DIAGNOSIS_ATTACHMENTS'			=> 'File attachments',
	'ACP_MOT_DIAGNOSIS_ATTACHMENTS_EXPL'	=> 'On this page you have the options of either checking the database table holding attached files (ATTACHMENTS_TABLE) for entries
												which do no longer have a corresponding file in the `/files` directory (orphaned database items) or checking the `/files` directory
												for files which do not have a corresponding entry within the database table (orphaned files). Please be aware that this is different
												from phpBB`s ACP function ´Orphaned attachments´ which solely looks for database items without a corresponding post or PM.<br>
												The higher the number of file attachments the longer the process of finding orphaned database items and orphaned files will take,
												therefore this data will be stored in the cache with a lifetime identical to the session length in order to prevent delays while
												switching between tables or to another table page.<br>
												After deleting orphaned database items or files the altered data has to be read again and stored in the cache which again will result
												in a longer loading time.',
	'ACP_MOT_DIAGNOSIS_ATTM_REFRESH_EXPL'	=> 'By clicking the button to the right you can delete the data stored in the cache and recreate it',
	'ACP_MOT_DIAGNOSIS_ATTM_REFRESH'		=> 'Refresh data',
	'ACP_MOT_DIAGNOSIS_ATTM_SELECT'			=> 'Show orphaned ',
	'ACP_MOT_DIAGNOSIS_ORPHANED_FILES'		=> 'files',
	'ACP_MOT_DIAGNOSIS_ORPHANED_ITEMS'		=> 'database items',
	'ACP_MOT_DIAGNOSIS_ATTM_TABLE_EXPL'		=> 'The following table displays all items of the database table holding the file attachments (ATTACHMENTS_TABLE) for which there is no
												corresponding file found in the `\files` directory (orphaned database items).<br>
												The column `Post id` contains a link to the post where the attachment is used, the column `PM id` shows the id of the personal
												message where the file is attached.',
	'ACP_MOT_DIAGNOSIS_ATTM_ITEMS'			=> [
		1		=> '%1$d item',
		2		=> '%1$d items',
	],
	'ACP_MOT_DIAGNOSIS_NO_ITEMS'			=> 'No items',
	'ACP_MOT_DIAGNOSIS_ATTM_PHYS_NAME'		=> 'Physical filename',
	'ACP_MOT_DIAGNOSIS_ATTM_REAL_NAME'		=> 'Real filename',
	'ACP_MOT_DIAGNOSIS_ATTM_ATTACH_ID'		=> 'Attachment id',
	'ACP_MOT_DIAGNOSIS_ATTM_POST_ID'		=> 'Post id',
	'ACP_MOT_DIAGNOSIS_ATTM_USER_ID_TITLE'	=> 'Link to the member`s profile creating this attachment',
	'ACP_MOT_DIAGNOSIS_ATTM_USER_ID'		=> 'User id',
	'ACP_MOT_DIAGNOSIS_ATTM_POST_ID_TITLE'	=> 'Link to the post using this attachment',
	'ACP_MOT_DIAGNOSIS_ATTM_MSG_ID'			=> 'PM id',
	'ACP_MOT_DIAGNOSIS_SORT_ASC'			=> 'Ascending',
	'ACP_MOT_DIAGNOSIS_SORT_DESC'			=> 'Descending',
	'ACP_MOT_DIAGNOSIS_NO_ITEM_SELECTED'	=> 'You have not selected any database items for this action, please mark at least one item.',
	'ACP_MOT_DIAGNOSIS_CONFIRM_ITEM_DEL'	=> [
		1	=> 'Are you really certain that you want to delete 1 item from ATTACHMENTS_TABLE?<br><br><strong>This removes the item permanently from the database and cannot be undone!</strong>',
		2	=> 'Are you really certain that you want to delete %1$d items from the ATTACHMENTS_TABLE?<br><br><strong>This removes the items permanently from the database and cannot be undone!</strong>',
	],
	'ACP_MOT_DIAGNOSIS_ITEMS_DELETED'		=> [
		1	=> '1 item successfully deleted.',
		2	=> '%1$d items successfully deleted.',
	],
	'ACP_MOT_DIAGNOSIS_FILES_TABLE_EXPL'	=> 'The following table displays all files with their physical filename from the `/files` directory which do not have a corresponding
												entry within the ATTACHMENTS_TABLE (orphaned files).',
	'ACP_MOT_DIAGNOSIS_NO_FILE_SELECTED'	=> 'You have not selected any files for this action, please mark at least one file.',
	'ACP_MOT_DIAGNOSIS_ATTM_LAST_MODIFY'	=> 'Last modified',
	'ACP_MOT_DIAGNOSIS_NO_FILE_SELECTED'	=> 'No file marked for deletion. Please select at least one file.',
	'ACP_MOT_DIAGNOSIS_CONFIRM_FILE_DEL'	=> [
		1	=> 'Are you really certain that you want to delete 1 file from the directory `/files`?<br><br><strong>This removes the file permanently from the directory and cannot be undone!</strong>',
		2	=> 'Are you really certain that you want to delete %1$d Dateien from the directory `/files`?<br><br><strong>This removes the files permanently from the directory and cannot be undone!</strong>',
	],
	'ACP_MOT_DIAGNOSIS_FILES_DELETED'		=> [
		1	=> '1 file successfully deleted.',
		2	=> '%1$d files successfully deleted.',
	],
]);
