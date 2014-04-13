<?php
Router::add("/admin/configuration/save", array('controller'=>'configuration', 'action'=>'save_configuration', 'type' => 'admin'));
Router::add("/admin/configuration/<module:\w+>", array('controller'=>'configuration', 'action'=>'config_edit', 'type' => 'admin'));

