<?php

class Bella_Tests_Node_MaximumTestCase extends Unit_TestCase
{
	public function test_alias_the_sum()
	{
		$node = new Bella_Node_SqlLiteral('users.id');
		$maximum = $node->maximum()->is('foo');
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($maximum);
		
		$this->assertEquals('MAXIMUM(users.id) AS foo', $result, 'should alias the maximum');		
	}
}