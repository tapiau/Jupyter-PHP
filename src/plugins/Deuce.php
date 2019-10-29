<?php

use JupyterPHP\PluginManager;

class Deuce
{
	/** @var JupyterPHP\PluginManager */
	private $pluginManager;
	
	public function __construct(PluginManager $pluginManager)
	{
		$this->pluginManager=$pluginManager;
	}
	
	public function __invoke(array $data)
	{
		$chart = new Chart($data);
		
		$this->pluginManager->send(
			'display_data',
			[
				'data'    =>[
					"application/vnd.vegalite.v2+json"=>$chart
				],
				'metadata'=>[]
			]
		);
	}
	
	
}

class Chart
{
	public $schema="https://vega.github.io/schema/vega/v3.0.json";
	
	public $width=400;
	public $height=200;
	public $padding=5;
	
	/** @var ChartData */
	public $data;
	
	/** @var ChartSignals */
	public $signals;

	/** @var ChartScales[] */
	public $scales;
	
	/** @var ChartAxe[] */
	public $axes;

	/** @var ChartMark[] */
	public $marks;
	
	public function __construct(array $data)
	{
		$this->signals = json_decode(file_get_contents(__DIR__.'/plugins/Deuce/signals.json'))->signals;
		$this->scales = json_decode(file_get_contents(__DIR__.'/plugins/Deuce/scales.json'))->scales;
		$this->axes = json_decode(file_get_contents(__DIR__.'/plugins/Deuce/axes.json'))->axes;
		$this->marks = json_decode(file_get_contents(__DIR__.'/plugins/Deuce/marks.json'))->marks;
		
		$this->data = new ChartData($data);
	}
}

class ChartData
{
	public $name = "table";
	/** @var ChartDataValue[] */
	public $values = [];
	
	public function __construct(array $data)
	{
		foreach($data as $key=>$value)
		{
			$this->values[] = new ChartDataValue($key,$value);
		}
	}
}

class ChartDataValue
{
	public $category;
	public $amount;
	
	public function __construct($category,$amount)
	{
		$this->category = $category;
		$this->amount = $amount;
		
	}
}

class ChartSignals
{
	public $name = "tooltip";
	public $value = [];
	
	/** @var ChartSignalsEvent[] */
	public $on;
}

class ChartSignalsEvent
{
	public $events = "rect:mouseover";
	public $update = "datum";
}

class ChartScales
{
	public $name = "xscale";
	public $type = "band";
	
	/** @var ChartScalesDomain */
	public $domain;
	
	public $range = "width";
	public $padding = 0.05;
	public $round = true;
}

class ChartScalesDomain
{
	public $data = "table";
	public $field = "category";
}

class ChartAxe
{
	public $orient = "bottom";
	public $scale = "xscale";
}

class ChartMark
{
	public $type = "rect";
	public $from = ["data"=>"table"];
}


