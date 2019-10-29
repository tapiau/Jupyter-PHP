<?php

/**
 * Author: Zbigniew 'zibi' Jarosik <zibi@nora.pl>
 */

use JupyterPHP\PluginManager;

class Image
{
    /** @var JupyterPHP\PluginManager */
    private $pluginManager;

    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    public function __invoke($imageData)
    {
    	if(file_exists($imageData))
		{
			$imageData = file_get_contents($imageData);
		}
  
		$file_info = new \finfo(FILEINFO_MIME_TYPE);
		$mime_type = $file_info->buffer($imageData);
		
		$image = imagecreatefromstring($imageData);

        $width = imagesx($image);
        $height = imagesy($image);

        $this->pluginManager->send(
            'display_data',
            [
                'data'=>[
                    $mime_type=>base64_encode($imageData)
                ],
                'metadata'=>[
                    $mime_type=>[
                        'width'=>$width,
                        'height'=>$height
                    ]
                ]
            ]
        );
    }
}
