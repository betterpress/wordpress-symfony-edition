<?php

require_once __DIR__ . '/vendor/autoload.php';

$yaml = new \Symfony\Component\Yaml\Yaml();
$config = $yaml->parse(__DIR__ . '/config/parameters.yml');


global $wpApplication;
$wpApplication = new Betterpress\Application(
	$config,
	__DIR__
);
$wpApplication->configure();


