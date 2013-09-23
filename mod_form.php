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
 * The main videofile configuration form.
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    mod_videofile
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once($CFG->libdir . '/filelib.php');

class mod_videofile_mod_form extends moodleform_mod {
    /**
     * Defines the videofile instance configuration form.
     *
     * @return void
     */
    public function definition() {
        global $CFG;

        $config = get_config('videofile');
        $mform =& $this->_form;

        // Name and description fields.
        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('name'), array('size' => '48'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name',
                        get_string('maximumchars', '', 255),
                        'maxlength',
                        255,
                        'client');
        $this->add_intro_editor(false);

        // Video fields.
        $mform->addElement('header',
                           'video_fieldset',
                           get_string('video_fieldset', 'videofile'));

        // Width.
        $mform->addElement('text',
                           'width',
                           get_string('width', 'videofile'),
                           array('size' => 4));
        $mform->setType('width', PARAM_INT);
        $mform->addHelpButton('width', 'width', 'videofile');
        $mform->addRule('width', null, 'required', null, 'client');
        $mform->addRule('width', null, 'numeric', null, 'client');
        $mform->addRule('width', null, 'nonzero', null, 'client');
        $mform->setDefault('width', $config->width);

        // Height.
        $mform->addElement('text',
                           'height',
                           get_string('height', 'videofile'),
                           array('size' => 4));
        $mform->setType('height', PARAM_INT);
        $mform->addHelpButton('height', 'height', 'videofile');
        $mform->addRule('height', null, 'required', null, 'client');
        $mform->addRule('height', null, 'numeric', null, 'client');
        $mform->addRule('height', null, 'nonzero', null, 'client');
        $mform->setDefault('height', $config->height);

        // Responsive.
        $mform->addElement('advcheckbox',
                           'responsive',
                           get_string('responsive', 'videofile'),
                           get_string('responsive_label', 'videofile'));
        $mform->setType('responsive', PARAM_INT);
        $mform->addHelpButton('responsive', 'responsive', 'videofile');
        $mform->setDefault('responsive', $config->responsive);

        // Video file manager.
        $options = array('subdirs' => false,
                         'maxbytes' => 0,
                         'maxfiles' => -1,
                         'accepted_types' => array('.mp4', '.webm', '.ogv'));
        $mform->addElement(
            'filemanager',
            'videos',
            get_string('videos', 'videofile'),
            null,
            $options);
        $mform->addHelpButton('videos', 'videos', 'videofile');
        $mform->addRule('videos', null, 'required', null, 'client');

        // Posters file manager.
        $options = array('subdirs' => false,
                         'maxbytes' => 0,
                         'maxfiles' => 1,
                         'accepted_types' => array('image'));
        $mform->addElement(
            'filemanager',
            'posters',
            get_string('posters', 'videofile'),
            null,
            $options);
        $mform->addHelpButton('posters', 'posters', 'videofile');

        // Captions file manager.
        $options = array('subdirs' => false,
                         'maxbytes' => 0,
                         'maxfiles' => -1,
                         'accepted_types' => array('.vtt'));
        $mform->addElement(
            'filemanager',
            'captions',
            get_string('captions', 'videofile'),
            null,
            $options);
        $mform->addHelpButton('captions', 'captions', 'videofile');

        // Standard elements, common to all modules.
        $this->standard_coursemodule_elements();

        // Standard buttons, common to all modules.
        $this->add_action_buttons();
    }

    /**
     * Prepares the form before data are set.
     *
     * @param array $data to be set
     * @return void
     */
    public function data_preprocessing(&$defaultvalues) {
        if ($this->current->instance) {
            $options = array('subdirs' => false,
                             'maxbytes' => 0,
                             'maxfiles' => -1);
            $draftitemid = file_get_submitted_draft_itemid('videos');
            file_prepare_draft_area($draftitemid,
                                    $this->context->id,
                                    'mod_videofile',
                                    'videos',
                                    0,
                                    $options);
            $defaultvalues['videos'] = $draftitemid;

            $options = array('subdirs' => false,
                             'maxbytes' => 0,
                             'maxfiles' => 1);
            $draftitemid = file_get_submitted_draft_itemid('posters');
            file_prepare_draft_area($draftitemid,
                                    $this->context->id,
                                    'mod_videofile',
                                    'posters',
                                    0,
                                    $options);
            $defaultvalues['posters'] = $draftitemid;

            $options = array('subdirs' => false,
                             'maxbytes' => 0,
                             'maxfiles' => -1);
            $draftitemid = file_get_submitted_draft_itemid('captions');
            file_prepare_draft_area($draftitemid,
                                    $this->context->id,
                                    'mod_videofile',
                                    'captions',
                                    0,
                                    $options);
            $defaultvalues['captions'] = $draftitemid;

            if (empty($defaultvalues['width'])) {
                $defaultvalues['width'] = 800;
            }

            if (empty($defaultvalues['height'])) {
                $defaultvalues['height'] = 500;
            }
        }
    }

    /**
     * Validates the form input
     *
     * @param array $data submitted data
     * @param array $files submitted files
     * @return array eventual errors indexed by the field name
     */
    public function validation($data, $files) {
        $errors = array();

        if ($data['width'] <= 0) {
            $errors['width'] = get_string('err_positive', 'videofile');
        }

        if ($data['height'] <= 0) {
            $errors['height'] = get_string('err_positive', 'videofile');
        }

        return $errors;
    }
}
