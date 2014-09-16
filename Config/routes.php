<?php
	Router::connect('/upload/*', array('plugin'=>'blue_upload', 'controller' => 'blue_upload', 'action' => 'upload'));
