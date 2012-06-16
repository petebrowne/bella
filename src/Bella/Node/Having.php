<?php

class Bella_Node_Having extends Bella_Node
{
	public $expression;
	
	public function __construct($expression)
	{
		$this->expression = $expression;
	}
}