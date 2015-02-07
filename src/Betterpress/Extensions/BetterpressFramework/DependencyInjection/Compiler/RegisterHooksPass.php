<?php

namespace Betterpress\Extensions\BetterpressFramework\DependencyInjection\Compiler;

use Betterpress\Wordpress\Adapter\Hooks\Hook;
use Betterpress\Wordpress\Adapter\Hooks\HookConfiguration;
use Betterpress\Wordpress\Adapter\Hooks\HookManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterHooksPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
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
    }

}