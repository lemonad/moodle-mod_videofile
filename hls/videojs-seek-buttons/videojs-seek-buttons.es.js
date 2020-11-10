/*! @name videojs-seek-buttons @version 1.6.0 @license Apache-2.0 */
import videojs from 'video.js';

function _inheritsLoose(subClass, superClass) {
  subClass.prototype = Object.create(superClass.prototype);
  subClass.prototype.constructor = subClass;
  subClass.__proto__ = superClass;
}

var version = "1.6.0";

var Button = videojs.getComponent('Button'); // Default options for the plugin.

var defaults = {
  forwardIndex: 1,
  backIndex: 1
}; // Cross-compatibility for Video.js 5 and 6.

var registerPlugin = videojs.registerPlugin || videojs.plugin; // const dom = videojs.dom || videojs;
// document.sbInit = 0;
// videojs.log('seek');
// videojs.log(videojs === global.videojs);
// videojs.log(videojs);
// videojs.log(global.videojs);
// videojs.log(document.body.querySelector('video'));

/**
 * Function to invoke when the player is ready.
 *
 * This is a great place for your plugin to initialize itself. When this
 * function is called, the player will have its DOM and child components
 * in place.
 *
 * @function onPlayerReady
 * @param    {Player} player
 *           A Video.js player object.
 *
 * @param    {Object} [options={}]
 *           A plain object containing options for the plugin.
 */

var onPlayerReady = function onPlayerReady(player, options) {
  player.addClass('vjs-seek-buttons');

  if (options.forward && options.forward > 0) {
    player.controlBar.seekForward = player.controlBar.addChild('seekButton', {
      direction: 'forward',
      seconds: options.forward
    }, options.forwardIndex);
  }

  if (options.back && options.back > 0) {
    player.controlBar.seekBack = player.controlBar.addChild('seekButton', {
      direction: 'back',
      seconds: options.back
    }, options.backIndex);
  }
};
/**
 * A video.js plugin.
 *
 * In the plugin function, the value of `this` is a video.js `Player`
 * instance. You cannot rely on the player being in a "ready" state here,
 * depending on how the plugin is invoked. This may or may not be important
 * to you; if not, remove the wait for "ready"!
 *
 * @function seekButtons
 * @param    {Object} [options={}]
 *           An object of options left to the plugin author to define.
 */


var seekButtons = function seekButtons(options) {
  var _this = this;

  // document.sbInit++;
  this.ready(function () {
    onPlayerReady(_this, videojs.mergeOptions(defaults, options));
  });
}; // Include the version number.


seekButtons.VERSION = version;
/**
 * Button to seek forward/back
 *
 * @param {Player|Object} player
 * @param {Object=} options
 * @extends Button
 * @class SeekToggle
 */

var SeekButton =
/*#__PURE__*/
function (_Button) {
  _inheritsLoose(SeekButton, _Button);

  function SeekButton(player, options) {
    var _this2;

    _this2 = _Button.call(this, player, options) || this;

    if (_this2.options_.direction === 'forward') {
      _this2.controlText(_this2.localize('Seek forward {{seconds}} seconds').replace('{{seconds}}', _this2.options_.seconds));
    } else if (_this2.options_.direction === 'back') {
      _this2.controlText(_this2.localize('Seek back {{seconds}} seconds').replace('{{seconds}}', _this2.options_.seconds));
    }

    return _this2;
  }

  var _proto = SeekButton.prototype;

  _proto.buildCSSClass = function buildCSSClass() {
    /* Each button will have the classes:
       `vjs-seek-button`
       `skip-forward` or `skip-back`
       `skip-n` where `n` is the number of seconds
       So you could have a generic icon for "skip back" and a more
       specific one for "skip back 30 seconds"
    */
    return "vjs-seek-button skip-" + this.options_.direction + " " + ("skip-" + this.options_.seconds + " " + _Button.prototype.buildCSSClass.call(this));
  };

  _proto.handleClick = function handleClick() {
    var now = this.player_.currentTime();

    if (this.options_.direction === 'forward') {
      this.player_.currentTime(now + this.options_.seconds);
    } else if (this.options_.direction === 'back') {
      this.player_.currentTime(now - this.options_.seconds);
    }
  };

  return SeekButton;
}(Button); // console.log('register component with', videojs.VERSION, videojs);


videojs.registerComponent('SeekButton', SeekButton); // Register the plugin with video.js.

registerPlugin('seekButtons', seekButtons);

export default seekButtons;
