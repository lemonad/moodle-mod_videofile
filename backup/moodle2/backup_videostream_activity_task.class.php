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
 * Defines backup_ng_videofile_activity_task class
 *
 * @package    mod_ng_videofile
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot .
             '/mod/ng_videofile/backup/moodle2/backup_ng_videofile_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the ng_videofile instance
 */
class backup_ng_videofile_activity_task extends backup_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No specific settings for this activity.
    }

    /**
     * Define (add) particular steps this activity can have
     *
     * Defines a backup step to store the instance data in the ng_videofile.xml file
     */
    protected function define_my_steps() {
        $this->add_step(
            new backup_ng_videofile_activity_structure_step('ng_videofile_structure',
                                                         'ng_videofile.xml'));
    }

    /**
     * Code the transformations to perform in the activity in
     * order to get transportable (encoded) links (encodes URLs
     * to the index.php and view.php scripts).
     *
     * @param string $content Some HTML text that eventually contains URLs
     *                        to the activity instance scripts
     * @return string The content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        // Link to the list of ng_videofiles.
        $search = "/(" . $base . "\/mod\/ng_videofile\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@ng_videofileINDEX*$2@$', $content);

        // Link to ng_videofile view by moduleid.
        $search = "/(" . $base . "\/mod\/ng_videofile\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@ng_videofileVIEWBYID*$2@$', $content);

        return $content;
    }
}
