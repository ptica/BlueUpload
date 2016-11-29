<?php
	Router::connect('/upload/list_by_type/*', array('plugin'=>'blue_upload', 'controller' => 'blue_upload', 'action' => 'list_by_type'));
	Router::connect('/upload/*', array('plugin'=>'blue_upload', 'controller' => 'blue_upload', 'action' => 'upload'));
