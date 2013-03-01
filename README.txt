Readme file for the course-tree-access block
=============================================

A plugin for the learning management system moodle to provide individual 
course assortment for its users.

- @package    block_course_tree_list
- @copyright  2013 Jay Huber <jhuber@colum.edu>
- @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later


Description
-----------
This plugin addresses the navigation problem for users that are enrolled in a 
lot of courses on a moodle site.

The hierarchy expands to courses in progress, and will display based on admin 
settings to display active courses for x number of weeks before they start
and after they complete.

It builds a hierarchy collapsable/expandable menu based on the categories.
The menu was designed entirely with CSS, and works for all browsers except for IE 8 
and below.  In that instance, javascript is a necessary evil.

 
Code Location
-------------
You can always find the latest version at: https://github.com/jayhuber/course_tree_list
Moodle plugins will notify you as I update the code on Moodle.org


Bug Reports
-----------
Report all bugs on https://github.com/jayhuber/course_tree_list/issues


Installation
------------
- Copy the "course_tree_list" folder into the "moodle/blocks" directory
- Visit your moodle site in a browser, logged in as an administrator.
- Go to "Site Administration > Notifications > Continue"
- Add the "course-tree-access" block. 

Currently, No Tables are created for the use of this block.

Changelog
---------
v2013011600:
-Error with missing $ie variable causing other browsers beside Internet Explorer to display "undefined variable"
-This fix is credited to Aleksandra Ferenz - Thank You!
-Reversed the README list, so the recent change is at the top

v2013011101:
-Found has_config was set to false and should have been true.  Affecting Moodle 2.4 installs
-Added 2 weeks as default value in case the Moodle config values are missing.
-IE7 & 8 Fixes
-The Previous version did not fix the IE problem, as my test environment had jquery running
 causing selectivizr.js to work, which it will not with YUI.  Im not so good at YUI.  So,
 the IE8 detect also adds the script from Google for jquery so this fix will now work.
-Will need to revisit this fix in the future, but, it is good enough now.

v2013011100:
-Added IE detection to PHP code and cause selectivizer-min.js to load if version 8 or below

v2012120600:
-Modified block_course_tree_list.php for version 2.4 use as db field was removed.  
-Added db/access.php file as required

v2012110900:
- Disabled the block from displaying for guest accounts

v2012110800:
- Initial Version

v2013022800
- Fixing Strict Warning
- Upgrade Release to Stable

v2013030100
- Last fix - caused reverse error in 2.3 or less so added branch check

Release notes
-------------
v2013030100
- Stable Release

v2013022800
- Stable Release

v2013011600
- Release Candidate

v2013011100:
- Release Candidate

v2012110800:
- Release Candidate

v2012110900:
- Release Candidate

v2012120600
- Release Candidate