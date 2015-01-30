<?php

require_once __DIR__ . '/vendor/autoload.php';

$yaml = new \Symfony\Component\Yaml\Yaml();
$config = $yaml->parse(__DIR__ . '/config/parameters.yml');


$application = new AdamQuaile\Medic\Application(
	new \AdamQuaile\Medic\Bridge\Php\Constants\PhpConstantManager(),
	$config,
	__DIR__ . '/wordpress'
);
$application->configure();


