<?php

class Bella_Node_Primitive extends Bella_Node
{
	public $value;
	
	public function __construct($value)
	{
		$this->value = $value;
	}
}