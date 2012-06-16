<?php

class Bella_Tests_Node_MinimumTestCase extends Unit_TestCase
{
	public function test_alias_the_minimum()
	{
		$node = new Bella_Node_SqlLiteral('users.id');
		$minimum = $node->minimum()->is('foo');
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($minimum);
		
		$this->assertEquals('MINIMUM(users.id) AS foo', $result, 'should alias the minimum');		
	}
}
