<?php

class Bella_Tests_Node_CountTestCase extends Unit_TestCase
{
	public function test_literal_alias_count()
	{
		$node = new Bella_Node_SqlLiteral('users.id');
		$count = $node->count(FALSE)->is('foo');
		
		$visitor = new Bella_Visitor_ToSql();
		$result = $visitor->accept($count);
		
		$this->assertEquals('COUNT(users.id) AS foo', $result, 'should alias the count');
	}
}