<?php

require __DIR__ . '/person.php';
use PHPUnit\Framework\TestCase;

class Person_Test extends TestCase
{
  public function test_男性の場合は性別を取得するとmaleである()
  {
    $person = new Person('Rintaro', 'male', '1991/12/14');

    $test = $person = $person->get_gender();
    $expected = 'male';

    $this->assertEquals($expected, $test);
  }
}