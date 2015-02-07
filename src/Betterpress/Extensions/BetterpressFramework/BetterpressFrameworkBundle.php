<?php

namespace Betterpress\Extensions\BetterpressFramework;

use Betterpress\Application;
use Betterpress\Extensions\BetterpressBundle;
use Betterpress\Extensions\BetterpressFramework\DependencyInjection\Compiler\RegisterHooksPass;
use Betterpress\Extensions\BetterpressFramework\DependencyInjection\Config\Extension;
use Betterpress\Wordpress\Adapter\Hooks\Hook;
use Betterpress\Wordpress\Adapter\Hooks\HookConfiguration;
use Betterpress\Wordpress\Adapter\Hooks\HookManager;
use Betterpress\Wordpress\DashboardWidgets\Widget;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class BetterPressFrameworkBundle implements BetterpressBundle
{
    /**
     * @return ExtensionInterface
     */
    public function getContainerExtension()
    {
        return new Extension();
    }


    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterHooksPass());
    }

    public function setup(Application $application, ContainerBuilder $container)
    {
        $container->get('wordpress.hooks.hook_manager')->registerHooks();

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



}