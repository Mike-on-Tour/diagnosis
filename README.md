# MoT phpBB Diagnosis

![Version: 0.2.0](https://img.shields.io/badge/Version-0.2.0-green)  
  
![phpBB >=3.3.4, < 3.4.0@dev](https://img.shields.io/badge/phpBB->=3.3.4,%20<3.4.0@dev-009BDF)

![PHP >= 8.0.30, < 8.6.0@dev](https://img.shields.io/badge/PHP->=8.0.30,%20<8.6.0@dev-blueviolet)

<!-- [![Build Status](https://github.com/Mike-on-Tour/diagnosis/workflows/Tests/badge.svg)](https://github.com/Mike-on-Tour/diagnosis/actions) -->

MoT phpBB Diagnosis is an extension to the phpBB bulletin board which enables the admin to check several things.

## Description
MoT phpBB Diagnosis currently has two ACP tabs, one to show the status of the registered cron tasks and one to check the file attachments, please refer to the following paragraphs
to get detailed information about those tabs.
  
### Cron Status
This tab will show a table holding all cron tasks found within the service container with their names, class names and the values for the time frame between two runs and the time
of the last run, the latter one using the current user's date format.  
Underneath that table another table will show all time frames between two runs and the times of the last run of all such variables found in the CONFIG_TABLE for which the script
wasn't able to determine the corrsponding cron task.
  
### File attachments
**Important:** *Since it will take some time to read all the necessary data if you have a high number of attachments stored in your `/files` directory you will experience the loading
indicator circling for a time frame which may take up to a minute or even longer after your first click on the `File attachments` link, so please be patient and stay with us.
To avoid those loading times the data will be cached, so calling another table page or flip the tables will be enormously faster. Please be aware that deleting database items or files
will result in reading that altered data again from either the database or the `/files` directory which will again cause a high loading time.  
The unaltered data will be cached as long as the session length is set.*

This tab will show you two tables, either the table with orphaned database items (items without a corresponding file) or the table with the orphaned files (files without a
corresponding database item), you can switch between those tables via the dropdown selector field in the upright corner; the default view is the table showing the orphaned
database items.
