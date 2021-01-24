<?php

class MyInputFilters
{
  public static function check_encoding($value)
  {
    if (is_array($value)) {
      array_map(['MyInputFilters', 'check_encoding'], $value);

      return $value;
    }

    if (mb_check_encoding($value, Fuel::$encoding)) {
      return $value;
    } else {
      static::log_error('Invalid character encoding', $value);

      throw new HttpInvalidInputException('Invalid input data');
    }
  }

  public static function check_control($value)
  {
    if (is_array($value)) {
      array_map(['MyInputFilters', 'check_control'], $value);
      return $value;
    }

    if (preg_match('/\A[\r\n\t[:^cntrl:]]*\z/u', $value) === 1) {
      return $value;
    } else {
      static::log_error('Invalid control characters', $value);

      throw new HttpInvalidInputException('Invalid input data');
    }
  }

  public static function log_error($msg, $value)
  {
    Log::error(
      $msg .': ' .Input::uri() .' ' .rawurlencode($value) .' ' .Input::ip() .'"' .Input::user_agent() .'"'
    );

  }
}
