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
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// TODO $module is deprecated for 2.7 and should be replaced with $plugin.
// However, Moodle 2.4 still requires $module and it would not make sense
// to break compatibility (yet).
$plugin->version  = 2017022001;
$plugin->requires = 2012120300;
$plugin->cron     = 0;
$plugin->component = 'mod_videofile';
$plugin->maturity = MATURITY_STABLE;
$plugin->release  = '1.05';
