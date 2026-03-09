# Change Log
All changes to `MoT phpBB Diagnosis` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [0.3.3] - 2026-03-09

### Added
-	A title to the user id link in the attachments' DB items table
  
### Changed
  
### Fixed
-	A problem using `script_path` with the links to user profiles and posts within the ataachments DB items table by using `{{ ROOT_PATH }}` instead
   
### Removed
-	Definition of template variable `ACP_MOT_DIAGNOSIS_SCRIPT_PATH` in `controller/mot_diagnosis_acp.php`
  
  
## [0.3.2] - 2026-03-05

### Added
  
### Changed
  
### Fixed
-	An undefined variable (`ACP_MOT_DIAGNOSIS_ADM_BACKLINK`) within `adm/style/event/acp_overall_footer_after.html` which prevented displaying the loading indicator for the
	attachments tab
   
### Removed
  
  
## [0.3.1] - 2026-02-24

### Added
  
### Changed
  
### Fixed
-	Displaying the loading indicator with all successboxes instead of only with the extension's successbox after deleting an item or a file by declaring a template variable
	within `controller/mot_diagnosis_acp.php` which will be checked within `adm/style/event/acp_overall_footer_after.html` to make certain that the loading indicator will only
	be bind to the extension's admin back link
   
### Removed
  
  
## [0.3.0] - 2026-02-18

### Added
-	The user's id who posted the attachment to the table displaying the orphaned items, this id is a link to this user's profile, too
-	A loading indicator to the attachment tables' sorting `Go` button and to the "Back to previous page" link of the successbox after deleting items or files
-	A `Refresh data` button to the "File attachments" tab
-	Another sorting key to the orphaned items table to enable sorting by the post/message id of the ATTACHMENTS_TABLE (`Post id`)  
	Please refer to the "Fixed" section because this sorting key previously was a mis-namer
  
### Changed
-	Made one migration file from the previuosly two files
-	The explanation for the "File attachments" tab
  
### Fixed
-	The check for valid cache data which formerly ran into a PHP error because it tried to get a count on an array being NULL
-	A wrong plural statement in the ACP language files
-	A wrong sorting key designator (`Post id`) in the orphaned items table which actually was the attachment id from the ATTACHMENTS_TABLE, it now reads `Attachment id`
   
### Removed
  
  
## [0.2.0] - 2026-02-08

### Added
-	Sorting key and directions selectors to the 'File attachments' tables
-	A column to the orphaned items table holding the user id of the user who posted that attachment, table can be sorted by this column as well
  
### Changed
-	Caching is now done using individual files and not the global data file
-	Time-to-live (TTL) for the cached data is now set to the session length and no longer a set value
  
### Fixed
   
### Removed
  
  
## [0.1.1] - 2026-01-08

### Added
-	A loading indicator to the attachments tab to show the user that something is happening when we need some time to load and sift through all the arrays to compare files and DB
  
### Changed
  
### Fixed
-	A wrong `colspan` definition within the orphaned files table
-	A wrong language variable within the orphaned files table
   
### Removed
  
  
## [0.1.0] - 2026-01-05

### Added
-	A new tab to get and display all items within the ATTACHMENTS_TABLE for which there does not exist a file in the `/files` directory (orphaned items) and all files in the a.m.
	directory for which there is no item within the ATTACHMENTS_TABLE (orphaned files)
-	A version info to all ACP tabs
  
### Changed
  
### Fixed
-	A wrong `colspan` definition within the cron task table
   
### Removed
  
  
## [0.0.1] - 2025-10-28
-	First working version with cron task diagnosis
