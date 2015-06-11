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
 * Defines the version of videofile.
 *
 * This code fragment is called by moodle_needs_upgrading() and
 * /admin/index.php.
 *
 * @package    mod_videofile
 * @copyright  2013-2015 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// TODO $module is deprecated for 2.7 and should be replaced with $plugin.
// However, Moodle 2.4 still requires $module.
if (isset($plugin)) {
    $v = $plugin;
} else {
    $v = $module;
}
$v->version   = 2015061101;
$v->requires  = 2012120300;
$v->cron      = 0;
$v->component = 'mod_videofile';
$v->maturity  = MATURITY_STABLE;
$v->release   = '1.06';
