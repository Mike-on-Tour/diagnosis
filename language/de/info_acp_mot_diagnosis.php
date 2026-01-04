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
	'ACP_MOT_DIAGNOSIS'						=> 'MoT phpBB Diagnose',

	// Cron status
	'ACP_MOT_DIAGNOSIS_CRONSTATUS'			=> 'Cron Status',
	'ACP_MOT_DIAGNOSIS_CRON_TABLE_EXPL'		=> 'In der folgenden Tabelle werden alle im Service-Container gefundenen Cron Tasks aufgelistet. Wo aus dem Namen des Cron Tasks
												ableitbar werden auch die Einträge für die Zeit zwischen zwei Läufen und der Zeitpunkt des letzten Laufes aus der CONFIG_TABLE
												ausgelesen und angezeigt.<br>
												Aktive Cron Tasks werden in grüner Schrift, inaktive in dunkelblauer Schrift angezeigt.<br>
												Ein Sternchen hinter dem Namen zeigt an, dass der Cron Task die Bedingungen für einen Lauf erfüllt und darauf wartet, gestartet
												zu werden, dies kann auch bei inaktiven Cron Tasks der Fall sein.',
	'ACP_MOT_DIAGNOSIS_CRON_NAME'			=> 'Name des Cron Tasks',
	'ACP_MOT_DIAGNOSIS_CRON_CLASS'			=> 'Klasse des Cron Task inklusive Pfad',
	'ACP_MOT_DIAGNOSIS_CRON_GC'				=> 'Zeit zwischen zwei Läufen in s',
	'ACP_MOT_DIAGNOSIS_CRON_LAST_GC'		=> 'Letzter Lauf',
	'ACP_MOT_DIAGNOSIS_NO_ENTRIES'			=> 'Keine Cron Tasks gefunden',
	'ACP_MOT_DIAGNOSIS_CONFIG_TABLE_EXPL'	=> 'In der folgenden Tabelle werden alle Einträge aus der CONFIG_TABLE zur Zeit zwischen zwei Cron Task Läufen und dem Zeitpunkt des
												letzten Laufes angezeigt, die zu keinem der im Service-Container gefundenen Cron Tasks passen. Der verwendete Name ist aus diesen
												Einträgen abgeleitet.',
	'ACP_MOT_DIAGNOSIS_CONFIG_NAME'			=> 'Abgeleiteter Name des Cron Tasks',
]);
