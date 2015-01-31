<?php

namespace Acme\Extensions\HelloWorld;

use Betterpress\Extensions\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HelloWorldExtension implements Extension
{

    public function build(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('config/services.yml');
    }


}