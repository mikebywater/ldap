<?php
require_once('../.env');
require_once('../src/LDAP.php');
require_once('../src/LDAPUser.php');

use mikebywater\LDAP\LDAP as LDAP;
// include user object so we can use on the result
use mikebywater\LDAP\LDAPUser as LDAPUser;


// Instantiate object
$ldap = new LDAP();

$username = "george.land";

// Method chaining allows us to bind to ldap, apply an ldap filter and get the first result
$entry = $ldap->bind()->filter("sAMAccountName=$username")->get()->first();



//Instantiate the user object (requires us to pass a connection and person entry to the object)

$user = new LDAPUser($ldap->conn, $entry);

$name =  $user->getName(); //special function for display name
$email = $user->getEmail(); //special function foe mail attributes
$company= $user->__get('company')[0]; // any other attribute can be grabbed with magic get method (beware will return an array)
$description= $user->__get('description')[0];

echo "Name :  $name <br/>";
echo "Email Address :  $email <br/>";
echo "Description :  $description <br/>";
echo "Company :  $company <br/>";
echo "Groups :";
echo "<ul>";
foreach($user->getGroups() as $group)
{
    echo "<li> $group </li>";
};
echo "</ul>";
