# Change Log
All changes to `MoT phpBB Diagnosis` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [0.2.0] - 2026-02-08

### Added
-	A loading indicator to the attachments tab to show the user that something is happening when we need some time to load and sift through all the arrays to compare files and DB
-	Sorting key and directions selectors to the 'File attachments' tables
-	A column to the orphaned items table holding the user id of the user who posted that attachment, table can be sorted by this column as well
  
### Changed
-	Caching is now done using individual files and not the global data file
-	Time-to-live (TTL) for the cached data is now set to the session length and no longer a set value
  
### Fixed
-	A wrong `colspan` definition within the orphaned files table
-	A wrong language variable within the orphaned files table
   
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
