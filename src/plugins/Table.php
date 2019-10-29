<?php

/**
 * Author: Zbigniew 'zibi' Jarosik <zibi@nora.pl>
 */

use JupyterPHP\PluginManager;

class Table
{
    /** @var JupyterPHP\PluginManager */
    private $pluginManager;

    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }
    public function __invoke($array)
    {
		$htmlData = "<table border='1'>".
			"<tr>".join('',array_map(function($item){return "<th>{$item}</th>";},array_keys(reset($array))))."</tr>"
			.join(
				'',
				array_map(
					function($row)
					{
						return
							"<tr>"
							.join(
								"",
								array_map(
									function($item)
									{
										return "<td>{$item}</td>";
									},
									$row
								)
							)
							."</tr>";
					},
					$array
				)
			)
			."</table>"
		;
    	
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
