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
 * videostream module renderering methods are defined here.
 *
 * @package    mod_videostream
 * @copyright  2017 Yedidia Klein <yedidia@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/videostream/locallib.php');

/**
 * videostream module renderer class
 */
class mod_videostream_renderer extends plugin_renderer_base {

    /**
     * Renders the videostream page header.
     *
     * @param videostream videostream
     * @return string
     */
    public function video_header($videostream) {
        global $CFG;

        $output = '';

        $name = format_string($videostream->get_instance()->name,
                              true,
                              $videostream->get_course());
        $title = $this->page->course->shortname . ': ' . $name;

        $coursemoduleid = $videostream->get_course_module()->id;
        $context = context_module::instance($coursemoduleid);


        // Header setup.
        $this->page->set_title($title);
        $this->page->set_heading($this->page->course->fullname);

        $output .= $this->output->header();
        $output .= $this->output->heading($name, 3);

        if (!empty($videostream->get_instance()->intro)) {
            $output .= $this->output->box_start('generalbox boxaligncenter', 'intro');
            $output .= format_module_intro('videostream',
                                           $videostream->get_instance(),
                                           $coursemoduleid);
            $output .= $this->output->box_end();
        }

        return $output;
    }

    /**
     * Render the footer
     *
     * @return string
     */
    public function video_footer() {
        return $this->output->footer();
    }

    /**
     * Render the videostream page
     *
     * @param videostream videostream
     * @return string The page output.
     */
    public function video_page($videostream) {
        $output = '';
        $output .= $this->video_header($videostream);
        $output .= $this->video($videostream);
        $output .= $this->video_footer();

        return $output;
    }


