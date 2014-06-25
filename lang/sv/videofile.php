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
 * Swedish strings for videofile
 *
 * @package    mod_videofile
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'Videofil';
$string['modulenameplural'] = 'Videofiler';
$string['modulename_help'] = 'Använd videofil-modulen för att lägga till html5-videos med flash-fallback (via video.js). Den här modulen gör det också möjligt att lägga till flerspråkiga bildtexter.';

$string['videofile:addinstance'] = 'Lägg till en ny videofil';
$string['videofile:view'] = 'Visa videofil';

$string['pluginadministration'] = 'Administration för videofil';
$string['pluginname'] = 'Videofil';

$string['videofile_defaults_heading'] = 'Standardvärden för videofil-inställningar';
$string['videofile_defaults_text'] = 'De värden du sätter här blir standardvärden som används i inställningsformuläret när du skapar en ny videofil.';
$string['width_explain'] = 'Specificerar standardbredden på videospelaren.';
$string['height_explain'] = 'Specificerar standardhöjden på videospelaren.';
$string['responsive_explain'] = 'Specificerar om responsivt läge ska användas som standard för videospelaren eller ej.';
$string['limitdimensions_explain'] = 'Specificerar om höjd och bredd ska användas som maximal storlek i responsivt läge.';

$string['filearea_captions'] = 'Bildtexter';
$string['filearea_posters'] = 'Bilder';
$string['filearea_videos'] = 'Videos';

$string['video_fieldset'] = 'Video';

$string['width'] = 'Bredd';
$string['width_help'] = 'Skriv in bredden på videospelaren här (t.ex. 800 för en bredd av 800 pixlar).';
$string['height'] = 'Höjd';
$string['height_help'] = 'Skriv in höjden på videospelaren här (t.ex. 500 för en höjd av 500 pixlar).';
$string['responsive'] = 'Responsivt läge?';
$string['responsive_help'] = "Kryssa i för att storleken på videospelaren ska anpassas automatiskt efter webbläsarens fönsterstorlek.\n\nAnvänd fälten för bredd och höjd till att definiera proportionerna (t.ex. 16/9 eller 800/450).";
$string['responsive_label'] = '';
$string['limitdimensions'] = 'Begränsa storlek i responsivt läge?';

$string['videos'] = 'Videos';
$string['videos_help'] = "Lägg till videofilen här.\n\nDu kan lägga till alternativa format för att vara säker på att videon går att spela upp oavsett vilken webbläsare som används (vanligtvis räcker det med .mp4, .ogv and .webm).";
$string['posters'] = 'Bild';
$string['posters_help'] = 'Lägg till en bild här som kommer visas innan videon börjar spelas upp.';
$string['captions'] = 'Bildtexter';
$string['captions_help'] = "Lägg till transkriptioner av dialogen i WebVTT-format här.\n\nDu kan lägga till flera filer för att tillhandahålla flerspråkiga bildtexter. Filnamnen, utan filtillägg, kommer användas som titel för valen av bildtext. Om filerna döps enligt ISO 6392 (t.ex. eng.vtt och swe.vtt) så kommer valen visas med motsvarande fullständiga språknamn enligt användarens språkinställningar (t.ex. Engelska och Svenska, förutsatt att användarens språkpreferens är satt till Svenska).";

$string['err_positive'] = 'Du måste skriva in ett positivt värde här.';

$string['video_not_playing'] = 'Spelas inte videon upp? Försök med {$a}.';
