<?php

class Bella_TreeManager
{
	protected $ast, $visitor;

	public function __construct()
	{
		$this->visitor = new Bella_Visitor_ToSql();
	}

	public function to_sql()
	{
		return $this->visitor->accept($this->ast);		
	}
}