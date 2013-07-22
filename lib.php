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
 * Library of interface functions and constants for module videofile
 *
 * All the core Moodle functions, neeeded to allow the module to work
 * integrated in Moodle should be placed here.
 *
 * All the videofile specific functions, needed to implement all the module
 * logic, should go to locallib.php. This will help to save some memory when
 * Moodle is performing actions across all modules.
 *
 * @package    mod_videofile
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Returns whether the module supports a feature or not.
 *
 * @see plugin_supports() in lib/moodlelib.php
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if feature is supported, null if unknown
 */
function videofile_supports($feature) {
    switch ($feature) {
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        case FEATURE_GRADE_OUTCOMES:
            return false;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_GROUPS:
            return false;
        case FEATURE_GROUPINGS:
            return false;
        case FEATURE_GROUPMEMBERSONLY:
            return true;
        case FEATURE_MOD_ARCHETYPE:
            return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;

        default:
            return null;
    }
}

/**
 * Adds a videofile instance
 *
 * @param stdClass $data
 * @param mod_videofile_mod_form $form
 * @return int The instance id of the new videofile instance
 */
function videofile_add_instance(stdClass $data,
                                mod_videofile_mod_form $form = null) {
    require_once(dirname(__FILE__) . '/locallib.php');

    $context = context_module::instance($data->coursemodule);
    $videofile = new videofile($context, null, null);

    return $videofile->add_instance($data);
}

/**
 * Updates an instance of the videofile in the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param stdClass $data
 * @param mod_videofile_mod_form $form
 * @return boolean
 */
function videofile_update_instance(stdClass $data,
                                   mod_videofile_mod_form $form = null) {
    require_once(dirname(__FILE__) . '/locallib.php');

    $context = context_module::instance($data->coursemodule);
    $videofile = new videofile($context, null, null);

    return $videofile->update_instance($data);
}

/**
 * Deletes an instance of the videofile from the database
 *
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean
 */
function videofile_delete_instance($id) {
    require_once(dirname(__FILE__) . '/locallib.php');

    $cm = get_coursemodule_from_instance('videofile', $id, 0, false, MUST_EXIST);
    $context = context_module::instance($cm->id);
    $videofile = new videofile($context, null, null);
    return $videofile->delete_instance();
}

/**
 * Returns a small object with summary information about what a
 * user has done with a given particular instance of this module.
 *
 * Used for user activity reports.
 *
 * @param stdClass $course
 * @param stdClass $user
 * @param stdClass $coursemodule
 * @param stdClass $videofile
 * @return stdClass|null [->time and ->info: short text description]
 */
function videofile_user_outline($course, $user, $mod, $videofile) {
    global $DB;

    $logs = $DB->get_records(
        'log',
        array('userid' => $user->id,
              'module' => 'videofile',
              'action' => 'view',
              'info' => $videofile->id),
        'time ASC');
    if ($logs) {
        $numviews = count($logs);
        $lastlog = array_pop($logs);

        $result = new stdClass();
        $result->time = $lastlog->time;
        $result->info = get_string('numviews', '', $numviews);

        return $result;
    }
    return null;
}

/**
 * Prints a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @param stdClass $course The current course record
 * @param stdClass $user The record of the user we are generating report for
 * @param cm_info $mod Course module info
 * @param stdClass $videofile The module instance record
 * @return void Is supposed to echo directly
 */
function videofile_user_complete($course, $user, $mod, $videofile) {
    global $DB;

    $logs = $DB->get_records(
        'log',
        array('userid' => $user->id,
              'module' => 'videofile',
              'action' => 'view',
              'info' => $videofile->id),
        'time ASC');

    if ($logs) {
        $numviews = count($logs);
        $lastlog = array_pop($logs);

        $strmostrecently = get_string('mostrecently');
        $strnumviews = get_string('numviews', '', $numviews);

        echo "$strnumviews - $strmostrecently ".userdate($lastlog->time);
    } else {
        print_string('neverseen', 'videofile');
    }
}

/**
 * Returns all other capabilities used by this module.
 *
 * @return array Array of capability strings
 */
function videofile_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 *
 * See {@link get_array_of_activities()} in course/lib.php
 *
 * @param cm_info $coursemodule
 * @return cached_cm_info An object on information that the courses
 *                        will know about (most noticeably, an icon).
 */
