<?php

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Unit', __DIR__);
$loader->add('Bella_Tests', __DIR__);
$loader->register();

$suite = new Unit_TestSuite;
$suite->addTestCase('Bella_Tests_Node_SqlLiteralTestCase');
$suite->addTestCase('Bella_Tests_Node_CountTestCase');
$suite->addTestCase('Bella_Tests_Node_SumTestCase');
$suite->addTestCase('Bella_Tests_Node_MaximumTestCase');
$suite->addTestCase('Bella_Tests_Node_MinimumTestCase');
$suite->addTestCase('Bella_Tests_Node_AverageTestCase');
$suite->addTestCase('Bella_Tests_Node_BinaryTestCase');
$suite->addTestCase('Bella_Tests_TableTestCase');
$suite->run();