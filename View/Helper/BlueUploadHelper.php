<?php
/**
* This helper outputs and file input element
*
* @copyright Copyright (c) Jan Ptacek (https://twitter.com/ptica)
* @link https://github.com/ptica
* @package app.View.Helper
* @version 1.0.0
* @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*
* @author Jan Ptacek (jan.ptacek@gmail.com)
*/

App::uses('Router', 'Routing');
App::uses('FormHelper', 'View/Helper');

/**
* Class BlueUploadHelper
*
* @package app.View.Helper
*/
class BlueUploadHelper extends FormHelper {
	/**
	* Constructor
	*/
	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->Form = $this->_View->loadHelper('Bs3Helpers.Bs3Form');
	}

	public function input($fieldName, $options = array()) {
		if (0) {

		} else {
			return parent::input($fieldName, $options);
		}
	}
}
