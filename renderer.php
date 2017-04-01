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
     * @param int $contextid
     * @return string HTML
     */
    private function get_video_source_elements_hls($videostream) {

		$width = ($videostream->get_instance()->responsive ?
                  '100%' : $videostream->get_instance()->width);
        $height = ($videostream->get_instance()->responsive ?
                   '100%' : $videostream->get_instance()->height);
		 
		$output = '<script src="hls.js/hls.min.js"></script>
					<video controls id="video" width=\'' . $width .'\' height=\''. $height .'\'></video>
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
     * Utility function for creating the video source elements HTML.
     *
     * @param int $contextid
     * @return string HTML
     */
    private function get_video_source_elements_dash($videostream) {

		$width = ($videostream->get_instance()->responsive ?
                  '100%' : $videostream->get_instance()->width);
        $height = ($videostream->get_instance()->responsive ?
                   '100%' : $videostream->get_instance()->height);
		 
		 
		$output = '<script src="dash/jquery-1.10.2.min.js"></script><script src="dash/dash.all.min.js"></script><script src="dash/ControlBar.js"></script>';
		$output .= '
		<!--VIDEO PLAYER / CONTROLS -->
        <div class="row">
            <div class="dash-video-player" width=\'' . $width .'\' height=\''. $height .'\'>
            	<div id="videoContainer">
		    		<video id="videoplayer" width=\'' . $width .'\' height=\''. $height .'\'></video>
                    <div id="video-caption"></div>
                    <div id="videoController" class="video-controller unselectable">
                        <div id="playPauseBtn" class="btn-play-pause" data-toggle="tooltip" data-placement="bottom" title="Play/Pause">
                            <span id="iconPlayPause" class="icon-play"></span>
                        </div>
                        <span id="videoTime" class="time-display">00:00:00</span>
                        <div id="fullscreenBtn" class="btn-fullscreen control-icon-layout" data-toggle="tooltip" data-placement="bottom" title="Fullscreen">
                            <span class="icon-fullscreen-enter"></span>
                        </div>
                        <div id="bitrateListBtn" class="btn-bitrate control-icon-layout" data-toggle="tooltip" data-placement="bottom" title="Bitrate List">
                            <span class="icon-bitrate"></span>
                        </div>

						<div id="playrateListBtn" class="btn-playrate control-icon-layout" data-toggle="tooltip" data-placement="bottom" title="Playrate List">
                            <span class="icon-playrate"></span>
                        </div>


                        <input type="range" id="volumebar" class="volumebar" value="1" min="0" max="1" step=".01"/>
                        <div id="muteBtn" class="btn-mute control-icon-layout" data-toggle="tooltip" data-placement="bottom" title="Mute">
                            <span id="iconMute" class="icon-mute-off"></span>
                        </div>
                        <div id="trackSwitchBtn" class="btn-track-switch control-icon-layout" data-toggle="tooltip" data-placement="bottom" title="Track List">
                            <span class="icon-tracks"></span>
                        </div>
                        <div id="captionBtn" class="btn-caption control-icon-layout" data-toggle="tooltip" data-placement="bottom" title="Closed Caption / Subtitles">
                            <span class="icon-caption"></span>
                        </div>
                        <span id="videoDuration" class="duration-display">00:00:00</span>
                        <div class="seekContainer">
                            <input type="range" id="seekbar" value="0" class="seekbar" min="0" step="0.01"/>
                        </div>
                    </div>
                </div>
            </div>';
		
		$output .= '<script>
        var url=\'' . $this->createDASH($videostream->get_instance()->videoid) . '\';
		var element = document.querySelector("#videoplayer")
		var player = dashjs.MediaPlayer().create();
		player.initialize(element, url, true);
		player.setFastSwitchEnabled(true);
		player.attachVideoContainer(document.getElementById("videoContainer"));
		player.attachTTMLRenderingDiv($("#video-caption")[0]);
		controlbar = new ControlBar(player);
		controlbar.initialize();
		controlbar.enable();
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

		if ($config->streaming == "hls") {
        	// Elements for video sources. (here we get the hls video)
        	$output .= $this->get_video_source_elements_hls($videostream);
        	// video speed buttons
			$output .= $this->get_rate_buttons();
		} else {
			//Dash video
			$output .= $this->get_video_source_elements_dash($videostream);
		}
        // Elements for caption tracks.
        //$output .= $this->get_video_caption_track_elements_html($contextid);

        // Close video tag.
        $output .= html_writer::end_tag('video');

        // Alternative video links in case video isn't showing/playing properly.
        //$output .= $this->get_alternative_video_links_html($contextid);

        // Close videostream div.
        $output .= $this->output->container_end();

        return $output;
    }

	public function createHLS($videoid) {
		global $DB;
		
		$config = get_config('videostream');
 
		$hls_streaming = $config->hls_base_url;

		$id = $videoid;
		$streams = $DB->get_records("local_video_directory_dash",array("video_id" => $id));
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
		$hls_url .= "," . ".mp4multiuri/master.m3u8";

		return $hls_url;			
	}

	public function createDASH($videoid) {
		global $DB;

		
		$config = get_config('videostream');
 
		$dash_streaming = $config->dash_base_url;
		
		$id = $videoid;
		$streams = $DB->get_records("local_video_directory_dash",array("video_id" => $id));
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
		$dash_url .= "," . ".mp4multiuri/manifest.mpd";

		return $dash_url;			
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
