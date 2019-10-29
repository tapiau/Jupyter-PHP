<?php

/**
 * Author: Zbigniew 'zibi' Jarosik <zibi@nora.pl>
 */

namespace JupyterPHP;

use React\ZMQ\SocketWrapper;

class PluginManager
{
	/** @var JupyterBroker */
	private $broker;
	
	/** @var SocketWrapper */
	private $iopubSocket;
	
	private $header;
	
	public function __construct($broker,$iopubSocket)
	{
		$this->broker = $broker;
		$this->iopubSocket = $iopubSocket;
		
		$this->reloadPlugins();
	}
	public function send($msgType, $data)
	{
		$this->broker->send($this->iopubSocket, $msgType, $data, $this->header);
	}
	public function setHeader($header)
	{
		$this->header = $header;
	}
	public function reloadPlugins()
	{
		$this->pluginVersion = str_replace('.','',microtime(true));
	}
	private function getObject($name)
	{
		$namespace = str_replace('.','','SpecialDimension_'.$this->pluginVersion);
		$className = "{$namespace}\\{$name}";
		
		if(!class_exists($className))
		{
			$fileName = __DIR__."/plugins/{$name}.php";
			$classBody = "namespace {$namespace}; ?>".file_get_contents($fileName);
			
			eval($classBody);
		}
		
		$className = "{$namespace}\\{$name}";
		$object = new $className($this);
		return $object;
	}
	
	public function __call($className,$params)
	{
		$object = $this->getObject($className);
		
		call_user_func_array($object,$params);
//        call_user_func_array([$object,'__invoke'],$params);
	}
}