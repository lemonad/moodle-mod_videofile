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
 * English strings for videostream.
 *
 * @package    mod_videostream
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'שילוב סרטון';
$string['modulenameplural'] = 'סרטונים';
$string['modulename_help'] = 'רכיב זה מאפשר שילוב של סרטונים ממאגר הסרטים בתוך קורס';

$string['videostream:addinstance'] = 'הוספת סרטון';
$string['videostream:view'] = 'צפייה בסרטון';

$string['pluginadministration'] = 'ניהול רכיב הצגת סרטונים';
$string['pluginname'] = 'שילוב סרטון';

$string['videostream_defaults_heading'] = 'ברירות מחדל להגדרות של הסרטון';
$string['videostream_defaults_text'] = 'ההגדרות שיוגדרו פה תהיינה ברירות המחדל בסרטון חדש ';
$string['width_explain'] = 'הגדירו את ברירת המחדל של הרוחב';
$string['height_explain'] = 'הגדירו את ברירת המחדל של הגובה';
$string['responsive_explain'] = 'האם רספונסיביות מוגדרת כברירת מחדל';
$string['limitdimensions_explain'] = 'האם גובה ורוחב יוגדרו כמקסימום במצב רספונסיבי';

$string['filearea_captions'] = 'כתוביות';
$string['filearea_posters'] = 'תמונה';
$string['filearea_videos'] = 'סרטונים';

$string['video_fieldset'] = 'סרטון';

$string['width'] = 'רוחב';
$string['width_help'] = 'הזינו כאן את רוחב הסרטון (למשל 800 עבור רוחב של 800 פיקסלים).';
$string['height'] = 'גובה';
$string['height_help'] = 'הזינו כאן את גובה הסרטון (למשל 500 עבור גובה של 500 פיקסלים).';
$string['responsive'] = 'רספונסיבי?';
$string['responsive_help'] = "סמנו פה כדי שהסרט יסתדר אוטומטית על בסיס רוחב הדפדפן";
$string['responsive_label'] = '';
$string['limitdimensions'] = 'הגבלת גודל במצב רספונסיבי?';

$string['video'] = 'סרטון';
$string['videos'] = 'סרטונים';
$string['captions'] = 'כתוביות';

$string['err_positive'] = 'חובה להכניס כאן מספר חיובי';


$string['eventvideo_view'] = 'סרטון נצפה';
$string['playback_rate'] = "מהירות הסרטון";

$string['streaming_protocol'] = "שיטת הזרמה";

$string['dash_base_url'] = "Dash נתיב";
$string['dash_base_url_explain'] = "הכנס נתיב Dash, למשל http://streaming.company.com/dash/";

$string['hls_base_url'] = "HLS נתיב";
$string['hls_base_url_explain'] = "הכנס נתיב HLS, למשל http://streaming.company.com/hls/";

$string['nginx_multi'] = "מחזרוזת לסיום MultiURI ב-NGINX";
$string['nginx_multi_explain'] = "מחרוזת עבור NGINX multi URI, ידוע כ- vod_multi_uri_suffix בקובץ nginx conf";