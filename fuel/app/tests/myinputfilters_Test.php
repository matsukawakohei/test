<?php

/**
* MyInputFilters class Test
*
* @group App
*/
class myinputfilter_Test extends TestCase
{
  public function test_check_encoding_SJIS文字列を検証すると例外が発生()
  {
    $this->setExpectedException(
      'HttpInvalidInputException', 'Invalid input data'
    );

    $input = mb_convert_encoding('SJISの文字列です', 'SJIS');
    $test = MyInputFilters::check_encoding($input);
  }

  public function test_check_encoding_正常な文字列は検証をパスしその文字列が返る()
  {
    $input = '正常なUTF-8の文字列です';
    $test = MyInputFilters::check_encoding($input);
    $expected = $input;

    $this->assertEquals($expected, $test);
  }

  /**
  * @dataProvider provider_改行コードを含む文字列
  */
  public function test_check_control_改行タブを含む文字列は検証をパス($data)
  {
    $input = $data;
    $test = MyInputFilters::check_control($input);
    $expected = $input;

    $this->assertequals($expected, $test);
  }

  public function provider_改行コードを含む文字列()
  {
    return [
      ["改行コードを含む\n文字列です"],
      ["改行を含む\r文字列です"],
      ["改行を含む\r\n文字列です"],
      ["タブを含む\t文字列です"],
      ["改行と\rタブを\n含む\t文字列です"],
    ];
  }

  /**
  * @dataProvider provider_制御文字を含む文字列
  */
  public function test_check_control_制御文字を含む文字列を検証すると例外が発生($data)
  {
    $this->setExpectedException('HttpInvalidInputException', 'Invalid input data');

    $input = $data;
    $test = MyInputFilters::check_control($input);
  }

  public function provider_制御文字を含む文字列()
  {
    return [
      ["Null文字を含む文字列です\0"],
      ["Null文字と改行コードを含む文字列です\0\n"],
    ];
  }
}
