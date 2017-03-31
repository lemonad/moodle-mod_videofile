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
 * Define all the backup steps that will be used by the
 * backup_videostream_activity_task.
 *
 * @package    mod_videostream
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Define the complete videostream structure for backup, with file and id annotations
 */
class backup_videostream_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {
        // Define each element separated.
        $videostream = new backup_nested_element('videostream', array('id'), array(
            'name', 'intro', 'introformat',
            'width', 'height','responsive','videoid',
            'timecreated', 'timemodified'));

        // Define sources.
        $videostream->set_source_table('videostream',
                                     array('id' => backup::VAR_ACTIVITYID));

        // Define file annotations.
        //$videostream->annotate_files('mod_videostream', 'intro', null);
        //$videostream->annotate_files('mod_videostream', 'videos', null);
        //$videostream->annotate_files('mod_videostream', 'posters', null);
        //$videostream->annotate_files('mod_videostream', 'captions', null);

        // Return the root element (videostream), wrapped into standard
        // activity structure.
        return $this->prepare_activity_structure($videostream);
    }
}
