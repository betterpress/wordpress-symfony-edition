<?php

namespace Acme\Extensions\HelloWorld\Admin\Dashboard;

use Betterpress\Wordpress\DashboardWidgets\Widget;

class HelloWidget implements Widget
{
    public function getSlug()
    {
        return 'hello-widget';
    }

    public function getTitle()
    {
        return 'Hello, Widget';
    }

    public function render()
    {
        echo '<p>Hi!</p>';
    }

}