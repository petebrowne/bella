<?php

class Bella_Visitor_ToSql implements Bella_Visitor 
{
	public function accept(Bella_Node $node) 
	{
		return $this->visit($node);
	}
	
	protected function visit($node)
	{
		if ( is_string($node) )
		{
			$node = new Bella_Node_String($node);
		}
		else if ( is_integer($node) )
		{
			$node = new Bella_Node_Number($node);
		}
		
		$method = 'visit'.preg_replace('/^(Bella_)?(Node_)?/', '', get_class($node));
		return $this->$method($node);
	}
	
	public function visitSqlLiteral(Bella_Node_SqlLiteral $node)
	{
		return $node->value;
	}
	
	public function visitCount(Bella_Node_Count $node)
	{
		$distinct = $node->distinct ? "DISTINCT " : "";

		$alias = $node->alias ? $this->visit($node->alias) : NULL;
		$alias = $alias ? " AS {$alias}" : "";

		$name = $this->visit($node->expression);
		
		return "COUNT({$distinct}{$name}){$alias}";
	}
	
	public function visitSum(Bella_Node_Sum $node)
	{
		$alias = $node->alias ? $this->visit($node->alias) : NULL;
		$alias = $alias ? " AS {$alias}" : "";
		$name = $this->visit($node->expression);
		
		return "SUM({$name}){$alias}";
	}
	
	public function visitMaximum(Bella_Node_Maximum $node)
	{
		$alias = $node->alias ? $this->visit($node->alias) : NULL;
		$alias = $alias ? " AS {$alias}" : "";
		$name = $this->visit($node->expression);
		
		return "MAXIMUM({$name}){$alias}";
	}
	
	public function visitMinimum(Bella_Node_Minimum $node)
	{
		$alias = $node->alias ? $this->visit($node->alias) : NULL;
		$alias = $alias ? " AS {$alias}" : "";
		$name = $this->visit($node->expression);
		
		return "MINIMUM({$name}){$alias}";
	}
	
	public function visitAverage(Bella_Node_Average $node)
	{
		$alias = $node->alias ? $this->visit($node->alias) : NULL;
		$alias = $alias ? " AS {$alias}" : "";
		$name = $this->visit($node->expression);
		
		return "AVERAGE({$name}){$alias}";
	}	
	
	public function visitOr(Bella_Node_Or $node)
	{
  	$left = $this->visit($node->left);
  	$right = $this->visit($node->right);

		return "{$left} OR {$right}";
	}
	
	public function visitAnd(Bella_Node_And $node)
	{
  	$left = $this->visit($node->left);
  	$right = $this->visit($node->right);

		return "{$left} AND {$right}";
	}
	
	public function visitLessThan(Bella_Node_LessThan $node)
	{
  	$left = $this->visit($node->left);
  	$right = $this->visit($node->right);

		return "{$left} < {$right}";
	}
	
	public function visitLessThanOrEqual(Bella_Node_LessThanOrEqual $node)
	{
  	$left = $this->visit($node->left);
  	$right = $this->visit($node->right);

		return "{$left} <= {$right}";
	}
	
	public function visitGreaterThan(Bella_Node_GreaterThan $node)
	{
  	$left = $this->visit($node->left);
  	$right = $this->visit($node->right);

		return "{$left} > {$right}";
	}
	
	public function visitGreaterThanOrEqual(Bella_Node_GreaterThanOrEqual $node)
	{
  	$left = $this->visit($node->left);
  	$right = $this->visit($node->right);

		return "{$left} >= {$right}";
	}
	
	public function visitGrouping(Bella_Node_Grouping $node)
	{
  	$expression = $this->visit($node->expression);

		return "({$expression})";
	}	

	public function visitString(Bella_Node_String $node)
	{
		return $this->quote($node->value);
	}
	
	public function visitAttribute(Bella_Node_Attribute $node)
	{
		$relation = $node->relation;
		$table_name = $this->quoteTableName($relation->name);
		$column_name = $this->quoteColumnName($node->value);
		
		return "{$table_name}.{$column_name}";
	}
	
	public function visitNumber(Bella_Node_Number $node)
	{
		return $node->value;
	}
	
	public function visitHaving(Bella_Node_Having $having)
	{
		$expression = $this->visit($having->expression);
		
		return " HAVING {$expression}";
	}
	
	public function visitTable(Bella_Table $table)
	{
		return $this->quoteTableName($table->name);
	}
	
	public function visitSelectStatement(Bella_Node_SelectStatement $node)
	{
		$from_sql = "";
		if ( $froms = $node->froms)
		{
			$from = $this->visit($node->froms);
			
			$from_sql = " FROM {$from}";
		}

		$projections_sql = "";
		if ( $projections = $node->projections )
		{
			$projections_sql .= " ";

			$segments = array();
			foreach($projections as $projection)
			{
				$segments[] = $this->visit($projection);
			}
			
			$projections_sql .= implode(', ', $segments);
		}

		$group_sql = "";
		if ( $groups = $node->groups )
		{
			$group_sql .= " GROUP BY ";

			$segments = array();
			foreach($groups as $group)
			{
				$segments[] = $this->visit($group);
			}
			
			$group_sql .= implode(', ', $segments);
		}

		$where_sql = "";
		if ( $node->wheres)
		{
			$expression = $this->visit($node->wheres);
			$where_sql = " WHERE {$expression}";
		}
		
		$having_sql = "";
		if ( $node->having )
		{
			$having_sql = $this->visit($node->having);
		}
		
		$order_sql = "";
		if ( $orders = $node->orders )
		{
			$order_sql .= " ORDER BY ";

			$segments = array();
			foreach($orders as $order)
			{
				$segments[] = $this->visit($order);
			}
			
			$order_sql .= implode(', ', $segments);
		}
		
		$limit_sql = "";
		if ( $limit = $node->limit )
		{
			$limit_sql = " LIMIT {$limit}";
		}
		
		return "SELECT{$projections_sql}{$from_sql}{$where_sql}{$group_sql}{$having_sql}{$order_sql}{$limit_sql}";
	}
	
	public function visitEquality(Bella_Node_Equality $node)
	{
		$left = $this->visit($node->left);
		$right = $this->visit($node->right);
		
		if ( $right )
		{
			return "{$left} = {$right}";
		}
		else
		{
			return "{$left} IS NULL";
		}
	}

	public function quote($name)
	{
		return "'{$name}'";
	}

	public function quoteColumnName($name)
	{
		return "\"{$name}\"";
	}
	
	public function quoteTableName($name)
	{
		return "\"{$name}\"";
	}
}