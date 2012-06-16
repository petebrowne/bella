<?php

class Bella_Node 
{
	public function otherwise($right)
	{
		return new Bella_Node_Grouping(new Bella_Node_Or($this, $right));
	}	
	
	public function also($right)
	{
		return new Bella_Node_Grouping(new Bella_Node_And($this, $right));
	}
}