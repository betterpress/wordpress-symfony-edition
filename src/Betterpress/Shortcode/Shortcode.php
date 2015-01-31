<?php

namespace Betterpress\Shortcode;

interface Shortcode
{
    public function getName();
    public function getDefaultAttributes();

    public function render(ShortcodeContext $context);
}