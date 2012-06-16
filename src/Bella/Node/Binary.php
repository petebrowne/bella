<?php

class Bella_Node_Binary extends Bella_Node
{
	public $left, $right;
	
	public function __construct($left, $right)
	{
		$this->left = $left;
		$this->right = $right;
	}
}