<?php

abstract class MYSQL_ERROR
{

    const TABLE_EXISTS = 1050;
}



abstract class CREDS
{

    const SERVERNAME = "10.1.1.247";
    const USERNAME = "magnetars";
    const PASSWORD = "km787vs";
    const DATABASE = 'magnetars';
}

$columns = array(
    'trigtime',
    'trigutc',
    'duration',
    'hr_25',
    'hr_50',
    'hr_75',
    'event_grade',
    'saa',
    'sgr',
    'sgrb',
    'lgrb',
    'sflare',
    'tgf',
    'transnt',
    'distpar',
    'loclpar',
    'no_evaluation',
    'sig_min',
    'sig_max'
);
