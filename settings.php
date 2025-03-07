<?php
// This file is part of Tiny File Manager plugin for Moodle - http://moodle.org/
//
// Tiny File Manager is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Tiny File Manager is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Tiny File Manager. If not, see <http://www.gnu.org/licenses/>.

/**
 * Add page to admin menu.
 *
 * @package   local_tinyfilemanager
 * @author    Michael Milette (https://www.tngconsulting.ca)
 * @copyright 2020-2022 TNG Consulting Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $pluginname = get_string('pluginname', 'local_tinyfilemanager');
    $ADMIN->add('server', new admin_externalpage('local_tinyfilemanager', $pluginname, new moodle_url('/local/tinyfilemanager/')));

    $settings = new admin_settingpage('local_tinyfilemanager_settings', $pluginname);
    $ADMIN->add('localplugins', $settings);

    // Option to show or hide hidden files.
    $default = '0';
    $name = 'local_tinyfilemanager/showhidden';
    $title = get_string('showhidden', 'local_tinyfilemanager');
    $description = get_string('showhidden_desc', 'local_tinyfilemanager');
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // Option to show or hide permissions and owner column.
    if (DIRECTORY_SEPARATOR === '/') {
        // Only on Unix, Linux, MacOS.
        $default = '1';
        $name = 'local_tinyfilemanager/showpermowner';
        $title = get_string('showpermowner', 'local_tinyfilemanager');
        $description = get_string('showpermowner_desc', 'local_tinyfilemanager');
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $settings->add($setting);
    }

    // Option to calculate size of folders.
    $default = '0';
    $name = 'local_tinyfilemanager/calcfoldersize';
    $title = get_string('calcfoldersize', 'local_tinyfilemanager');
    $description = get_string('calcfoldersize_desc', 'local_tinyfilemanager');
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // Option to specify the root directory path displayed TinyFileManager.
    $default = substr($CFG->dirroot, 1,1) == ':' ? substr($CFG->dirroot, 2) : $CFG->dirroot;
    $default = str_replace('\\', '/', $default);
    $name = 'local_tinyfilemanager/rootpath';
    $title = get_string('rootpath', 'local_tinyfilemanager');
    $description = get_string('rootpath_desc', 'local_tinyfilemanager');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_PATH);
    $settings->add($setting);

    // Option to select the Office online document viewer.
    $default = 'google'; // Default is to use the Google document viewer.
    $name = 'local_tinyfilemanager/onlineviewer';
    $title = get_string('onlineviewer', 'local_tinyfilemanager');
    $description = get_string('onlineviewer_desc', 'local_tinyfilemanager');
    $choices = ['false' => get_string('plugindisabled', 'plugin'),
            'google' => get_string('google', 'local_tinyfilemanager'),
            'microsoft' => get_string('microsoft', 'local_tinyfilemanager')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Option to select the source code highligh theme.
    $default = 'vs.css'; // Default is to use the base VSCode theme.
    $name = 'local_tinyfilemanager/highlighttheme';
    $title = get_string('highlighttheme', 'local_tinyfilemanager');
    $description = get_string('highlighttheme_desc', 'local_tinyfilemanager');
    $choices = array_diff(scandir(dirname(__FILE__) . '/styles/highlight'), array('.', '..', 'base16'));
    $choices = array_combine($choices, $choices);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
}
