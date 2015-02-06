<?php

namespace Betterpress\Extensions\BetterpressFramework\Setup\Hooks;

use Betterpress\Wordpress\Adapter\Hooks\Hook;
use Betterpress\Wordpress\Adapter\Hooks\HookContext;
use Betterpress\Wordpress\DashboardWidgets\Widget;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ModifyDashboardHook implements Hook
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }
    public function execute(HookContext $context)
    {
        $this->registerDashboardWidgets($this->container);
    }

    private function registerDashboardWidgets(ContainerBuilder $container)
    {
        $dashboard = $container->get('wordpress.dashboard.dashboard');
        foreach ($container->findTaggedServiceIds('wordpress.dashboard.widget') as $id => $info) {

            $service = $container->get($id);

            if (!($service instanceof Widget)) {
                throw new \LogicException(
                    "The service $id must implement \\Betterpress\\Wordpress\\DashboardWidgets\\Widget"
                );
            }
            $method = array_key_exists('position', $info) && ('side' == $info['position'])
                ? 'addSideWidget'
                : 'addWidget'
            ;

            $dashboard->$method($service);
        }
    }

}