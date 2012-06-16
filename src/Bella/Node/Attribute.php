<?php

class Bella_Node_Attribute extends Bella_Node_SqlLiteral
{
	public $relation;
	
	public function __construct($value, $relation)
	{
		parent::__construct($value);
		$this->relation = $relation;
	}
}