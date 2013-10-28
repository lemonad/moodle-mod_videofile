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
 * Prints a particular instance of videofile
 *
 * @package    mod_videofile
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');

$id = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id('videofile', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$context = context_module::instance($cm->id);
$videofile = new videofile($context, $cm, $course);

require_login($course, true, $cm);
require_capability('mod/videofile:view', $context);

$PAGE->set_pagelayout('incourse');

$url = new moodle_url('/mod/videofile/view.php', array('id' => $id));
$PAGE->set_url('/mod/videofile/view.php', array('id' => $cm->id));

// Update 'viewed' state if required by completion system.
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

// Log viewing.
add_to_log($course->id,
           'videofile',
           'view',
           'view.php?id=' . $cm->id,
           $videofile->get_instance()->id, $cm->id);

$renderer = $PAGE->get_renderer('mod_videofile');
echo $renderer->video_page($videofile);
