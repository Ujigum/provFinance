<?php
/**

* @Author: Dennis L.
* @Test: 3 
* @TimeLimit: 15 minutes 
* @Testing: Recursion 
*/


function numberOfItems(array $arr, string $needle): int { // Write some code to tell me how many of my selected fruit is in these lovely nested arrays.

    // flatten the array
    $flatArray = flattenArray($arr);

    // simply count the number of time the needle occurs in the now flattened array
    $count = 0;
    foreach($flatArray as $elem){
        if($elem == $needle){
            $count++;
        }
    }
    return $count;
}

$arr = ['apple', ['banana', 'strawberry', 'apple', ['banana', 'strawberry', 'apple']]];

echo numberOfItems($arr, 'apple') . PHP_EOL;// 3!  :)

// recursively remove the complexity of the array containing nested arrays
//  so  that each element of the array is on the same level
function flattenArray($array){
    static $res=[];
    foreach($array as $val){
        if(is_array($val)){
            flattenArray($val);
        }else{
            $res[]=$val;
        }
    }
    return $res;
}
