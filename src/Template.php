<?php
namespace Multt\Generators;

class Template
{

	private $text;

	private $data = array();

	public function __construct($file = null)
	{
		$this->text = file_get_contents($file);
	}

	public function set($key, $value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function clear()
	{
		$this->data = [];
	}

	public function render()
	{
		$compiledText = $this->text;
		foreach ($this->data as $key => $value) {
			$compiledText = str_replace('{{' . $key . '}}', $value, $compiledText);
		}
		return $compiledText;
	}
}
