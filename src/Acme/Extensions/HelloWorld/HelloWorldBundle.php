<?php

namespace Acme\Extensions\HelloWorld;

use Acme\Extensions\HelloWorld\DI\HelloWorldExtension;
use Betterpress\Application;
use Betterpress\Extensions\BetterpressBundle;
use Betterpress\Extensions\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HelloWorldBundle implements BetterpressBundle
{
    /**
     * @return ExtensionInterface
     */
    public function getContainerExtension()
    {
        return new HelloWorldExtension();
    }


    public function build(ContainerBuilder $container)
    {

    }

    public function setup(Application $application, ContainerBuilder $container)
    {

    }


}