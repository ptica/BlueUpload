<?php
App::uses('BlueUploadAppModel', 'BlueUpload.Model');
/**
 * Upload Model
 *
 */
class Upload extends BlueUploadAppModel {
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	/*
	* mangle the url for apps in webroot subdirs
	*/

	public function afterFind($results, $primary = false) {
		$fields = array('url', 'thumbnailUrl');
		foreach ($results as $key => $val) {
			foreach ($fields as $field) {
				if (isset($val['Upload'][$field])) {
					$results[$key]['Upload'][$field] = Router::url($val['Upload'][$field]);
				}
			}
		}
		return $results;
	}
}
