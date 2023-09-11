<?php

/**
* @Author: Dennis L.
* @Test: 1
* @TimeLimit: 5 minutes 
* @Testing: Reﬂection 
* @Task: Make $mySecret public using Reﬂection. 
**/

// Please write some code to output the secret. 
// You cannot adjust the visibility of the variable.


///////////////////
//// TEST 1

final class ReflectionTest  {
    private $mySecret = 'I have 99 problems. This isn\'t one of them.';
}

// instanciatig the class "ReflectionTest" for use later in the pro
$Rtest = new ReflectionTest;

// create a new reflection class which reports information about a given class
//  in  this case our final class "ReflectionTest" is used
$myReflectionClass = new ReflectionClass(get_class($Rtest));

// retrieve the private variable from  the reflection of our class "mySecret"
$secretProperty = $myReflectionClass->getProperty('mySecret');

// set the property of the variable we are concerned about to true
$secretProperty->setAccessible(true);

// Hello your secret. I'm pretty sure this might be a problem.
echo $secretProperty->getValue($Rtest);

///////////////////