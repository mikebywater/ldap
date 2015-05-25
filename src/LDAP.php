<?php


namespace mikebywater\LDAP;


class LDAP
{

    protected $ldapServer;
    protected $domain; //domain prefix for username
    protected $bound;


    public $conn;
    public $entry;


    protected $basedsn;


    protected $filter; //ldap query we will execute
    protected $attributes; // attributes returned from searches
    protected $attronly; //attronly flag
    protected $limit; // record limit returned

    protected $searchResult;

    protected $rdn;     // ldap rdn or dn
    protected $password;         // associated password

    protected $admin_user;
    protected $admin_password; // admin username and password for admin bind

    protected $bind;


    public function  __construct()
    {
        $this->ldapServer = $_ENV['LDAP_SERVER'];
        $this->domain = $_ENV['LDAP_DOMAIN'];
        $this->basedsn = $_ENV['LDAP_BASE_DSN'];

        $this->admin_user = $_ENV['LDAP_ADMIN_USER'];
        $this->admin_password = $_ENV['LDAP_ADMIN_PASSWORD'];

        $this->filter = "(&(objectCategory=Person)(sAMAccountName=*))";
        $this->attributes = array();
        $this->attronly = 0;
        $this->limit = 0;

        $this->searchResult = "";
        $this->bind = false;

        $this->conn = ldap_connect($this->ldapServer) or die("Could not connect to LDAP server.");

    }

    public function authenticate($user,$password){
        if($password)
        {
            $this->bind($user,$password);
            if($this->bind)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }


    public function bind($user='',$password='')
    {

        if (!$user)
        {
            $this->rdn = $this->admin_user;
            $password = $this->admin_password;
        }
        else
        {
            if ($this->domain)
            {
                $this->rdn  = "$this->domain\\$user";

            }
            else
            {
                $this->rdn = $user;
            }
        }
        if(!@ldap_bind($this->conn, $this->rdn, $password))
        {
            $this->bind = false;
        }
        else
        {
            $this->bind = true;
        }


        return $this;



    }


    public function search($dsn,$query,$filter="")
    {

        //$searchResult = ldap_search( $this->conn, "OU=APT Solutions,DC=aptsol,DC=com", "sAMAccountName=$this->user" );
        $searchResult = ldap_search( $this->conn, $dsn, $query);
        $this->entry = ldap_first_entry( $this->conn, $searchResult );
        return $this;
    }

    public function filter($value)
    {
        $this->filter = $value;
        return $this;
    }


    public function get()
    {
        //$searchResult = ldap_search( $this->conn, $this->basedsn, $this->filter,$this->attributes,$this->attronly,$this->limit);
        $this->searchResult = ldap_search( $this->conn, $this->basedsn, $this->filter);
        return $this;
    }

    public function first()
    {
        $this->entry = ldap_first_entry( $this->conn, $this->searchResult );
        return $this->entry;
    }

    public function next()
    {
        $this->entry = ldap_next_entry( $this->conn, $this->entry );
        return $this->entry;
    }


    public function all()
    {
        $this->entry = ldap_get_entries( $this->conn, $this->searchResult );
        return $this->entry;
    }


}
