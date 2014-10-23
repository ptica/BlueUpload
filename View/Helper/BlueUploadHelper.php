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
App::uses('Bs3FormHelper', 'Bs3Helpers.View/Helper');

/**
* Class BlueUploadHelper
*
* @package app.View.Helper
*/
class BlueUploadHelper extends Bs3FormHelper {
	/**
	* Constructor
	*/
	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->Form = $this->_View->loadHelper('Bs3Helpers.Bs3Form');
		$this->CakeForm = $this->_View->loadHelper('Form');
	}

	public function input($fieldName, $options = array()) {
		if (@$options['type'] == 'blueupload') {
			// todo try to render the surrounding divs+classes from the $Bs3Form
			// so Bs3Form config is respected

			// construct the html NOW per partest
			// as without a dive into Bs3 the options do not cover the html I need now
			$label = $this->Html->tag('label', $options['label'], array('class'=>'col-sm-2 control-label', 'for'=>'files[]'));

			// render the input element
			$upload_config = Configure::read('BlueUpload.options.'.$options["upload_config"]);
			$options['type'] = 'file';
			$options['name'] = 'files[]';
			$options['multiple'] = true;
			$options['data-provide'] = 'fileupload';
			$options['data-url'] = $upload_config['script_url'];
			$options['label'] = false;
			$options['div'] = false;
			$input = $this->CakeForm->input($fieldName, $options);

			// render current values
			$template = $upload_config['edit_template'];
			$thumbnails = '';
			if (!empty($this->data['Upload'])) $thumbnails = array_reduce($this->data['Upload'], function ($carry, $item) use ($template) {
				$carry .= $this->_View->Element($template, $item);
				return $carry;
			});
			$thumbnails = $this->Html->div('thumbnails', $thumbnails);

			// add more button
			$plus = $this->Html->tag('i', '', array('class'=>'glyphicon glyphicon-plus'));
			//$button_label = $this->Html->tag('span', __("Select files..."));
			$button_label = $this->Html->tag('span', __("vybrat..."));
			$button = $this->Html->tag('span', $plus . ' ' . $button_label . $input, array('class'=>'btn btn-primary fileinput-button'));
			$element = $this->Html->div('col-sm-7 input-group', $button . $thumbnails);

			return $label . $element;
		} else {
			return parent::input($fieldName, $options);
		}
	}
}
