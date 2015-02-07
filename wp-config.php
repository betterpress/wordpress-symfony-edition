<?php

/*
 * Config / bootstrap file
 *
 * Wordpress searches for wp-config.php in its own directory and
 * one level above. Here we setup all the configuration values
 * as per http://codex.wordpress.org/Editing_wp-config.php but we
 * move this configuration to YAML files in app/config
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Application.php';

global $wpApplication;
$wpApplication = new Application(__DIR__);
$wpApplication->configure();


