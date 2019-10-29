<?php

/**
 * Author: Zbigniew 'zibi' Jarosik <zibi@nora.pl>
 */

use JupyterPHP\PluginManager;

class Vega
{
    /** @var JupyterPHP\PluginManager */
    private $pluginManager;

    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }
    public function __invoke($filename)
    {
        $this->pluginManager->send(
            'display_data',
            [
                'data'=>[
					"application/vnd.vegalite.v2+json"=>json_decode(file_get_contents($filename))
                ],
                'metadata'=>[]
            ]
        );
    }
}
