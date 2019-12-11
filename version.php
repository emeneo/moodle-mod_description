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
 * Description module version info
 *
 * @package    mod
 * @subpackage description
 * @copyright  emeneo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2019110800;    // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2013050100;    // Requires at least this Moodle version
$plugin->maturity = MATURITY_STABLE;
$plugin->release = 'Course description plugin 3.8-a';
$plugin->component = 'mod_description'; // Full name of the plugin (used for diagnostics)
$plugin->cron      = 0;
