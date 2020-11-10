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
 * Process ajax requests
 *
 * @package    mod_videostream
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('AJAX_SCRIPT')) {
    define('AJAX_SCRIPT', true);
}

//<tovi
global $CFG, $DB;
require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/completionlib.php');
//tovi>

//require(__DIR__.'/../../config.php');
global $CFG;
require_once($CFG->dirroot . '/lib/completionlib.php');

$mid = required_param('mid', PARAM_INT);
$videoid = required_param('videoid', PARAM_INT);
$action = optional_param('action', '', PARAM_ALPHA);
$sesskey = optional_param('sesskey', false, PARAM_TEXT);

$cm = get_coursemodule_from_id('videostream', $mid); //, 0, false, MUST_EXIST);

require_sesskey();

$context = context_module::instance($cm->id);
//Tovi
if ($action == 'ended') {
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $completion = new completion_info($course);
    $completion->set_module_viewed($cm);
}
//Tovi>
$return = false;

// log it.
$event = \mod_videostream\event\video_view::create(array(
        'objectid' => $videoid,
        'context' => $context,
        'other' => $action
    ));
$event->trigger();
$return = 1;

echo json_encode($return);
die;
