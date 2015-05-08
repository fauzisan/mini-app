<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 08.05.15
 * Time: 12:50
 */

const URL_JADWAL_SHALAT = 'BerlinMitte.txt';

function getDataThisMonth(){
    $currMonth = date('F');
    $nextMonth = date('F', strtotime('+1 month'));
    $days = ["So.", "Mo.", "Di.", "Mi.", "Do.", "Fr.", "Sa."];

    $db = explode(" ",file_get_contents(URL_JADWAL_SHALAT));
    $record = false;
    $recordTime = [];
    $data = $currIndex = "";
    $index = $index2 = 0;

    foreach($db as $tmp){
        if(strpos($tmp, $currMonth) !== false){
            $record = true;
        } else if(strpos($tmp, $nextMonth) !== false){
            $data[$index][$currIndex] = $recordTime;
            break;
        }

        if($record){
            if(in_array($tmp, $days)){
                if($currIndex != ""){
                    $data[$index][$currIndex] = $recordTime;
                    $index2 = 0; $recordTime = [];
                    $index++;
                }
                $currIndex = $tmp;
            } else if(strlen($tmp) == 5 && !ctype_alpha($tmp)) {
                $recordTime[$index2] = $tmp;
                $index2++;
            }
        }
    }

    return json_encode($data);
}

function getDataThisDay(){
    $today = date("j") - 1;
    $dataThisMonth = json_decode(getDataThisMonth(), true);

    return json_encode($dataThisMonth[$today]);
}

$value = "";
if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "month":
            $value = getDataThisMonth();
            break;
        case "day":
            $value = getDataThisDay();
            break;
    }
}

exit($value);