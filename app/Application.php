<?php

class Application extends \Betterpress\Application
{
    /**
     * @return \Betterpress\Extensions\BetterpressBundle[]
     */
    public function getExtensions()
    {
        return [
            new \Betterpress\Extensions\BetterpressFramework\BetterPressFrameworkBundle(),
            new \Acme\Extensions\HelloWorld\HelloWorldBundle(),
        ];
    }

}