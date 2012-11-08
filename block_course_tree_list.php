<?php
// This file is part of course-tree-access plugin for Moodle
// http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * Course-Tree-Access block main file.
 *
 * @package    block_course_tree_list
 * @copyright  2012 Jay Huber <jhuber@colum.edu>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//require_once(dirname(__FILE__).'/consts.php');
//require_once(dirname(__FILE__).'/blocklib_content_search.php');
//require_once(dirname(__FILE__).'/blocklib_content_list.php');
//require_once(dirname(__FILE__).'/blocklib_footer.php');

class block_course_tree_list extends block_base {
    /**
    * Assign initial plugin properties.
    */
    function init() {
        $this->title = get_string('plugindisplayname', 'block_course_tree_list');
        $this->content_type = BLOCK_TYPE_TEXT;
    }

    /**
    * This method returns a boolean value that denotes whether the block 
    * wants to present a configuration interface to site admins or not.
    *
    * @return bool Returns true
    */
    function has_config() {
        return false;
    }
    
    /*
    * This method returns a boolean value, indicating whether the block is
    * allowed to have multiple instances in the same page or not.
    *
    * @return bool Returns false
    */
    function instance_allow_multiple() {
        return false;
    }

    /**
     * Set the applicable formats for this plugin.
     *
     * @return array Array of booleans for each format that is allowed or not
     */
    function applicable_formats() {
        return array('all' => true);
    }

    /**
     * Determins wether the plugin can be docked to the sidebar.
     *
     * @return boolean Returns true
     */
    function instance_can_be_docked() {
        return true;
    }

	function get_content() {
		global $CFG, $USER;
		global $DB;

		$show_weeks_before = get_config('course_tree_list', 'Weeks_Before');
		$show_weeks_after = get_config('course_tree_list', 'Weeks_After');
	
		$out = "";
		
        // Content has been computed before -> return content
        if ($this->content !== null) {
            return $this->content;
        }

		// We will eventually do something with this - maybe
		if (!isloggedin() or empty($USER->id)) {
			//not logged in - do we need this?
		}

	    if (!$courses = enrol_get_my_courses('numsections', 'visible DESC, fullname ASC')) {
			$out .= "Not Enrolled in any courses";
	    } else {
			$query = 'SELECT * FROM '.$CFG->prefix.'course_categories ORDER BY sortorder';
			$course_categories = $DB->get_records_sql($query);

			foreach ($course_categories as $cc) {
				//add the sub_id element to all objects
				$cc->sub_ids = array();
				$cc->open = "";
				$cc->sub_ids[$cc->id] = $cc->id;

				if ($cc->parent != 0) {
					$rec = $cc->parent;
					$allow_exit = 0;
					do {
						$course_categories[$rec]->sub_ids[$cc->id] = $cc->id;
						if ($course_categories[$rec]->parent != 0) {
				 			$rec = $course_categories[$rec]->parent;
						} else {
							$allow_exit = 1;
						}
					} while ($allow_exit == 0);
				}
			}

			//determine if the category should be opened - must contain a course that is available 2 weeks before or 2 weeks after start and end dates
			$one_week = 7*24*60*60;
			foreach ($courses as $course) {
				$startdate = $course->startdate - ($one_week*$show_weeks_before);
				$enddate = $course->startdate + ($one_week*($course->numsections+$show_weeks_after));

				if ((time() >= $startdate) && (time() <= $enddate)) {
					//now update all the course categories to be displayed
					foreach ($course_categories as $cc) {
						if (array_key_exists($course->category, $cc->sub_ids)) {
							$cc->open = " checked";
			}	}	}	}

			$last_course_id = 0;
			$last_course_depth = 0;
			$out .= PHP_EOL.PHP_EOL.'<ol class="tree">'.PHP_EOL;
			foreach ($course_categories as $cc) {
				$displayed = 0;
				foreach ($courses as $course) {
					if (array_key_exists($course->category, $cc->sub_ids)) {
						if ($displayed == 0) {
							$displayed = 1; 
							$depth = $cc->depth - 1;
						
							if ($last_course_depth >= $cc->depth) {
								do {
									$out .= '</ol>'.PHP_EOL;
									$out .= '</li>'.PHP_EOL;
									$last_course_depth -= 1;
								} while ($last_course_depth != ($cc->depth - 1));
							}

							$out .= '<li>'.PHP_EOL;
							$out .= '<label title="'.$cc->name.'" for="category'.$cc->id.'">'.$cc->name.'</label><input type="checkbox"'.$cc->open.' id="category'.$cc->id.'" />'.PHP_EOL;
							$out .= '<ol>'.PHP_EOL;
							$last_course_depth = $cc->depth;
					}	}
					if ($course->category == $cc->id) {
						$url = $CFG->wwwroot.'/course/view.php?id='.$course->id;
						$out .= '<li class="course"><a href="'.$url.'" title="'.$course->shortname.'">'.$course->fullname.'</a></li>'.PHP_EOL;
				}	}
			}

			$out .= '</ol>'.PHP_EOL.PHP_EOL;
		}

		$this->content->text = $out;
		
	}

}