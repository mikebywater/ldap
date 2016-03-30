# My Crude LDAP Class



## Installation

### Composer

To install simply put the following in your composer json file

```
"require": {
  		"mikebywater/ldap": "dev-master"
},
```

next simply run
```
composer update
```


## Parameters

ldap relies on global variables being set. 

### Laravel


In Laravel simply set the variables below in the .env file

```php
LDAP_SERVER =server.example.com
LDAP_DOMAIN=mydomain
LDAP_BASE_DSN=dc=example,dc=com
LDAP_ADMIN_USER=admin
LDAP_ADMIN_PASSWORD=password
```

## Usage

### Authenticating a user

```php
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
```
### Searching LDAP

```php
use mikebywater\LDAP\LDAP as LDAP;
// Instantiate object
$ldap = new LDAP();
$username = "george.land";
// Method chaining allows us to bind to ldap, apply an ldap filter and get the first result
$entry = $ldap->bind()->filter("sAMAccountName=$username")->get()->first();
```
### Extracting user Details from an entry

By using the LDAPUser class we can get user details from an entry

```php
use mikebywater\LDAP\LDAPUser as LDAPUser;
// Instantiating the object requires you to pass your ldap connection and the entry
// from the previous example
$user = new LDAPUser($ldap->conn, $entry);
$name =  $user->getName(); //special function for display name
$email = $user->getEmail(); //special function foe mail attributes
$company= $user->__get('company')[0]; // any other attribute can be grabbed with magic get method (beware will return an array)
$description= $user->__get('description')[0];
```
