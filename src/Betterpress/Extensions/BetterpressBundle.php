<?php

namespace Betterpress\Extensions;

use Betterpress\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

interface BetterpressBundle
{
    /**
     * @return ExtensionInterface
     */
    public function build(ContainerBuilder $container);

    /**
     * @return ExtensionInterface
     */
    public function getContainerExtension();

    public function setup(Application $application, ContainerBuilder $container);
}