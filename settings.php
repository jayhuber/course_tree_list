<?php  
// This file is part of Moodle - http://moodle.org/
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
 * Contains administration settings options.
 *
 * @package    block_course_tree_list
 * @copyright  2012 Jay Huber <jhuber@colum.edu>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings->add(new admin_setting_configtext('course_tree_list/Weeks_Before',
        get_string('weeksbefore', 'block_course_tree_list'), get_string('descweeksbefore', 'block_course_tree_list'),
        2, PARAM_INT));

$settings->add(new admin_setting_configtext('course_tree_list/Weeks_After',
        get_string('weeksafter', 'block_course_tree_list'), get_string('descweeksafter', 'block_course_tree_list'),
        2, PARAM_INT));



