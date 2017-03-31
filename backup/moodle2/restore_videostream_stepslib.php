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
 * @package    mod_videostream
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Define all the restore steps that will be used by the
 * restore_videostream_activity_task.
 */

/**
 * Structure step to restore one videostream activity.
 */
class restore_videostream_activity_structure_step extends restore_activity_structure_step {

    /**
     * Defines the backup structure.
     *
     * @return array
     */
    protected function define_structure() {
        $paths = array();
        $paths[] = new restore_path_element('videostream', '/activity/videostream');

        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }

    /**
     * Restore videostream.
     */
    protected function process_videostream($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        $data->timecreated = $this->apply_date_offset($data->timecreated);
        $data->timemodified = $this->apply_date_offset($data->timemodified);

        // Insert the videostream record.
        $newitemid = $DB->insert_record('videostream', $data);

        // Immediately after inserting "activity" record, call this.
        $this->apply_activity_instance($newitemid);
    }

    /**
     * Adds related files after restore.
     */
    protected function after_execute() {
        // Add related files, no need to match by itemname (just
        // internally handled context).
        $this->add_related_files('mod_videostream', 'intro', null);
        $this->add_related_files('mod_videostream', 'videos', null);
        $this->add_related_files('mod_videostream', 'posters', null);
        $this->add_related_files('mod_videostream', 'captions', null);
    }
}
