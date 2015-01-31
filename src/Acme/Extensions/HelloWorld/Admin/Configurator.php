<?php

namespace Acme\Extensions\HelloWorld\Admin;

use Betterpress\Bridge\Wordpress\Hooks\HookListener;

class Configurator implements HookListener
{
    public function execute()
    {
        \add_options_page( 'My Plugin', 'My Plugin', 'manage_options', 'my-plugin', function() {return 'Hello!';} );
    }

}