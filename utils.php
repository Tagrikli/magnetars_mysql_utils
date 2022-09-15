<?php

namespace Utils;

if (!function_exists('str_ends_with')) {
  function str_ends_with($str, $end)
  {
    return (@substr_compare($str, $end, -strlen($end)) == 0);
  }
}

$keys_HDU0 = array("METHOD", "MODE", "FILENAME", "TRIGTIME", "TRIGUTC");
$keys_HDU1 = array("HR_25", "HR_50", "HR_75");
$keys_HDU1_exclude = array("TRIG_DETS", "SIGNIFICANCE");



function basename($filename)
{
  return pathinfo($filename, PATHINFO_FILENAME);
}

function quoted($text)
{
  return "\"" . $text . "\"";
}


function preparePostfix($obj)
{

  global $keys_HDU0, $keys_HDU1, $keys_HDU3, $keys_exclude;


  $HDU0 = $obj->HDU0;
  $HDU1 = $obj->HDU1;
  $HDU3 = $obj->HDU3;

  $all = array(
    //HDU0 Data
    quoted($HDU0->METHOD),
    quoted($HDU0->MODE),
    quoted(basename($HDU0->FILENAME)),
    $HDU0->TRIGTIME,
    quoted($HDU0->TRIGUTC),
    //HDU1 Data (except significance, they are at the end)
    $HDU1->DURATION,
    $HDU1->HR_25,
    $HDU1->HR_50,
    $HDU1->HR_75,
    $HDU1->EVENT_GRADE,
  );

  foreach (array_keys((array)$HDU3) as $key) {
    array_push($all, $HDU3->$key);
  }

  $sig_min = "NULL";
  $sig_max = "NULL";

  if (in_array("SIGNIFICANCE", array_keys((array)$HDU1))) {
    $sig_max = max($HDU1->SIGNIFICANCE);
    $sig_min = min($HDU1->SIGNIFICANCE);
  }

  array_push($all, $sig_min, $sig_max);


  return implode(',', $all);

  //   echo count($all) . " " .  (implode(', ',$all)) . "\n";

}
