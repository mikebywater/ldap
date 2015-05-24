<?php

require_once('../.env');
require_once('../src/LDAP.php');
require_once('../src/LDAPUser.php');

use mikebywater\LDAP\LDAP as LDAP;


$ldap = new LDAP();

$username = 'testmember';
$password = 'test123';


if($ldap->authenticate($username,$password))
{
 echo "Authenticated";
}
else
{
    echo "Invalid Credentials";
}
