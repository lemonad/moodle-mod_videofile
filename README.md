videostream
---------
New videostream module is based on the great original videofile module by : Jonas Nockert <jonasnockert AT gmail>
Thank you Jonas !!

This module work with local_video_directory, and has the ability to stream in DASH,HLS and plain PHP.
DASH & HLS works using Nginx Kaltura Streaming module.

Example screenshots (of original plugin)
----------------------------------------
![A screenshot](https://raw.github.com/lemonad/moodle-mod_videofile/master/pix/screenshot-1.png)

![Another screenshot](https://raw.github.com/lemonad/moodle-mod_videofile/master/pix/screenshot-2.png)

Installation
------------
Unzip the zip file in the `mod` folder of the Moodle directory and, if
necessary, rename the folder to "videostream".
-- OR --
Go to Administration > Site Administration > Install add-ons to install
the Videostream module directly from your Moodle installation.

Default settings can be set by going to Administration > Site
Administration > Plugins > Activity Modules > Videostream.

NGINX Configuration
-------------------

Get latest nginx stable source from : http://nginx.org/en/download.html

Get latest Kaltura VOD Module from : https://github.com/kaltura/nginx-vod-module

Assuming you downloaded and extracted these files in same directory, get into nginx source directory and type:

./configure --add-module=../nginx-vod-module --with-cc-opt="-O3" --with-file-aio --with-threads

Then after configuration success type:

make

make install


Use
---
See the LICENSE file for licensing details.
