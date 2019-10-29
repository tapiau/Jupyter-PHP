<?php

/**
 * Author: Zbigniew 'zibi' Jarosik <zibi@nora.pl>
 */

use JupyterPHP\zPHP;

class Vega
{
    /** @var \Litipk\JupyterPHP\zPHP */
    private $zPHP;

    public function __construct(zPHP $zPHP)
    {
        $this->zPHP = $zPHP;
    }
    public function __invoke($filename)
    {
        $this->zPHP->send(
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
