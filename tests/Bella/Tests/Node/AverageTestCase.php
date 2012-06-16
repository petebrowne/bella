<?php

class Bella_Tests_Node_AverageTestCase extends Unit_TestCase
{
	public function test_alias_the_average()
	{
		$node = new Bella_Node_SqlLiteral('users.id');
		$average = $node->average()->is('foo');
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($average);
		
		$this->assertEquals('AVERAGE(users.id) AS foo', $result, 'should alias the average');		
	}
}