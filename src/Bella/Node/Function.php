<?php

class Bella_Node_Function extends Bella_Node
{
	public $expression, $alias;
	
	public function __construct($expression, $alias = NULL)
	{
		$this->expression = $expression;
		$this->alias = $alias;
	}
	
	public function is($alias)
	{
		$this->alias = new Bella_Node_SqlLiteral($alias);
		return $this;
	}
}