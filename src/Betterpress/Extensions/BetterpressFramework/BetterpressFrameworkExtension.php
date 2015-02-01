<?php

namespace Betterpress\Extensions\BetterpressFramework;

use Betterpress\Application;
use Betterpress\Extensions\Extension;
use Betterpress\Wordpress\Adapter\Hooks\Hook;
use Betterpress\Wordpress\Adapter\Hooks\HookConfiguration;
use Betterpress\Wordpress\Adapter\Hooks\HookManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BetterPressFrameworkExtension implements Extension
{

    public function build(ContainerBuilder $container)
    {
        $container
            ->register('php.globals.constants', 'AdamQuaile\PhpGlobal\Constants\ConstantWrapper');

        $container
            ->register('php.globals.functions', 'AdamQuaile\PhpGlobal\Functions\FunctionWrapper');

        $container
            ->register('wordpress.hooks.hook_manager', 'Betterpress\Wordpress\Adapter\Hooks\HookManager')
            ->addArgument($container->getDefinition('php.globals.functions'));

        $container
            ->register('wordpress.shortcode_manager', 'Betterpress\Shortcode\ShortcodeManager')
            ->addArgument($container->getDefinition('php.globals.functions'));

    }

    public function setup(Application $application, ContainerBuilder $container)
    {
        $this->registerHooks($container);
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