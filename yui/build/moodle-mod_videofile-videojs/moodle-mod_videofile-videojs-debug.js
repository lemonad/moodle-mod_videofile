YUI.add('moodle-mod_videofile-videojs', function (Y, NAME) {

M.mod_videofile = M.mod_videofile || {};
M.mod_videofile.videojs = {
  init: function (videoId, swfPath, prefWidth, prefHeight, limitDimensions) {
    var myPlayer = videojs('videofile-' + videoId);
    var playerElement = document.getElementById(myPlayer.id());
    var playerParent = playerElement.parentElement;
    var aspectRatio = prefHeight / prefWidth;

    if (limitDimensions) {
      // The max and min limit is overriden using styles.css in full
      // screen mode.
      playerElement.style.maxWidth = prefWidth + 'px';
      playerElement.style.maxHeight = prefHeight + 'px';
    }

    function resizeVideoJS() {
      // Get the parent element's actual width.
      var parentWidth = playerParent.offsetWidth;

      // Set width to fill parent element, set height proportionally.
      myPlayer.width(parentWidth).height(parentWidth * aspectRatio);
    }

    resizeVideoJS();
    window.onresize = resizeVideoJS;
  }
};


}, '@VERSION@', {"requires": ["base", "node", "event"]});
