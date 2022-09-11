<?php

if (!function_exists('str_ends_with')) {
  function str_ends_with($str, $end)
  {
    return (@substr_compare($str, $end, -strlen($end)) == 0);
  }
}

$keys_HDU0 = array("METHOD", "MODE", "FILENAME", "TRIGTIME", "TRIGUTC");
$keys_exclude = array("TRIG_DETS", "SIGNIFICANCE");

function name_base($filename){
  return explode('.',$filename)[0];
}


function preparePostfix($obj)
{

  global $keys_HDU0, $keys_exclude;

  $all = array();

  $HDU0 = $obj->HDU0;
  $HDU1 = $obj->HDU1;
  $HDU3 = $obj->HDU3;


  foreach ($keys_HDU0 as $key) {
    if ($key == "FILENAME") {
      array_push($all, "\"" . explode(".", $HDU0->$key)[0] . "\"");
    } else if ($key != "TRIGTIME") {
      array_push($all, "\"" . $HDU0->$key . "\"");
    } else {
      array_push($all, $HDU0->$key);
    }
  }

  $keys_HDU1 = array_keys((array)$HDU1);
  foreach ($keys_HDU1 as $key) {

    if (!in_array($key, $keys_exclude)) {
      array_push($all,  $HDU1->$key);
    }
  }

  foreach (array_keys((array)$HDU3) as $key) {
    array_push($all, $HDU3->$key);
  }

  if (in_array($keys_exclude[0], $keys_HDU1)) {
    //TRIG_DETS

    foreach (range(0, 11) as $i) {
      array_push($all, "NULL");
    }

    foreach ($HDU1->TRIG_DETS as $sig) {
      array_push($all, $sig);
    }
  } elseif (in_array($keys_exclude[1], $keys_HDU1)) {
    //SIGNIFICANCE

    foreach ($HDU1->SIGNIFICANCE as $sig) {
      array_push($all, $sig);
    }

    foreach (range(0, 11) as $i) {
      array_push($all, "NULL");
    }
  }


  return implode(',', $all);

  //   echo count($all) . " " .  (implode(', ',$all)) . "\n";

}
