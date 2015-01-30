<?php

namespace AdamQuaile\Betterpress\Extensions;

use AdamQuaile\Betterpress\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface Extension
{
    public function build(ContainerBuilder $container);
}