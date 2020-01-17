<?php

namespace App\Helpers;

use Illuminate\Support\Str;


class Helper {

  public static function generateUniqueCode($len, $modelName, $modelColumn) {
    $unique = false;
    $code = "";

    $tested = [];

    $modelName = 'App'.'\\'.$modelName;
    $class = new $modelName();
    do{
        $random = Str::random($len);
        $random = Str::lower($random);
        if( in_array($random, $tested) ){
            continue;
        }
        $count = $class::where($modelColumn, $random)->count();
        $tested[] = $random;
        if( $count == 0){
            $unique = true;
            $code = $random;
        }
    }
    while(!$unique);

    return $code;
  }

  public static function isCurrency($number){
      return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
  }
}
