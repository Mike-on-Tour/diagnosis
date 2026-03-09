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
	'ACP_MOT_DIAGNOSIS'						=> 'MoT phpBB Diagnose',
	'ACP_MOT_DIAGNOSIS_VERSION'				=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" alt=""><br>&copy; 2025 - %2$d by Mike-on-Tour',

	// Cron status
	'ACP_MOT_DIAGNOSIS_CRONSTATUS'			=> 'Cron Status',
	'ACP_MOT_DIAGNOSIS_CRON_TABLE_EXPL'		=> 'In der folgenden Tabelle werden alle im Service-Container gefundenen Cron Tasks aufgelistet. Wo aus dem Namen des Cron Tasks
												ableitbar, werden auch die Einträge für die Zeit zwischen zwei Läufen und der Zeitpunkt des letzten Laufes aus der CONFIG_TABLE
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

	// Attachements
	'ACP_MOT_DIAGNOSIS_ATTACHMENTS'			=> 'Dateianhänge',
	'ACP_MOT_DIAGNOSIS_ATTACHMENTS_EXPL'	=> 'Auf dieser Seite kannst du wahlweise prüfen, ob in der Tabelle für Dateianhänge (ATTACHMENTS_TABLE) auf Dateien verwiesen wird,
												die im entsprechenden Verzeichnis `/files` nicht (mehr) existieren (verwaiste DB-Einträge) bzw. ob sich in diesem Verzeichnis
												Dateien befinden, für die es keinen Eintrag in der Tabelle gibt (verwaiste Dateien). Beachte bitte, dass dies nicht identisch
												mit der Administrator-Funktion ´Verwaiste Dateianhänge´ ist, die nur nach DB-Einträgen sucht, die keinem Beitrag oder einer
												PN zugeordnet sind.<br>
												Je höher die Anzahl der Dateianhänge ist, umso länger dauert der Prozess zum Auffinden verwaister DB-Einträge bzw. verwaister
												Dateien, deshalb wird das Ergebnis im Cache gespeichert. Diese Speicherung gilt für die eingestellte Sitzungslänge und verhindert
												Verzögerungen beim Umschalten zwischen diesen beiden Tabellen bzw. beim Aufrufen weiterer Tabellenseiten.<br>
												Werden verwaiste DB-Einträge oder Dateien gelöscht, werden die Daten erneut eingelesen und neu im Cache gespeichert.',
	'ACP_MOT_DIAGNOSIS_ATTM_REFRESH_EXPL'	=> 'Durch Anklicken der folgenden Schaltfläche kannst du die im Cache gespeicherten Daten löschen und neu einlesen',
	'ACP_MOT_DIAGNOSIS_ATTM_REFRESH'		=> 'Daten aktualisieren',
	'ACP_MOT_DIAGNOSIS_ATTM_SELECT'			=> 'Zeige verwaiste ',
	'ACP_MOT_DIAGNOSIS_ORPHANED_FILES'		=> 'Dateien',
	'ACP_MOT_DIAGNOSIS_ORPHANED_ITEMS'		=> 'DB-Einträge',
	'ACP_MOT_DIAGNOSIS_ATTM_TABLE_EXPL'		=> 'In der folgenden Tabelle werden alle Einträge aus der Tabelle für Dateianhänge (ATTACHMENTS_TABLE) aufgelistet, für die im
												Verzeichnis `\files` keine Dateien existieren (verwaiste DB-Einträge).<br>
												Die Spalte `Beitrags-Id` verweist jeweils mit einem Link auf den Beitrag, in dem der Dateianhang verwendet wird, die Spalte
												`PN-Id` gibt an, in welcher privaten Nachricht der Dateianhang verwendet wurde.',
	'ACP_MOT_DIAGNOSIS_ATTM_ITEMS'			=> [
		1		=> '%1$d Eintrag',
		2		=> '%1$d Einträge',
	],
	'ACP_MOT_DIAGNOSIS_NO_ITEMS'			=> 'Keine Einträge',
	'ACP_MOT_DIAGNOSIS_ATTM_PHYS_NAME'		=> 'Physikalischer Dateiname',
	'ACP_MOT_DIAGNOSIS_ATTM_REAL_NAME'		=> 'Tatsächlicher Dateiname',
	'ACP_MOT_DIAGNOSIS_ATTM_ATTACH_ID'		=> 'Anhangs-Id',
	'ACP_MOT_DIAGNOSIS_ATTM_POST_ID'		=> 'Beitrags-Id',
	'ACP_MOT_DIAGNOSIS_ATTM_USER_ID_TITLE'	=> 'Link zum Profil des Mitglieds, das den Dateianhang erstellt hat',
	'ACP_MOT_DIAGNOSIS_ATTM_USER_ID'		=> 'Mitglieder-Id',
	'ACP_MOT_DIAGNOSIS_ATTM_POST_ID_TITLE'	=> 'Link zum Beitrag, in dem dieser Dateianhang genutzt wird',
	'ACP_MOT_DIAGNOSIS_ATTM_MSG_ID'			=> 'PN-Id',
	'ACP_MOT_DIAGNOSIS_SORT_ASC'			=> 'Aufsteigend',
	'ACP_MOT_DIAGNOSIS_SORT_DESC'			=> 'Absteigend',
	'ACP_MOT_DIAGNOSIS_NO_ITEM_SELECTED'	=> 'Es wurde kein DB-Eintrag zum Löschen markiert. Bitte mindestens einen DB-Eintrag markieren.',
	'ACP_MOT_DIAGNOSIS_CONFIRM_ITEM_DEL'	=> [
		1	=> 'Willst du wirklich 1 Eintrag aus der ATTACHMENTS_TABLE löschen?<br><br>Damit wird der Eintrag endgültig aus der Datenbank entfernt, <strong>dieser Vorgang kann nicht rückgängig gemacht werden!</strong>',
		2	=> 'Willst du wirklich %1$d Einträge aus der ATTACHMENTS_TABLE löschen?<br><br>Damit werden die Einträge endgültig aus der Datenbank entfernt, <strong>dieser Vorgang kann nicht rückgängig gemacht werden!</strong>',
	],
	'ACP_MOT_DIAGNOSIS_ITEMS_DELETED'		=> [
		1	=> '1 Eintrag erfolgreich gelöscht.',
		2	=> '%1$d Einträge erfolgreich gelöscht.',
	],
	'ACP_MOT_DIAGNOSIS_FILES_TABLE_EXPL'	=> 'In der folgenden Tabelle werden alle Dateien mit ihrem physikalischen Dateinamen aufgelistet, für die es in der ATTACHMENTS_TABLE
												keinen Eintrag gibt (verwaiste Dateien).',
	'ACP_MOT_DIAGNOSIS_ATTM_LAST_MODIFY'	=> 'Datum der letzten Änderung',
	'ACP_MOT_DIAGNOSIS_NO_FILE_SELECTED'	=> 'Es wurde keine Datei zum Löschen markiert. Bitte mindestens eine Datei markieren.',
	'ACP_MOT_DIAGNOSIS_CONFIRM_FILE_DEL'	=> [
		1	=> 'Willst du wirklich 1 Datei aus dem Verzeichnis `/files` löschen?<br><br>Damit wird die Datei endgültig gelöscht, <strong>dieser Vorgang kann nicht rückgängig gemacht werden!</strong>',
		2	=> 'Willst du wirklich %1$d Dateien aus dem Verzeichnis `/files` löschen?<br><br>Damit werden die Dateien endgültig gelöscht, <strong>dieser Vorgang kann nicht rückgängig gemacht werden!</strong>',
	],
	'ACP_MOT_DIAGNOSIS_FILES_DELETED'		=> [
		1	=> '1 Datei erfolgreich gelöscht.',
		2	=> '%1$d Dateien erfolgreich gelöscht.',
	],
]);
