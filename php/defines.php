<?php

DEFINE('EMAIL', 1);
DEFINE('PHONE', 2);
DEFINE('TEXT', 3);
DEFINE('NAME', 4);
DEFINE('NUMBER', 5);
DEFINE('SEM', 6);
DEFINE('TIME', 7);

function connectTo()
{
    /*
     Does -> Connects to data base
     Returns -> Connection object
    */
    $dir = 'sqlite:C:xampp\htdocs\FYP\fyp.db';
    $con = new PDO($dir) or die("cannot open the database");
    return $con;

}

function respond($as, $what)
{
    /*
     Takes -> key and value
     Does -> Dies by printing json_encoded array having the key and value
    */
    die(json_encode(array($as => $what)));
}

function verify($type, $input)
{
    /*
     Takes -> Type of regex checker and the input
     Does -> Computes the regex
     Returns -> Returns true and false
    */
    $reEmail = '/^([\S]+)@([\S]+)\.([\S]+)$/';
    $rePhone = '/^[0-9]{8,10}$/';
    $reText = "/^[A-Za-z]+((\s)?(([A-Za-z])+))*$/";
    $reName = "/^[A-Za-z]+((\s)?((\'|\-|\.)?([A-Za-z])+))*$/";
    $reNum = '/^[0-9]+$/';
    $reSem = '/^Y[1-4]-S(1|2)$/';
    $reTime = '/^(1[0-2]|0?[1-9]):[0-5][0-9]\s(AM|PM)$/';

    switch ($type) {
        case EMAIL :
            preg_match($reEmail, $input, $m);
            break;
        case PHONE :
            preg_match($rePhone, $input, $m);
            break;
        case TEXT :
            preg_match($reText, $input, $m);
            break;
        case NAME :
            preg_match($reName, $input, $m);
            break;
        case NUMBER :
            preg_match($reNum, $input, $m);
            break;
        case SEM :
            preg_match($reSem, $input, $m);
            break;
        case TIME :
            preg_match($reTime, $input, $m);
            break;
    }
    return count($m) == 0 ? false : true;
}

?>