    /**
     * Utility function for creating the video source elements HTML.
     *
     * @param obj $videostream
     * @return string HTML
     */
    private function get_video_source_elements_hls($videostream) {
        global $CFG;
		$width = ($videostream->get_instance()->responsive ?
                  '100%' : $videostream->get_instance()->width);
        $height = ($videostream->get_instance()->responsive ?
                   '100%' : $videostream->get_instance()->height);
		 
		$output = '<script src="hls.js/hls.min.js"></script>
					<video controls id="video" width=\'' . $width .'\' height=\''. $height .'\'>
                    <track label="English" kind="subtitles" srclang="en" 
                    src="'.$CFG->wwwroot.'/local/video_directory/subs.php?video_id='.$videostream->get_instance()->videoid.'" default>
                    </video>
					<script>
  						if(Hls.isSupported()) {
    						var video = document.getElementById(\'video\');
    						var hls = new Hls();
    						hls.loadSource(\'' . $this->createHLS($videostream->get_instance()->videoid) .'\');
    						hls.attachMedia(video);
    						hls.on(Hls.Events.MANIFEST_PARSED,function() {
      							video.play();
  							});
 						}
					</script>';

        return $output;
    }


    /**
     * Utility function for creating the dash video source elements HTML.
     *
     * @param obj $videostream
     * @return string HTML
     */
    private function get_video_source_elements_dash($videostream) {
        global $CFG;
		$width = ($videostream->get_instance()->responsive ?
                  '100%' : $videostream->get_instance()->width . "px");
        $height = ($videostream->get_instance()->responsive ?
                   'auto' : $videostream->get_instance()->height . "px");

        $output = '<video id=videostream class="video-js vjs-default-skin" data-setup=\'{}\' 
                    style="position: relative !important; width: ' . $width . ' !important; height: '. $height .' !important;" 
                    controls> 
                    <track label="English" kind="subtitles" srclang="en" 
                    src="'.$CFG->wwwroot.'/local/video_directory/subs.php?video_id='.$videostream->get_instance()->videoid.'" default>
                    </video>
                        <script src="dash/video.js"></script>
                        <script src="dash/dash.all.min.js"></script>
                        <script src="dash/videojs-dash.min.js"></script>
                    <script>
                        var player = videojs("videostream",{      
                            playbackRates: [0.5, 1, 1.5, 2, 3]
                        });';
        $output .= 'player.src({ src: \'';
        $output .=  $this->createDASH($videostream->get_instance()->videoid);
        $output .= '\', type: \'application/dash+xml\'});
                            player.play();
                        </script>';

        return $output;
    }


    /**
     * Utility function for creating the symlink/php video source elements HTML. return a basic videojs player for php/symlink pseudo streaming
     *
     * @param obj $videostream
     *        string $type 
     * @return string HTML
     */
    private function get_video_source_elements_videojs($videostream,$type) {
        global $CFG;
		$width = ($videostream->get_instance()->responsive ?
                  '100%' : $videostream->get_instance()->width . "px");
        $height = ($videostream->get_instance()->responsive ?
                   'auto' : $videostream->get_instance()->height . "px");

        $output = '<video id=videostream class="video-js vjs-default-skin" data-setup=\'{}\' 
                    style="position: relative !important; width: ' . $width . ' !important; height: '. $height .' !important;" 
                    controls> 
                    <track label="English" kind="subtitles" srclang="en" 
                    src="'.$CFG->wwwroot.'/local/video_directory/subs.php?video_id='.$videostream->get_instance()->videoid.'" default>
                    </video>
                        <script src="dash/video.js"></script>
                    <script>
                        var player = videojs("videostream",{      
                            playbackRates: [0.5, 1, 1.5, 2, 3]
                        });';
        $output .= 'player.src({ src: \'';
        if ($type == "symlink") {
            $output .=  $this->createSYMLINK($videostream->get_instance()->videoid);
        } else { //php
            $output .=  $CFG->wwwroot.'/local/video_directory/play.php?video_id='.$videostream->get_instance()->videoid;
        }
            $output .= '\', type: \'video/mp4\'});
                            player.play();
                        </script>';

        return $output;
    }


    /**
     * Renders videostream video.
     *
     * @param videostream $videostream
     * @return string HTML
     */
    public function video(videostream $videostream) {
        $output  = '';
        $contextid = $videostream->get_context()->id;

        // Open videostream div.
        $vclass = ($videostream->get_instance()->responsive ?
                   'videostream videostream-responsive' : 'videostream');
        $output .= $this->output->container_start($vclass);

        // Open video tag.
        //$posterurl = $this->get_poster_image($contextid);
        //$output .= $this->get_video_element_html($videostream, $posterurl);
		$config = get_config('videostream');

        if (($config->streaming == "symlink") || ($config->streaming == "php")) {
        	// Elements for video sources. (here we get the symlink and php video)
        	$output .= $this->get_video_source_elements_videojs($videostream,$config->streaming);
		} elseif ($config->streaming == "hls") {
        	// Elements for video sources. (here we get the hls video)
        	$output .= $this->get_video_source_elements_hls($videostream);
        	// video speed buttons
			$output .= $this->get_rate_buttons();
        } else {
			//Dash video
			$output .= $this->get_video_source_elements_dash($videostream);
		}

        // Close video tag.
        $output .= html_writer::end_tag('video');

        // Close videostream div.
        $output .= $this->output->container_end();

        return $output;
    }

	public function createHLS($videoid) {
		global $DB;
		
		$config = get_config('videostream');
 
		$hls_streaming = $config->hls_base_url;

		$id = $videoid;
		$streams = $DB->get_records("local_video_directory_multi",array("video_id" => $id));
		foreach ($streams as $stream) {
			$files[]=$stream->filename;
		}

		$parts=array();
		foreach ($files as $file) {
			$parts[] = preg_split("/[_.]/", $file);
		}

		$hls_url = $hls_streaming . $parts[0][0] . "_";
		foreach ($parts as $key => $value) {
			$hls_url .= "," . $value[1];
		}
		$hls_url .= "," . ".mp4".$config->nginx_multi."/master.m3u8";

		return $hls_url;			
	}

	public function createDASH($videoid) {
		global $DB;

		
		$config = get_config('videostream');
 
		$dash_streaming = $config->dash_base_url;
		
		$id = $videoid;
		$streams = $DB->get_records("local_video_directory_multi",array("video_id" => $id));
		foreach ($streams as $stream) {
			$files[]=$stream->filename;
		}

		$parts=array();
		foreach ($files as $file) {
			$parts[] = preg_split("/[_.]/", $file);
		}

		$dash_url = $dash_streaming . $parts[0][0] . "_";
		foreach ($parts as $key => $value) {
			$dash_url .= "," . $value[1];
		}
		$dash_url .= "," . ".mp4".$config->nginx_multi."/manifest.mpd";

		return $dash_url;			
	}

    public function createSYMLINK($videoid) {
		global $DB;

		
		$config = get_config('local_video_directory');
 
		return $config->streaming . "/" . $videoid . ".mp4";			
	}

	
	public function get_rate_buttons() {
		$speeds = array(0.5,1,1.5,2,2.5,3);
		$output = "<div class='rates'>".get_string('playback_rate','videostream').": ";
		foreach ($speeds as $value) { 
			$output .= '<a class="playrate" onclick="document.getElementById(\'video\').playbackRate='.$value.'">X'.$value.'</a> ';	
		}
		$output .= "</div>";
		return $output;
	}
	

}
