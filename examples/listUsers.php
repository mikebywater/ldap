<?php
require_once('../.env');
require_once('../src/LDAP.php');
require_once('../src/LDAPUser.php');

use mikebywater\LDAP\LDAP as LDAP;
use mikebywater\LDAP\LDAPUser as LDAPUser;

//We are going to use the default filter so of (&(objectCategory=Person)(sAMAccountName=*) so we can ommit the filter method
// Add a filter method after the bind


$ldap = new LDAP();
$entry = $ldap->bind()->get()->first();

// we get the first entry then loop through

do{

    $user = new LDAPUser($ldap->conn, $entry);
    $name = $user->getName();
    $email = $user->getEmail();

    echo "<h3> $name </h3>";
    echo "<p> $email </p><hr/>";

}while($entry = $ldap->get()->next());

//while you are still getting an entry returned the loop will continue
// as soon as $ldap->get()->next() does not return an entry the loop will end
