<?php

///////////////////
//// TEST2
/**
* @Author: Dennis L.
* @Test: 2 
* @TimeLimit: 10 minutes 
* @Tes;ng: Closures 
*/

var_dump(changeDateFormat(
    array(
        "2010/03/30", // a
        "15/12/2016", // a
        "11-15-2012", // c
        "11.15.2012", // c // i added this one
        "20130720")   // d // couldn't think of a clean way to solve this one
    )
);

/** 
 * When this method runs, 
 * it should return valid dates in the following 
 * format: DD/MM/YYYY.

*/ 
function changeDateFormat(array $dates): array {

    $listOfDates = [];

    //$closure = [];// closure should  be a callback function when using array map

    // Add code here 

    $format = ''; // possible addition of formating the date?
    $closure = function($date) use (&$listOfDates, $format,$dates){
        $deelims = ["-", "/", "."];  // input delimiters

        //echo 'de lims<br>';


            //echo $date.'<br>';

        $testDeelim = findFirstDelimiter($date, $deelims);
        //echo $testDeelim['delimiter']. '<br>';
        if($testDeelim !== false){
            $dateArry = explode($testDeelim['delimiter'], $date);
        }

        $datestring = $date;//  return the date as it was if not possible via this code

        // it sees excessive to use a switch statement but this way meant 
        //  i could easily separate what happens to each delimiter
        //  i can also handle no delimiters and it is easy to read and change

        switch($testDeelim['delimiter']){
            case '/':
                //echo 'a';
                $datestring = returnDate($dateArry, $format);
                //echo $datestring.'<br>';
                array_push($listOfDates, $datestring);
                
                break;
            case ' ':
                //echo 'b';
                $datestring = returnDate($dateArry, $format);
                //echo $datestring.'<br>';
                array_push($listOfDates, $datestring);
                break;
            case '-':
                //echo 'c';
                $datestring = returnDate($dateArry, $format);
                //echo $datestring.'<br>';
                array_push($listOfDates, $datestring);
                break;
            case '.':
                //echo 'd';
                $datestring = returnDate($dateArry, $format);
                //echo $datestring.'<br>';
                array_push($listOfDates, $datestring);
                break;
            default:
                //echo 'z';
                //$datestring = returnDate($dateArry, $format);
                //echo $datestring.'<br>';
                // couldn't work out what to do for no delimiters :(
                array_push($listOfDates, $datestring);
                break;
        }


    
    };

    // Don't edit anything else!
    
    array_map($closure, $dates);

    return $listOfDates;

}

function returnDate($array,  $format){
    $datestring = '';
    if(isYearFirst($array)){
        if(isDay($array[2]) &&  isMonth($array[1])){
            $datestring = $array[2].'/'.$array[1].'/'.$array[0];
        }else{
            $datestring = $array[2].'/'.$array[0].'/'.$array[1];
        }
    } else {
        if(isDay($array[0]) &&  isMonth($array[1])){
            $datestring = $array[0].'/'.$array[1].'/'.$array[2];
        }else{
            $datestring = $array[1].'/'.$array[0].'/'.$array[2];
        }
    }

    return $datestring;
}

function isYearFirst($dateArray){
    $yearFirst =  (strlen($dateArray[0]) == 4 ) ? true : false;
    return $yearFirst;
}

function isMonth($value){
    $min = 0;
    $max = 12;
    if(($min <= $value) && ($value <= $max)){
        return true;
    }
    return false;
}

function isDay($value){
    $min =  0;
    $max  = 31;

    if(($min <= $value) && ($value <= $max)){
        return true;
    }
    return false;
}


/**
 * Find the first instance of an array of delimiters in a date string.
 *
 * @param string $date The date string to search for delimiters.
 * @param array $delimiters An array of delimiters to search for in the date string.
 * @return array Returns an associative array. If successful, ['delimiter' => firstDelimiter], otherwise ['error' => errorMessage].
 */
function findFirstDelimiter($date, $delimiters) {
    
    if (!is_array($delimiters) || empty($delimiters)) {
        return ['error' => "Invalid input. Delimiters should be a non-empty array."];
    }
    
    // Find the first instance of a delimiter in the date string
    foreach ($delimiters as $delimiter) {
        $position = strpos($date, $delimiter);
        
        if ($position !== false) {
            return ['delimiter' => $delimiter];
        } 
    }
    
    return false;
}

/////