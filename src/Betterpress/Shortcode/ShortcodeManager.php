<?php

namespace Betterpress\Shortcode;

class ShortcodeManager
{
    /**
     * @var Shortcode[]
     */
    private $shortcodes = array();

    public function add(Shortcode $shortcode)
    {
        $this->shortcodes[] = $shortcode;
    }

    public function registerShortcodes()
    {
        foreach ($this->shortcodes as $shortcode) {

            \add_shortcode($shortcode->getName(), $this->createShortcodeHandler($shortcode));
        }
    }

    private function createShortcodeHandler(Shortcode $shortcode)
    {
        return function($userAttrs) use ($shortcode) {
            $resolvedAttrs = \shortcode_atts($shortcode->getDefaultAttributes(), $userAttrs);

            $context = new ShortcodeContext($userAttrs, $resolvedAttrs);

            return $shortcode->render($context);
        };
    }
}