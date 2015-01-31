<?php

namespace Betterpress\Bridge\Wordpress\Hooks;

class HookManager
{
    private $hooks = [];

    public function add($key, $function)
    {
        $this->hooks[$key][] = $function;
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