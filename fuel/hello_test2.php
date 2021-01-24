<?php

require __DIR__ . '/hello.php';

function assertTrue($condition)
{
  if (!$condition) {
    throw new Exception('Assertion failed.');
  }
}

$test = hello();
$expected = 'Hello World';
assertTrue($test == $expected);