<?php

class Bella_SelectManager extends Bella_TreeManager
{	
	public function __construct($table)
	{
		parent::__construct();

		$this->ast = new Bella_Node_SelectStatement;
		$this->from($table);
	}
	
	public function project()
	{
		$projections = func_get_args();
		
		foreach($projections as $projection)
		{
			$this->ast->projections[] = (is_object($projection)) ? $projection : new Bella_Node_SqlLiteral($projection);
		}
		
		return $this;
	}
		
	public function from($table)
	{
		if ( is_string($table) )
		{
			$this->ast->froms = new Bella_Node_SqlLiteral($table);
		}
		
		$this->ast->froms = $table;
	}
	
	public function group()
	{
		$columns = func_get_args();
	
		foreach($columns as $column)
		{
			$this->ast->groups[] = (is_object($column)) ? $column : new Bella_Node_SqlLiteral($column);
		}
	
		return $this;	
	}
	
	public function on($expressions)
	{
		
	}
	
	public function join($relation, $class)
	{
		
	}
	
	public function skip($amount)
	{
		$this->ast->offset = new Bella_Node_Offset($amount);
		return $this;
	}
	
	public function take($amount)
	{
		$this->ast->limit = $amount;
		return $this;
	}
	
	public function having($expression)
	{
		$this->ast->having = new Bella_Node_Having($expression);
		return $this;		
	}
	
	public function where($expression)
	{
		$this->ast->wheres = $expression;
		return $this;
	}
	
	public function order()
	{
		$columns = func_get_args();

		foreach($columns as $column)
		{
			$this->ast->orders[] = (is_object($column)) ? $column : new Bella_Node_SqlLiteral($column);
		}
	
		return $this;
	}
}