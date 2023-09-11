<?php


/**
* @Author: Dennis L.
* @Test: 4 
* @TimeLimit: 30 minutes 
* @Tes;ng: Input Sanita;on 
*/

// Fix this so there are no SQL Injec;on asacks, 
//  no chance for a man-in-the-middle asack 
//  (e.g., use something to determine if the input was changed), 
//  and limit the chances of 
// brute-forcing this creden;al system to gain entry. 
//  Feel free to change any part of this code.

//SQL injection
// believe it or not, this is actually ok
$username = @$_GET['username'] ? $_GET['username'] : '';
$password = @$_GET['password'] ? $_GET['password'] : '';

// using md5() without a salt is just asking for brute force attacks
$password = salter($password);


// TODO - move to database  instansiation 
// start PDO object - good
$pdo = new PDO('sqlite::memory:');
// set atts for the connection = ok
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// END TODO


//  this should be separate from the code that checks if a user exists
//  otherwise you will recreate the user table each time this runs
$pdo->exec("DROP TABLE IF EXISTS users"); 
$pdo->exec("CREATE TABLE users (username VARCHAR(255), password VARCHAR(255))");

// set a not very secure root password
//$rootPassword = md5("secret");

// this is better
$rootPassword = salter("secret"); 

// garbage code?:
$pdo->exec("INSERT INTO users (username, password) VALUES ('root', '$rootPassword');"); 

//the above seems like garbage code
// why create a new table just for admin each time?
// surely the admin user 'root' was defined prior?!


// right, now we doing something interesting
//  still doing it in a fucked up way.

// direct queries is wrong - lets prepare the query statement instead.
//$statement = $pdo->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'"); 

$statement = $pdo->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
$statement->execute(['username' => $username, 'password' => $password]);

// being honest here not sure about 'man in the middle' attacks - nor where to start.

if (count($statement->fetchAll())) {
    echo "Access granted to $username!<br>\n"; 
} else {
    echo "Access denied for $username!<br>\n"; 
}



define('APP_SALT', 'test_salt');

function salter($value){
    // the salt string is predefined, 
    //  for added security and complexity time(), 
    //  can be used as well.
    //  for this test a simple string will 
    //   suffice to add complexity to the resulting hash
    //   - exponentcailly increasing the length of time needed to crack the md5 string
    //      a dictonary list of words and corresponding hashes
    //      with the salt added the attacker would need a list like this:
    //      secret1694446690test_salt : 09a5cb7bab0aa4c7db36985ca4a78fda
    //      rather than a list like this
    //      secret                    : 5ebe2294ecd0e0f08eab7690d2a6ee69
    // using time() means that an aspect of the salt changes based on when the user signed up
    //  this means that each new user should have a unique salt 
    //  added to generate the hash when they create or update their password.
    // a collision attack will break this -  don't rely on hashing functions for passwords!
    //  in a collision attack i don't care what you password is, i just need to find a hash that matches
    //   rainbow tables can be used, where a chain of hashes is used to find another string that has the same hash as the password
    //  this attack is much faster than brute force and much harder to prevent
    return  md5($value . APP_SALT);

    // better return statement
    //return  md5($value . microtime(). APP_SALT);
}

// psudo code to test a users password using microtime - ignore it it's WIP:
function saltTest($valuex, $valuey, $createdAt){
    $microTime = strtotime($createdAt);
    if(md5($valuex . $microTime . APP_SALT) == $valuey){
        return true;
    }
    return false;
}
