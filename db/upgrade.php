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
 * This file keeps track of upgrades to the videostream module.
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package    mod_videostream
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute videostream upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_videostream_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    // Added width and height fields.
    if ($oldversion < 2013071701) {
        $table = new xmldb_table('videostream');
        $widthfield = new xmldb_field('width',
                                      XMLDB_TYPE_INTEGER,
                                      '4',
                                      XMLDB_UNSIGNED,
                                      XMLDB_NOTNULL,
                                      null,
                                      '800',
                                      'introformat');
        $heightfield = new xmldb_field('height',
                                       XMLDB_TYPE_INTEGER,
                                       '4',
                                       XMLDB_UNSIGNED,
                                       XMLDB_NOTNULL,
                                       null,
                                       '500',
                                       'width');

        // Add width field.
        if (!$dbman->field_exists($table, $widthfield)) {
            $dbman->add_field($table, $widthfield);
        }

        // Add height field.
        if (!$dbman->field_exists($table, $heightfield)) {
            $dbman->add_field($table, $heightfield);
        }

        /* Once we reach this point, we can store the new version and
           consider the module upgraded to the version 2013071701 so the
           next time this block is skipped. */
        upgrade_mod_savepoint(true, 2013071701, 'videostream');
    }

    // Added responsive flag field.
    if ($oldversion < 2013092200) {
        $table = new xmldb_table('videostream');
        $responsivefield = new xmldb_field('responsive',
                                           XMLDB_TYPE_INTEGER,
                                           '4',
                                           XMLDB_UNSIGNED,
                                           XMLDB_NOTNULL,
                                           null,
                                           '0',
                                           'height');

        // Add field if it doesn't already exist.
        if (!$dbman->field_exists($table, $responsivefield)) {
            $dbman->add_field($table, $responsivefield);
        }

        /* Once we reach this point, we can store the new version and
           consider the module upgraded to the version 2013092200 so the
           next time this block is skipped. */
        upgrade_mod_savepoint(true, 2013092200, 'videostream');
    }

    // Added responsive flag field.
    if ($oldversion < 2017060403) {
        $table = new xmldb_table('videostream');
        $responsivefield = new xmldb_field('inline',
                                           XMLDB_TYPE_INTEGER,
                                           '1',
                                           null,
                                           null,
                                           null,
                                           null,
                                           'height');

        // Add field if it doesn't already exist.
        if (!$dbman->field_exists($table, $responsivefield)) {
            $dbman->add_field($table, $responsivefield);
        }

        /* Once we reach this point, we can store the new version and
           consider the module upgraded to the version 2013092200 so the
           next time this block is skipped. */
        upgrade_mod_savepoint(true, 2017060403, 'videostream');
    }

	if ($oldversion < 2017060404) {

        // Define table videostreambookmarks to be created.
        $table = new xmldb_table('videostreambookmarks');

        // Adding fields to table videostreambookmarks.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('bookmarkposition', XMLDB_TYPE_NUMBER, '12, 6', null, null, null, null);
        $table->add_field('bookmarkname', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('bookmarkflag', XMLDB_TYPE_INTEGER, '1', null, null, null, null);

        // Adding keys to table videostreambookmarks.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for videostreambookmarks.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Videostream savepoint reached.
        upgrade_mod_savepoint(true, 2017060404, 'videostream');
    }

    if ($oldversion < 2017060405) {

        // Define field moduleid to be added to videostreambookmarks.
        $table = new xmldb_table('videostreambookmarks');
        $field = new xmldb_field('moduleid', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'userid');

        // Conditionally launch add field moduleid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Videostream savepoint reached.
        upgrade_mod_savepoint(true, 2017060405, 'videostream');
    }
// Tovi.
    if ($oldversion < 2020070600) {

        // update table videostreambookmarks to be created.
        $table = new xmldb_table('videostreambookmarks');

        // Adding fields to table videostreambookmarks.
        $field = new xmldb_field('teacherid', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'userid');

        // Conditionally launch add field moduleid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Videostream savepoint reached.
        upgrade_mod_savepoint(true, 2020070600, 'videostream');
    }

    // Added disableseek flag field.
    if ($oldversion < 2020070601) {
        $table = new xmldb_table('videostream');
        $disableseekfield = new xmldb_field('disableseek',
                                           XMLDB_TYPE_INTEGER,
                                           '4',
                                           null,
                                           null,
                                           null,
                                           '0');

        // Add field if it doesn't already exist.
        if (!$dbman->field_exists($table, $disableseekfield)) {
            $dbman->add_field($table, $disableseekfield);
        }
        upgrade_mod_savepoint(true, 2020070601, 'videostream');
    }

    // Final return of upgrade result (true, all went good) to Moodle.
    return true;
}
