<?php

namespace Betterpress\Bridge\Wordpress\Hooks;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HookManager
{
    private $hooks = [];

    public function add($key, $function)
    {
        $this->hooks[$key][] = $function;
    }

    public function loadFromContainer(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('wordpress.hook') as $id => $tags) {
            $service = $container->get($id);
            if (!($service instanceof HookListener)) {
                throw new \LogicException(
                    "The service $id must implement \\Betterpress\\Bridge\\Wordpress\\Hooks\\HookListener"
                );
            }
            foreach ($tags as $tagInfo) {
                $this->add($tagInfo['hook'], array($service, 'execute'));
            }
        }
    }

    public function registerHooks()
    {
        foreach ($this->hooks as $key => $hooks) {
            foreach ($hooks as $hook) {
                \add_action($key, $hook);
            }
        }
    }
}