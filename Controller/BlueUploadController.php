<?php
App::uses('AppController', 'Controller');
/**
* Uploads Controller
*/
class BlueUploadController extends BlueUploadAppController {
	public $uses = array('BlueUpload.Upload');

	public function upload($config='default') {
		if (!$this->request->is(array('post', 'put'))) {
			die('Method not allowed');
		}

		App::import('Vendor', 'BlueUpload.UploadHandler', array('file' => 'UploadHandler.php'));

		$options = Configure::read('BlueUpload.options');

		$upload_handler = new UploadHandler($options[$config], $initialize=false);
		$content = $upload_handler->post($print_response=false);

		// save into uploads table
		foreach ($content['files'] as &$file) {
			$upload = array(
				'name' => $file->name,
				'size' => $file->size,
				'type' => $file->type,
				'url'  => $file->url,
				'thumbnailUrl' => $file->thumbnailUrl,
				'previewUrl' => $file->previewUrl,
				'deleteUrl' => $file->deleteUrl,
				'deleteType' => $file->deleteType
			);
			if (!isset($file->error)) {
				$this->Upload->create();
				$this->Upload->save($upload);
				$file->id = $this->Upload->getLastInsertID();
			} else {

			}
		}

		$json = json_encode($content);
		$upload_handler->head();
		echo $json;

		$this->autoRender = false;
	}
}
