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
 *
 * restore stepslib
 *
 * @package mod_description
 * @copyright emeneo
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 *
 * Restore strucutre class
 *
 * Define all the restore steps that will be used by the restore_url_activity_task
 */
class restore_description_activity_structure_step extends restore_activity_structure_step {
	
/**
 * 
 * Restore structure function
 * 
 * Structure step to restore one description activity
 */
    protected function define_structure() {

        $paths = array();
        $paths[] = new restore_path_element('description', '/activity/description');

        /*Return the paths wrapped into standard activity structure*/
        return $this->prepare_activity_structure($paths);
    }
	
/**
 * 
 * Process description function
 *
 * Function to describe process_description
 * @param array $data
 * 
 */
    protected function process_description($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        /*insert the description record*/
        $newitemid = $DB->insert_record('description', $data);
        /*immediately after inserting "activity" record, call this*/
        $this->apply_activity_instance($newitemid);
    }
/**
 * 
 * After execute function
 * 
 */
    protected function after_execute() {
        /*Add description related files, no need to match by itemname (just internally handled context)*/
        $this->add_related_files('mod_description', 'intro', null);
    }

}
