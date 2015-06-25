#!/usr/bin/php
<?php

/**
	* base64image: command-line tool to create an image from a base64-encoded text string of an image (e.g. from .mht files or emails).
	*
	* Coded for PHP 5.4+
	*
	* Example usage:
	*                  php -f base64image.php <b64_text_file> <x.jpg | x.gif | x.png>
	*                  /usr/local/bin/base64image <b64_text_file> <x.jpg | x.gif | x.png>
	*
	* @author          Martin Latter <copysense.co.uk>
	* @copyright       Martin Latter 24/04/2015
	* @version         0.1
	* @license         GNU GPL version 3.0 (GPL v3); http://www.gnu.org/licenses/gpl.html
	* @link            https://github.com/Tinram/base64image.git
*/


if ( ! extension_loaded('gd')) {
	die("\n GD library not available!\n\n");
}

$aImageTypes = ['jpg', 'gif', 'png'];

$sUsage = "\n " . basename($_SERVER['argv'][0], '.php') . "\n\n\tusage: " . basename($_SERVER['argv'][0], '.php') . " <b64_file> <x.jpg | x.gif | x.png> \n\n";

$sImageError = "\n An error occurred creating the image\n\n";


# file processing
if (@ ! $_SERVER['argv'][1]) {
	die($sUsage);
}

$sFilename = $_SERVER['argv'][1];
$sImageFilename = $_SERVER['argv'][2];
$sFileType = explode('.', $sImageFilename)[1];

if ( ! file_exists($sFilename)) {
	die("\n $sFilename does not exist in this directory!\n\n");
}

if (empty($sFileType) || ! in_array($sFileType, $aImageTypes)) {
	die("\n Image parameter must be x.jpg, x.gif, or x.png\n\n" . $sUsage);
}

$sFileData = file_get_contents($sFilename);

if ( ! $sFileData) {
	die(' Error reading file: ' . $sFilename);
}
##


# decode base64 text
$sFileData = base64_decode($sFileData);

# create image resource
$rImage = imagecreatefromstring($sFileData);

if ( ! $rImage) {
	die($sImageError);
}

# switch image output
switch ($sFileType) {

	case 'png':
		$bIm = ImagePNG($rImage, $sImageFilename, 9);
	break;
	
	case 'jpg':
		$bIm = ImageJPEG($rImage, $sImageFilename, 90);
	break;
	
	case 'gif':
		$bIm = ImageGIF($rImage, $sImageFilename);
	break;
}


if ( ! $bIm) {
	die($sImageError);
}
else {
	echo("\n $sImageFilename created.\n\n");
}

?>