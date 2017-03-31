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
 * backup_ng_videofile_activity_task.
 *
 * @package    mod_ng_videofile
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Define the complete ng_videofile structure for backup, with file and id annotations
 */
class backup_ng_videofile_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {
        // Define each element separated.
        $ng_videofile = new backup_nested_element('ng_videofile', array('id'), array(
            'name', 'intro', 'introformat',
            'width', 'height','responsive','videoid',
            'timecreated', 'timemodified'));

        // Define sources.
        $ng_videofile->set_source_table('ng_videofile',
                                     array('id' => backup::VAR_ACTIVITYID));

        // Define file annotations.
        //$ng_videofile->annotate_files('mod_ng_videofile', 'intro', null);
        //$ng_videofile->annotate_files('mod_ng_videofile', 'videos', null);
        //$ng_videofile->annotate_files('mod_ng_videofile', 'posters', null);
        //$ng_videofile->annotate_files('mod_ng_videofile', 'captions', null);

        // Return the root element (ng_videofile), wrapped into standard
        // activity structure.
        return $this->prepare_activity_structure($ng_videofile);
    }
}