function videofile_get_coursemodule_info($coursemodule) {
    global $DB;

    $dbparams = array('id' => $coursemodule->instance);
    $fields = 'id, name, intro, introformat';

    if (!$videofile = $DB->get_record('videofile', $dbparams, $fields)) {
        return false;
    }

    $result = new cached_cm_info();
    $result->name = $videofile->name;
    if ($coursemodule->showdescription) {
        // Convert intro to html.
        // Do not filter cached version, filters run at display time.
        $result->content = format_module_intro('videofile',
                                               $videofile,
                                               $coursemodule->id,
                                               false);
    }

    return $result;
}

/**
 * Return the list of view actions
 *
 * @return array
 *
 * @catgory  code
 *
 * @since   0.0.1
 */
function videofile_get_view_actions() {
    return array('view', 'view help');
}

/**
 * List of update style log actions
 * @return array
 */
function videofile_get_post_actions() {
    return array('update', 'add');
}

/**
 * Returns the lists of all browsable file areas within the given module context
 *
 * The file area 'intro' for the activity introduction field is added automatically
 * by {@link file_browser::get_file_info_context_module()}
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @return array Array of [(string)filearea] => (string)description]
 */
function videofile_get_file_areas($course, $cm, $context) {
    return array(
        'captions' => get_string('filearea_captions', 'videofile'),
        'posters' => get_string('filearea_posters', 'videofile'),
        'videos' => get_string('filearea_videos', 'videofile'),
    );
}

/**
 * File browsing support for videofile file areas.
 *
 * @param file_browser $browser File browser object
 * @param array $areas File areas
 * @param stdClass $course Course object
 * @param stdClass $cm Course module
 * @param stdClass $context Context module
 * @param string $filearea File area
 * @param int $itemid Item ID
 * @param string $filepath File path
 * @param string $filename File name
 * @return file_info Instance or null if not found
 */
function videofile_get_file_info($browser,
                                 $areas,
                                 $course,
                                 $cm,
                                 $context,
                                 $filearea,
                                 $itemid,
                                 $filepath,
                                 $filename) {
    global $CFG;

    if ($context->contextlevel != CONTEXT_MODULE) {
        return null;
    }

    // Filearea must contain a real area.
    if (!isset($areas[$filearea])) {
        return null;
    }

    if (!has_capability('moodle/course:managefiles', $context)) {
        // Students can not peek here!
        return null;
    }

    $fs = get_file_storage();
    if ($filearea === 'posters' || $filearea === 'captions' || $filearea === 'videos') {
        $filepath = is_null($filepath) ? '/' : $filepath;
        $filename = is_null($filename) ? '.' : $filename;

        if (!$storedfile = $fs->get_file($context->id,
                                         'mod_videofile',
                                         $filearea,
                                         0,
                                         $filepath,
                                         $filename)) {
            // Not found.
            return null;
        }

        $urlbase = $CFG->wwwroot . '/pluginfile.php';

        return new file_info_stored($browser,
                                    $context,
                                    $storedfile,
                                    $urlbase,
                                    $areas[$filearea],
                                    false,
                                    true,
                                    true,
                                    false);
    }

    // Not found.
    return null;
}

/**
 * Serves the files from the videofile file areas.
 *
 * @param stdClass $course The course object
 * @param stdClass $cm The course module object
 * @param stdClass $context The videofile's context
 * @param string $filearea The name of the file area
 * @param array $args Extra arguments (itemid, path)
 * @param bool $forcedownload Whether or not force download
 * @param array $options Additional options affecting the file serving
 * @return bool False if file not found, does not return if found -
 *              just sends the file
 */
function videofile_pluginfile($course,
                              $cm,
                              $context,
                              $filearea,
                              array $args,
                              $forcedownload,
                              array $options=array()) {
    global $CFG, $DB, $USER;

    require_once(dirname(__FILE__) . '/locallib.php');

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_login($course, true, $cm);

    if (!has_capability('mod/videofile:view', $context)) {
        return false;
    }

    if ($filearea !== 'videos' && $filearea !== 'captions' && $filearea !== 'posters') {
        // Intro is handled automatically in pluginfile.php.
        return false;
    }

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = rtrim('/' . $context->id . '/mod_videofile/' . $filearea . '/' .
                      $relativepath, '/');
    $file = $fs->get_file_by_hash(sha1($fullpath));

    if (!$file || $file->is_directory()) {
        return false;
    }

    // Default cache lifetime is 86400s.
    send_stored_file($file);
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 *
 * @param $data The data submitted from the reset course.
 * @return array Status array
 */
function videofile_reset_userdata($data) {
    return array();
}
