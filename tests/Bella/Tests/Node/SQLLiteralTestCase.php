<?php

class Bella_Tests_Node_SqlLiteralTestCase extends Unit_TestCase
{
	public function test_literal()
	{
		$literal = new Bella_Node_SqlLiteral('test');
		
		$this->assertTrue($literal, 'Node should exist');
	}
	
	public function test_literal_count()
	{
		$node = new Bella_Node_SqlLiteral('*');
		$count = $node->count();
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($count);
		
		$this->assertEquals('COUNT(*)', $result, 'Count Node');
	}
	
	public function test_literal_distinct_count()
	{
		$node = new Bella_Node_SqlLiteral('first');
		$count = $node->count(TRUE);
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($count);
		
		$this->assertEquals('COUNT(DISTINCT first)', $result, 'Distinct Count Node');
	}
	
	public function test_equality_count()
	{
		$node = new Bella_Node_SqlLiteral('foo');
		$node = $node->eq(1);
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($node);
		
		$this->assertEquals('foo = 1', $result, 'Node Equal should work');
	}
	
	public function test_null_equality_count()
	{
		$node = new Bella_Node_SqlLiteral('foo');
		$number = new Bella_Node_SqlLiteral(NULL);
		$node = $node->eq($number);
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($node);
		
		$this->assertEquals('foo IS NULL', $result, 'Node Equal should work');
	}
	
	public function test_grouped_or_equality()
	{	
		$node = new Bella_Node_SqlLiteral('foo');

		$node = $node->eq_any(array(1, 2));
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($node);
		
		$this->assertEquals('(foo = 1 OR foo = 2)', $result, 'Node Equal and or should work');
	}
	
	public function test_grouped_and_equality()
	{	
		$node = new Bella_Node_SqlLiteral('foo');
		
		$node = $node->eq_all(array(1, 2));
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($node);
		
		$this->assertEquals('(foo = 1 AND foo = 2)', $result, 'Node Equal and or should work');
	}
}