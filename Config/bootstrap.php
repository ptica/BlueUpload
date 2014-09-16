<?php

$options = array();
$options['rooms'] = array(
	'upload_dir' => 'img/room/',  // relative to webroot
	'upload_url' => '/img/room/', // relative to webroot
	'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
	'image_library' => 2, // set to 2 to use the ImageMagick convert binary directly
	'convert_bin' => '/opt/local/bin/convert',
	'image_versions' => array(
		// The empty image version key defines options for the original image:
		'' => array(
			// Automatically rotate images based on EXIF meta data:
			'auto_orient' => true
		),
		// Uncomment the following to create medium sized images:
		// 'preview' => array(
		// 	'max_width' => 529,
		// 	'max_height' => 600
		// ),
		'thumbnail' => array(
			// Uncomment the following to use a defined directory for the thumbnails
			// instead of a subdirectory based on the version identifier.
			// Make sure that this directory doesn't allow execution of files if you
			// don't pose any restrictions on the type of uploaded files, e.g. by
			// copying the .htaccess file from the files directory for Apache:
			//'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')).'/thumb/',
			//'upload_url' => $this->get_full_url().'/thumb/',
			// Uncomment the following to force the max
			// dimensions and e.g. create square thumbnails:
			'crop' => true,
			'max_width' => 240,
			'max_height' => 240
		)
	)
);

Configure::write('BlueUpload.options', $options);
