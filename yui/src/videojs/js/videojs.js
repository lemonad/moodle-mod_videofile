M.mod_videofile = M.mod_videofile || {};
M.mod_videofile.videojs = {
  init: function (video_id, swfpath, width, height) {
    var myPlayer = videojs('videofile-' + video_id);
    var aspectRatio = height / width;

    function resizeVideoJS() {
      // Get the parent element's actual width
      var width = document.getElementById(myPlayer.id()).parentElement.offsetWidth;

      // Set width to fill parent element, set height proportionally.
      myPlayer.width(width).height(width * aspectRatio);
    }

    resizeVideoJS();
    window.onresize = resizeVideoJS;
  }
};
