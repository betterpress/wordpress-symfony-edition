<?php

namespace Acme\Extensions\HelloWorld\Shortcode;

use Betterpress\Shortcode\Shortcode;
use Betterpress\Shortcode\ShortcodeContext;

class HelloShortcode implements Shortcode
{
    public function getName()
    {
        return 'hello';
    }

    public function getDefaultAttributes()
    {
        return array(
            'name' => null
        );
    }

    public function render(ShortcodeContext $context)
    {
        $args = $context->getResolvedAttributes();

        return 'Hello, ' . ($args['name'] ? ucfirst($args['name']) : 'anonymous') . '.';
    }

}