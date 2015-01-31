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

        $container->get('wordpress.hook_manager')->add('admin_menu', function() {
            \add_options_page( 'My Plugin', 'My Plugin', 'manage_options', 'my-plugin', function() {return 'Hello!';} );
        });
    }


}