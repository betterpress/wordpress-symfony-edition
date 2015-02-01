<?php

namespace Betterpress\Extensions;

use Betterpress\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface Extension
{
    public function build(ContainerBuilder $container);
    public function setup(Application $application, ContainerBuilder $container);
}