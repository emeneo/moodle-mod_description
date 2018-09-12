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
 * Library of functions and constants for module description
 *
 * @package    mod
 * @subpackage description
 * @copyright  emeneo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/* DESCRIPTION_MAX_NAME_LENGTH = 50 */
define("DESCRIPTION_MAX_NAME_LENGTH", 50);

require_once("$CFG->libdir/filelib.php");
/**
 * @uses DESCRIPTION_MAX_NAME_LENGTH
 * @param object $desc
 * @return string
 */
function get_description_name($desc) {
    $name = get_string('modulename', 'description');
    return $name;
}
/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @global object
 * @param object $desc
 * @return bool|int
 */
function description_add_instance($desc) {
    global $DB;

    $desc->name = get_description_name($desc);
    $desc->timemodified = time();

    return $DB->insert_record("description", $desc);
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @global object
 * @param object $desc
 * @return bool
 */
function description_update_instance($desc) {
    global $DB;

    $desc->name = get_description_name($desc);
    $desc->timemodified = time();
    $desc->intro = '';
    $desc->id = $desc->instance;

    return $DB->update_record("description", $desc);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @global object
 * @param int $id
 * @return bool
 */
function description_delete_instance($id) {
    global $DB;

    if (! $description = $DB->get_record("description", array("id" => $id))) {
        return false;
    }

    $result = true;

    if (! $DB->delete_records("description", array("id" => $description->id))) {
        $result = false;
    }

    return $result;
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 * See get_array_of_activities() in course/lib.php
 *
 * @global object
 * @param object $coursemodule
 * @return cached_cm_info|null
 */
function description_get_coursemodule_info($coursemodule) {
    global $DB, $CFG, $COURSE;
    if ($desc = $DB->get_record('description', array('id' => $coursemodule->instance), 'id, name, intro, introformat, course')) {
        if (empty($desc->name)) {
            /*description name missing, fix it*/
            $desc->name = "description{$desc->id}";
            $DB->set_field('description', 'name', $desc->name, array('id' => $desc->id));
        }
        $info = new cached_cm_info();
        /*no filtering hre because this info is cached and filtered later*/
        $coursecontext = context_course::instance($desc->course, MUST_EXIST);
        $COURSE = $DB->get_record('course',array('id'=> $coursemodule->course));
        $summary = $COURSE->summary;
        $desc->intro = '<div><h1>'.$COURSE->fullname.'</h1>'.$summary.'</div>';

        $module = 'description';
        $activity = $desc;
        $context = context_module::instance($coursemodule->id);
        $options = array('noclean' => true, 'para' => false, 'filter' => false, 'context' => $context, 'overflowdiv' => true);
        $intro = file_rewrite_pluginfile_urls($activity->intro, 'pluginfile.php', $coursecontext->id, 'course', 'summary', null);
        $info->content = trim(format_text($intro, $activity->introformat, $options, null));

        $info->name  = $desc->name;
        return $info;
    } else {
        return null;
    }
}

/**
 * @return array
 */
function description_get_view_actions() {
    return array();
}

/**
 * @return array
 */
function description_get_post_actions() {
    return array();
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 *
 * @param object $data the data submitted from the reset course.
 * @return array status array
 */
function description_reset_userdata($data) {
    return array();
}

/**
 * Returns all other caps used in module
 *
 * @return array
 */
function description_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * @uses FEATURE_IDNUMBER
 * @uses FEATURE_GROUPS
 * @uses FEATURE_GROUPINGS
 * @uses FEATURE_GROUPMEMBERSONLY
 * @uses FEATURE_MOD_INTRO
 * @uses FEATURE_COMPLETION_TRACKS_VIEWS
 * @uses FEATURE_GRADE_HAS_GRADE
 * @uses FEATURE_GRADE_OUTCOMES
 * @param string $feature FEATURE_xx constant for requested feature
 * @return bool|null True if module supports feature, false if not, null if doesn't know
 */
function description_supports($feature) {
    switch ($feature) {
        case FEATURE_IDNUMBER:{
            return false;
        }
        case FEATURE_GROUPS:{
            return false;
        }
        case FEATURE_GROUPINGS:{
            return false;
        }
        case FEATURE_GROUPMEMBERSONLY:{
            return true;
        }
        case FEATURE_MOD_INTRO:{
            return false;
        }
        case FEATURE_COMPLETION_TRACKS_VIEWS:{
            return false;
        }
        case FEATURE_GRADE_HAS_GRADE:{
            return false;
        }
        case FEATURE_GRADE_OUTCOMES:{
            return false;
        }
        case FEATURE_MOD_ARCHETYPE:{
            return MOD_ARCHETYPE_RESOURCE;
        }
        case FEATURE_BACKUP_MOODLE2:{
            return true;
        }
        case FEATURE_NO_VIEW_LINK:{
            return true;
        }
        default:{
            return null;
        }
    }
}