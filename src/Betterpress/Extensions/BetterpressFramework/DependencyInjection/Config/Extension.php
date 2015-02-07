<?php

namespace Betterpress\Extensions\BetterpressFramework\DependencyInjection\Config;

use Betterpress\Extensions\BetterpressFramework\DependencyInjection\Compiler\RegisterHooksPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Extension implements ExtensionInterface
{
    /**
     * Loads a specific configuration.
     *
     * @param array $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../'));
        $loader->load('config/services.yml');

        // TODO: Use configuration / tree builder to configure and merge config
        $container->setParameter('wordpress.database.name',     $config[0]['database']['name']);
        $container->setParameter('wordpress.database.host',     $config[0]['database']['host']);
        $container->setParameter('wordpress.database.user',     $config[0]['database']['user']);
        $container->setParameter('wordpress.database.password', $config[0]['database']['password']);

        $container->setParameter('wordpress.structure.content', $config[0]['structure']['content']);

    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     *
     * @api
     */
    public function getNamespace()
    {
        return 'http://example.org/schema/dic/'.$this->getAlias();
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     *
     * @api
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     *
     * @api
     */
    public function getAlias()
    {
        return 'wordpress';
    }

}