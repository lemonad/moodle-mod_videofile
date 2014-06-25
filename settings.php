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
 * Videofile module admin settings and defaults.
 *
 * @package    mod_videofile
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once($CFG->libdir . '/resourcelib.php');

    $displayoptions = resourcelib_get_displayoptions(
        array(RESOURCELIB_DISPLAY_OPEN, RESOURCELIB_DISPLAY_POPUP));
    $defaultdisplayoptions = array(RESOURCELIB_DISPLAY_OPEN);

    // Heading.
    $settings->add(
        new admin_setting_heading('videofile_defaults',
                                  get_string('videofile_defaults_heading', 'videofile'),
                                  get_string('videofile_defaults_text', 'videofile')));

    // Default width.
    $settings->add(
        new admin_setting_configtext('videofile/width',
                                     get_string('width', 'videofile'),
                                     get_string('width_explain', 'videofile'),
                                     800,
                                     PARAM_INT,
                                     7));

    // Default height.
    $settings->add(
        new admin_setting_configtext('videofile/height',
                                     get_string('height', 'videofile'),
                                     get_string('height_explain', 'videofile'),
                                     500,
                                     PARAM_INT,
                                     7));

    // Default responsive flag.
    $settings->add(
        new admin_setting_configcheckbox('videofile/responsive',
                                         get_string('responsive', 'videofile'),
                                         get_string('responsive_explain', 'videofile'),
                                         0));

    // Default use width/height as max-width/height when in responsive mode flag.
    $settings->add(
        new admin_setting_configcheckbox('videofile/limitdimensions',
                                         get_string('limitdimensions', 'videofile'),
                                         get_string('limitdimensions_explain', 'videofile'),
                                         0));
}
