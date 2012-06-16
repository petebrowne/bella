<?php

class Bella_Tests_Node_SumTestCase extends Unit_TestCase
{
	public function test_alias_the_sum()
	{
		$node = new Bella_Node_SqlLiteral('users.id');
		$sum = $node->sum()->is('foo');
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($sum);
		
		$this->assertEquals('SUM(users.id) AS foo', $result, 'should alias the sum');		
	}
}