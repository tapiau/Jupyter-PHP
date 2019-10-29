<?php

/**
 * Author: Zbigniew 'zibi' Jarosik <zibi@nora.pl>
 */

use JupyterPHP\PluginManager;

class HTML
{
    /** @var JupyterPHP\PluginManager */
    private $pluginManager;

    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }
    public function __invoke($htmlData)
    {
        $this->pluginManager->send(
            'display_data',
            [
                'data'=>[
                    'text/html'=>$htmlData
                ],
                'metadata'=>[]
            ]
        );
    }
}
