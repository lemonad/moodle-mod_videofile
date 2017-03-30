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
 * Prints a particular instance of ng_videofile
 *
 * @package    mod_ng_videofile
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');

$id = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id('ng_videofile', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$context = context_module::instance($cm->id);
$ng_videofile = new ng_videofile($context, $cm, $course);

require_login($course, true, $cm);
require_capability('mod/ng_videofile:view', $context);

$PAGE->set_pagelayout('incourse');

$url = new moodle_url('/mod/ng_videofile/view.php', array('id' => $id));
$PAGE->set_url('/mod/ng_videofile/view.php', array('id' => $cm->id));

// Update 'viewed' state if required by completion system.
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

// Log viewing.
//add_to_log($course->id,
//           'ng_videofile',
//           'view',
//           'view.php?id=' . $cm->id,
//           $ng_videofile->get_instance()->id, $cm->id);

$event = \mod_ng_videofile\event\video_view::create(array(
    'objectid' => $ng_videofile->get_instance()->videoid,
    'context' => context_module::instance($cm->id)
));
$event->trigger();


$renderer = $PAGE->get_renderer('mod_ng_videofile');
echo $renderer->video_page($ng_videofile);
