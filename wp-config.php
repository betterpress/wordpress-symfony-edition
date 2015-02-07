<?php

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Application.php';

//$yaml = new \Symfony\Component\Yaml\Yaml();
//$config = $yaml->parse(__DIR__ . '/app/config/config.yml');


global $wpApplication;
$wpApplication = new Application(
//	$config,
	__DIR__
);
$wpApplication->configure();


