# BlueUpload frontend for CakePHP

this composer package provides CakePHP intergration with blueimp's [JQuery-File-Upload](https://github.com/blueimp/jQuery-File-Upload).

```
bower install blueimp-file-upload
composer require ptica/BlueUpload:dev-master
```

the package comes with a routes.php file that
connects /upload/* to the plugin BlueUpload controller
that constructs the JQuery-File-Upload class and carries out the upload request

resulting file id is returned through ajax into host HTML form,
a precompiled image/file template is rendered using handlebars runtime and localization
(Gruntfile.js handles build process for these resources)


configure the uploader first:
```php
# Config/bootstrap.php
CakePlugin::load(array(
	'BlueUpload' => array('bootstrap' => false, 'routes' => true),
	'Handlebars',
));

// Set to 0 to use the GD library to scale and orient images,
// set to 1 to use imagick (if installed, falls back to GD),
// set to 2 to use the ImageMagick convert binary directly:
Configure::write('BlueUpload.options.image_library', 1);
Configure::write('BlueUpload.options.convert_bin', '/usr/bin/convert');

/**
* uploader options
*/
Configure::write('BlueUpload.options.photos', array(
	'edit_template'=>'BlueUpload.image-edit.hbs',
	'view_template'=>'BlueUpload.image.hbs',
	'upload_dir' => 'img/rooms/',  // relative to webroot
	'upload_url' => '/img/rooms/',
	'script_url' => '/upload/rooms',
	'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
	'image_library' => Configure::read('BlueUpload.options.image_library'),
	'convert_bin'   => Configure::read('BlueUpload.options.convert_bin'),
	'image_versions' => array(
		// The empty image version key defines options for the original image:
		'' => array(
			// Automatically rotate images based on EXIF meta data:
			'auto_orient' => true,
			'crop' => true,
			'max_width' => 2160,
			'max_height' => 1440
		),
		// Preview
		'gallery' => array(
			'max_height' => 500
		),
	)
));
```

Create a database table for uploaded files
```sql
CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
)
```


the package comes with a helper:
```php
# AppController.php
public $helpers = array(
	'Form' => array('className' => 'BlueUpload.BlueUpload'),
);
```

```php
# View/action.ctp
<div class="form-group blueupload">
	<?php echo $this->Form->input('Upload', array('type'=>'blueupload', 'upload_config'=>'photos', 'label'=>__('Photos'))); ?>
</div>
```

## Customize data saved into uploads table

The `BlueUpload.BlueUploadController::upload` action emitts a `Model.BlueUpload.beforeSave` event
you may want to modify the data by listening to it:

```php
# in Lib/Event/BlueUploadListener.php
<?php
App::uses('CakeEventListener', 'Event');

class BlueUploadListener implements CakeEventListener {
	/**
	 * Register the handlers.
	 *
	 * @see CakeEventListener::implementedEvents()
	 */
	public function implementedEvents() {
		return array(
			'Model.BlueUpload.beforeSave' => 'beforeSave'
		);
	}

	/**
	 * event callback
	 */
	public function beforeSave(CakeEvent $event) {
		$upload = $event->data['upload'];

		if (isset($upload['galleryUrl'])) {
			//$file->galleryUrl == /img/photos/gallery/DSCF2062%20%281%29.JPG&#039;
			$image_path = 'file://' . rtrim(WWW_ROOT, '/');
			$info = getimagesize($image_path . urldecode($upload['galleryUrl']));
			$upload['width']  = $info[0];
			$upload['height'] = $info[1];
		}

		$event->result['upload'] = $upload;
	}
}

```
```php
# in Config/bootstrap.php
// Load the global event listeners.
require_once APP . 'Config' . DS . 'events.php';
```
```php
# in Config/events.php
App::uses('BlueUploadListener', 'Lib/Event');

// Attach listeners - on particular Models
$BlueUploadModel = ClassRegistry::init('BlueUpload.Upload');
$BlueUploadModel->getEventManager()->attach(new BlueUploadListener());
```
