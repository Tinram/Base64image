#!/usr/bin/php
<?php

/**
	* base64image
	*
	* Command-line tool to create an image from a base64-encoded text string of an image (e.g. from .mht files or emails).
	*
	* Coded for PHP 5.4+
	*
	* Example usage:
	*                  php base64image.php <b64_text_file> <x.jpg | x.gif | x.png>
	*                  ./base64image <b64_text_file> <x.jpg | x.gif | x.png>
	*
	* @author          Martin Latter <copysense.co.uk>
	* @copyright       Martin Latter 24/04/2015
	* @version         0.13
	* @license         GNU GPL version 3.0 (GPL v3); http://www.gnu.org/licenses/gpl.html
	* @link            https://github.com/Tinram/base64image.git
*/


define('DUB_EOL', PHP_EOL . PHP_EOL);


if ( ! extension_loaded('gd')) {
	die(PHP_EOL . ' GD library not available!' . DUB_EOL);
}

$aImageTypes = ['jpg', 'gif', 'png'];

$sUsage =
	PHP_EOL . ' ' . basename(__FILE__, '.php') .
	DUB_EOL . "\tusage: php " . basename(__FILE__) . ' <b64_file> <x.jpg | x.gif | x.png>' . DUB_EOL;

$sImageError = PHP_EOL . ' An error occurred creating the image!' . DUB_EOL;


# file processing
if ( ! isset($_SERVER['argv'][1])) {
	die($sUsage);
}

$sFilename = $_SERVER['argv'][1];

if ( ! file_exists($sFilename)) {
	die(PHP_EOL . ' \'' . $sFilename . '\' does not exist in this directory!' . DUB_EOL);
}

if ( ! isset($_SERVER['argv'][2])) {
	die(PHP_EOL . ' No image parameter specified.' . DUB_EOL . $sUsage);
}

$sImageFilename = $_SERVER['argv'][2];
$sFileType = explode('.', $sImageFilename)[1];

if (empty($sFileType) || ! in_array($sFileType, $aImageTypes)) {
	die(PHP_EOL . ' Output image parameter must have a file extension of .jpg or .gif or .png' . DUB_EOL . $sUsage);
}

$sFileData = file_get_contents($sFilename);

if ( ! $sFileData) {
	die(PHP_EOL . ' Error reading file: ' . $sFilename . DUB_EOL);
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
		$bIm = ImageJPEG($rImage, $sImageFilename, 94);
	break;
	
	case 'gif':
		$bIm = ImageGIF($rImage, $sImageFilename);
	break;
}


if ( ! $bIm) {
	die($sImageError);
}
else {
	echo(PHP_EOL . ' ' . $sImageFilename . ' created.' . DUB_EOL);
}

?>