<?php

namespace Betterpress\Extensions\BetterpressFramework;

use Betterpress\Application;
use Betterpress\Extensions\Extension;
use Betterpress\Wordpress\Adapter\Hooks\Hook;
use Betterpress\Wordpress\Adapter\Hooks\HookConfiguration;
use Betterpress\Wordpress\Adapter\Hooks\HookManager;
use Betterpress\Wordpress\DashboardWidgets\Widget;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class BetterPressFrameworkExtension implements Extension
{

    public function build(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('config/services.yml');
    }

    public function setup(Application $application, ContainerBuilder $container)
    {
        $this->registerHooks($container);
        $this->registerShortcodes($container);
    }


    private function registerShortcodes(ContainerBuilder $container)
    {
        $shortcodeManager = $container->get('wordpress.shortcode_manager');
        foreach ($container->findTaggedServiceIds('wordpress.shortcode') as $service => $tags) {
            $shortcodeManager->add($container->get($service));
        }
        $shortcodeManager->registerShortcodes();

    }

    private function registerHooks(ContainerBuilder $container)
    {
        /**
         * @var HookManager $hookManager
         */
        $hookManager = $container->get('wordpress.hooks.hook_manager');

        foreach ($container->findTaggedServiceIds('wordpress.hook') as $id => $tags) {
            $service = $container->get($id);
            if (!($service instanceof Hook)) {
                throw new \LogicException(
                    "The service $id must implement \\Betterpress\\Wordpress\\Adapter\\Hooks\\Hook"
                );
            }
            foreach ($tags as $tagInfo) {
                $hookManager->add(
                    new HookConfiguration(
                        $tagInfo['type'],
                        $tagInfo['hook'],
                        $service,
                        $tagInfo['priority']?: null,
                        $tagInfo['acceptArgumentsCount'] ?: null
                    )
                );
            }
        }

        $hookManager->registerHooks();

    }



}