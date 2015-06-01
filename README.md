# My Crude LDAP Class



## Installation


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

