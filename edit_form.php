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
 * @package    progressbar
 * @author     Andrei Vasilescu <andrei.vasilescu@cti.pub.ro>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_progressbar_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        $mform->addElement('header', 'configheader', get_string('editbars', 'block_progressbar'));
        $mform->addElement('html', '<div style="width:200px"><div class="progress progress-striped active">
                                    <div class="bar bar-success" style="width: 100%;"></div></div></div>');
        $mform->addElement('text', 'config_green', get_string('setending_G', 'block_progressbar'));
        $mform->addElement('html', '<div style="width:200px"><div class="progress progress-striped active">
                                    <div class="bar bar-warning" style="width: 100%;"></div></div></div>');
        $mform->addElement('text', 'config_yellow', get_string('setending_Y', 'block_progressbar'));
        $mform->addElement('html', '<div style="width:200px"><div class="progress progress-striped active">
            <div class="bar bar-danger" style="width: 100%;"></div></div></div>');
        $mform->addElement('html', get_string('editinstructions', 'block_progressbar'));
        $mform->setDefault('config_green', '50');
        $mform->setDefault('config_yellow', '80');
        $mform->setType('config_text', PARAM_INT);
        $mform->setType('config_text2', PARAM_INT);
    }
}
