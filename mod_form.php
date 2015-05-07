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

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once("$CFG->libdir/filelib.php");

class mod_description_mod_form extends moodleform_mod {
    public function definition() {
        global $CFG, $DB;

        $update = optional_param('update', 0, PARAM_INT);
        if (@$update != '') {
            $cm = get_coursemodule_from_id('', $update, 0, false, MUST_EXIST);
            $courseid = $cm->course;
        } else {
            $courseid = optional_param('course', 0, PARAM_INT);
        }
        $course = $DB->get_record("course", array("id" => $courseid));

        $context = context_course::instance($courseid, MUST_EXIST);
        $coursesummary = file_rewrite_pluginfile_urls($course->summary, 'pluginfile.php', $context->id, 'course', 'summary', null);

        $this->current->introeditor['text'] = '';
        $mform = $this->_form;

        $mform->addElement('html', '<div><h1>'.$course->fullname.'</h1>'.$coursesummary.'</div>');
        $this->standard_coursemodule_elements();
        $this->add_action_buttons(true, false, null);
    }
}
