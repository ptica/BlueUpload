<?php
App::uses('AppController', 'Controller');
/**
* Uploads Controller
*/
class BlueUploadController extends BlueUploadAppController {
	public $uses = array('BlueUpload.Upload');

	public function upload($config='default') {
		if (!$this->request->is(array('post', 'put', 'delete'))) {
			die('Method not allowed');
		}

		App::import('Vendor', 'BlueUpload.UploadHandler', array('file' => 'UploadHandler.php'));

		$options = Configure::read("BlueUpload.options.$config");

		$upload_handler = new UploadHandler($options, $initialize=false);

		if ($this->request->is(array('post', 'put'))) {
			$content = $upload_handler->post($print_response=false);

			// save into uploads table
			foreach ($content['files'] as &$file) {
				if (!isset($file->error)) {
					$upload = array(
						'name' => $file->name,
						'size' => $file->size,
						'type' => $file->type,
						'url'  => $file->url,
						'deleteUrl' => $file->deleteUrl,
						'deleteType' => $file->deleteType
					);
					// 'thumbnailUrl' => $file->thumbnailUrl,
					// 'previewUrl'   => $file->previewUrl,
					//  ... etc
					if (isset($options['image_versions'])) foreach ($options['image_versions'] as $version_name => $version) {
						if (!empty($version_name)) {
							$upload[$version_name.'Url'] = $file->{$version_name.'Url'};
						}
					}

					$this->Upload->create();
					$this->Upload->save($upload);
					$file->id = $this->Upload->getLastInsertID();

					unset($file->deleteUrl);
					unset($file->deleteType);

					// account for apps installed in subdir of webroot
					$file->url = Router::url($file->url);
					if (isset($file->thumbnailUrl)) {
						$file->thumbnailUrl = Router::url($file->thumbnailUrl);
					}
				}
			}
		} else if ($this->request->is(array('delete'))) {
			$content = $upload_handler->delete($print_response=false);

			// delete from uploads table
			foreach ($content['files'] as &$file) {
			}
		}

		$json = json_encode($content);
		$upload_handler->head();
		echo $json;

		$this->autoRender = false;
	}
}
