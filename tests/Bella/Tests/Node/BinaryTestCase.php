<?php

class Bella_Tests_Node_BinaryTestCase extends Unit_TestCase
{
	public function test_less_than()
	{
		$node = new Bella_Node_SqlLiteral('id');
		$lt = $node->lt(5);
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($lt);
		
		$this->assertEquals('id < 5', $result, 'should be less than left');		
	}
	
	public function test_less_than_or_equal()
	{
		$node = new Bella_Node_SqlLiteral('id');
		$lteq = $node->lteq(5);
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($lteq);
		
		$this->assertEquals('id <= 5', $result, 'should be less than or equal to left');		
	}
	
	public function test_greater_than()
	{
		$node = new Bella_Node_SqlLiteral('id');
		$gt = $node->gt(5);
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($gt);
		
		$this->assertEquals('id > 5', $result, 'should be greater than left');		
	}
	
	public function test_greater_than_or_equal()
	{
		$node = new Bella_Node_SqlLiteral('id');
		$gteq = $node->gteq(5);
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($gteq);
		
		$this->assertEquals('id >= 5', $result, 'should be greater than or equal to left');		
	}
}