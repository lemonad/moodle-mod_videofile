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
 * ng_videofile module admin settings and defaults.
 *
 * @package    mod_ng_videofile
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
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
        new admin_setting_heading('ng_videofile_defaults',
                                  get_string('ng_videofile_defaults_heading', 'ng_videofile'),
                                  get_string('ng_videofile_defaults_text', 'ng_videofile')));

    // Default width.
    $settings->add(
        new admin_setting_configtext('ng_videofile/width',
                                     get_string('width', 'ng_videofile'),
                                     get_string('width_explain', 'ng_videofile'),
                                     800,
                                     PARAM_INT,
                                     7));

    // Default height.
    $settings->add(
        new admin_setting_configtext('ng_videofile/height',
                                     get_string('height', 'ng_videofile'),
                                     get_string('height_explain', 'ng_videofile'),
                                     500,
                                     PARAM_INT,
                                     7));

    // Default responsive flag.
    $settings->add(
        new admin_setting_configcheckbox('ng_videofile/responsive',
                                         get_string('responsive', 'ng_videofile'),
                                         get_string('responsive_explain', 'ng_videofile'),
                                         0));

    // Default use width/height as max-width/height when in responsive mode flag.
    $settings->add(
        new admin_setting_configcheckbox('ng_videofile/limitdimensions',
                                         get_string('limitdimensions', 'ng_videofile'),
                                         get_string('limitdimensions_explain', 'ng_videofile'),
                                         0));
										 
	// dash or hls
	$settings->add(
		new admin_setting_configselect('ng_videofile/streaming',
        get_string('streaming_protocol', 'ng_videofile'), '', '', array("dash"=>"dash","hls"=>"hls")));
		
	// Dash base URL
    $settings->add(
        new admin_setting_configtext('ng_videofile/dash_base_url',
                                     get_string('dash_base_url', 'ng_videofile'),
                                     get_string('dash_base_url_explain', 'ng_videofile'),
                                     "",
                                     PARAM_RAW
                                     ));
	
	// HLS base URL
    $settings->add(
        new admin_setting_configtext('ng_videofile/hls_base_url',
                                     get_string('hls_base_url', 'ng_videofile'),
                                     get_string('hls_base_url_explain', 'ng_videofile'),
                                     "",
                                     PARAM_RAW
                                     ));
}
