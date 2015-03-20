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
 * Add description form
 *
 * @package    mod
 * @subpackage description
 * @copyright  emeneo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once ($CFG->dirroot.'/course/moodleform_mod.php');

class mod_description_mod_form extends moodleform_mod {

    function definition() {
    	global $DB,$CFG;

    	if(@$_GET['update']){
    		$update = $_GET['update'];
    		$cm = get_coursemodule_from_id('', $update, 0, false, MUST_EXIST);
    		$courseId = $cm->course;
    	}else{
    		$courseId = $_REQUEST['course'];
    	}
    	
    	$course = $DB->get_record("course", array("id"=>$courseId));

        $context = context_course::instance($courseId, MUST_EXIST);
        $course_summary = $course->summary;
        $course_summary = str_replace('@@PLUGINFILE@@', $CFG->wwwroot.'/pluginfile.php/'.$context->id.'/course/summary/', $course_summary);
        $course_summary = str_replace('text-align: center;', 'text-align: left;', $course_summary);

    	$this->current->introeditor['text'] = '';
        $mform = $this->_form;

        $mform->addElement('html', '<script src="'.$CFG->wwwroot.'/mod/description/static/jquery.min.js"></script>');
        $mform->addElement('html', '<link rel="stylesheet" type="text/css" href="'.$CFG->wwwroot.'/mod/description/static/style.css">');

        $mform->addElement('html', '<div class="course_description"><h1>'.$course->fullname.'</h1>'.$course_summary.'</div>');

        $this->standard_coursemodule_elements();
//-------------------------------------------------------------------------------
// buttons
        $this->add_action_buttons(true, false, null);

    }

}
