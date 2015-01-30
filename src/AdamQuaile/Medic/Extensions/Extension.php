<?php

namespace AdamQuaile\Medic\Extensions;

use AdamQuaile\Medic\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface Extension
{
    public function build(ContainerBuilder $container);
}