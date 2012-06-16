<?php

class Bella_Node_Count extends Bella_Node_Function
{
	public $distinct;
	
	public function __construct($expression, $distinct = FALSE, $alias = NULL)
	{
		parent::__construct($expression, $alias);
		$this->distinct = $distinct;
	}
}