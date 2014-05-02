geovision-multicamviewer
========================

A simple Javascript viewer for GeoVision Surveillance DVR by [Steve Pasetti](http://stevepasetti.com)

<h2>The problem</h2>
GeoVision's DMMultiview.exe client only supports Windows.  Their remote access website does not work for most users (It claims to support MPEG and Quicktime, and I've gotten neither working on Windows or Mac.)

It does however have a "mobile" version of the website that can serve static JPEG images that can be refreshed.

<h2>The answer</h2>
This Javascript viewer repeatedly pulls JPEGs from the remote access website of the camera.

<h2>Requirements</h2>
* Access to a GeoVision Surveillance DVR system with a mobile access page that supports JPEG
* A webserver with PHP >=4.1 and libcurl >=7.10.5

<h2>Installation</h2>
* Copy the "cams.php" file to a supported server.

<h2>Usage</h2>
* Access the "cams.php" file at whatever url it's installed at
* Enter the IP address of the camera system and your username and password to log in.
* Pick which cameras you want to view.

<h2>Limitations</h2>
This only pulls images and displays them repeatedly for a video effect.  No sound, controls, or admin functions that the camera system may support.

<h2>Advanced</h2>
You can hardcode the camera IP, username and password im the script if you wish.  You can also edit the setInterval parameters to make it refresh faster or slower.

<h2>License</h2>
MIT License.
