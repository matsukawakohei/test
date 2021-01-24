<?php

/**
* @group App
*/
class myvalidationrules_Test extends TestCase
{
  public function test_validation_no_tab_and_newline_検証パス()
  {
    $input = 'タブも改行も含まない文字列です';
    $test = MyValidationRules::_validation_no_tab_and_newline($input);
    $expected = true;

    $this->assertEquals($expected, $test);
  }

  /**
  * @dataProvider provider_不正な文字列
  */
  public function test_validation_no_tab_and_newline_検証エラー($input)
  {
    $test = MyValidationRules::_validation_no_tab_and_newline($input);
    $expected = false;

    $this->assertEquals($expected, $test);
  }

  public function provider_不正な文字列()
  {
    return [
      ["改行を含む\n文字列です"],
      ["改行を含む\r文字列です"],
      ["改行を含む\r\n文字列です"],
      ["タブを含む\t文字列です"],
      ["改行と\rとタブを含む\t文字列\nです"],
    ];
  }

}
