<?php

class Bella_Node_SqlLiteral extends Bella_Node
{
	public $value;
	
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	// Expressions
	public function count($distinct = false)
	{
		return new Bella_Node_Count($this, $distinct);
	}
	
	public function sum()
	{
		return new Bella_Node_Sum($this, new Bella_Node_SqlLiteral('sum_id'));
	}
	
	public function maximum()
	{
		return new Bella_Node_Maximum($this, new Bella_Node_SqlLiteral('maximum'));
	}

	public function minimum()
	{
		return new Bella_Node_Minimum($this, new Bella_Node_SqlLiteral('minimum'));
	}
	
	public function average()
	{
		return new Bella_Node_Average($this, new Bella_Node_SqlLiteral('average'));
	}
	
	// Predictions
	public function not_eq($other)
	{
		return new Bella_Node_NotEqual($this, $other);
	}
	
	public function not_eq_any($others)
	{
		return $this->grouping_any('not_eq', $others);
	}
	
	public function not_eq_all($others)
	{
		return $this->grouping_all('not_eq', $others);
	}
	
	public function eq($other)
	{
		return new Bella_Node_Equality($this, $other);
	}
	
	public function eq_any($others)
	{
		return $this->grouping_any('eq', $others);
	}
	
	public function eq_all($others)
	{
		return $this->grouping_all('eq', $others);
	}
	
	public function in($other)
	{
		return new Bella_Node_In($this, $other);
	}
	
	public function in_any($others)
	{
		return $this->grouping_any('in', $others);
	}
	
	public function in_all($others)
	{
		return $this->grouping_all('in', $others);
	}
	
	public function not_in($other)
	{
		return new Bella_Node_NotIn($this, $other);
	}
	
	public function not_in_any($others)
	{
		return $this->grouping_any('not_in', $others);
	}
	
	public function not_in_all($others)
	{
		return $this->grouping_all('not_in', $others);
	}
	
	public function matches($other)
	{
		return new Bella_Node_Matches($this, $other);
	}
	
	public function match_any($others)
	{
		return $this->grouping_any('matches', $others);
	}
	
	public function match_all($others)
	{
		return $this->grouping_all('matches', $others);
	}
	
	public function does_not_match($other)
	{
		return new Bella_Node_DoesNotMatch($this, $other);
	}
	
	public function does_not_match_any($others)
	{
		return $this->grouping_any('does_not_match', $others);
	}
	
	public function does_not_match_all($others)
	{
		return $this->grouping_all('does_not_match', $others);
	}
	
	public function gteq($other)
	{
		return new Bella_Node_GreaterThanOrEqual($this, $other);
	}
	
	public function gteq_any($others)
	{
		return $this->grouping_any('gteq', $others);
	}
	
	public function gteq_all($others)
	{
		return $this->grouping_all('gteq', $others);
	}
	
	public function gt($other)
	{
		return new Bella_Node_GreaterThan($this, $other);
	}
	
	public function gt_any($others)
	{
		return $this->grouping_any('gt', $others);
	}
	
	public function gt_all($others)
	{
		return $this->grouping_all('gt', $others);
	}
	
	public function lteq($other)
	{
		return new Bella_Node_LessThanOrEqual($this, $other);
	}
	
	public function lteq_any($others)
	{
		return $this->grouping_any('lteq', $others);
	}
	
	public function lteq_all($others)
	{
		return $this->grouping_all('lteq', $others);
	}
	
	public function lt($other)
	{
		return new Bella_Node_LessThan($this, $other);
	}
	
	public function lt_any($others)
	{
		return $this->grouping_any('glt', $others);
	}
	
	public function lt_all($others)
	{
		return $this->grouping_all('glt', $others);
	}

	public function asc()
	{
		return new Bella_Node_Ordering($this, Bella_Node_Ordering::ASC);
	}
	
	public function desc()
	{
		return new Bella_Node_Ordering($this, Bella_Node_Ordering::DESC);
	}
	
	public function grouping_any($method_id, $others)
	{
		$first = $this->$method_id(array_shift($others));
		
		foreach($others as $other)
		{
			$next = $this->$method_id($other);

			$first = new Bella_Node_Or($first, $next);
		}

		return new Bella_Node_Grouping($first);
	}
	
	public function grouping_all($method_id, $others)
	{
		$first = $this->$method_id(array_shift($others));
		
		foreach($others as $other)
		{
			$next = $this->$method_id($other);

			$first = new Bella_Node_And($first, $next);
		}

		return new Bella_Node_Grouping($first);
	}
}