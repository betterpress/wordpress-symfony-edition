<?php

namespace Acme\Extensions\HelloWorld\Admin;

use Betterpress\Wordpress\Adapter\Hooks\Hook;
use Betterpress\Wordpress\Adapter\Hooks\HookContext;

class Configurator implements Hook
{
    public function execute(HookContext $context)
    {
        \add_options_page( 'My Plugin', 'My Plugin', 'manage_options', 'my-plugin', function() {return 'Hello!';} );
    }

}