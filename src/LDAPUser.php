<?php

namespace mikebywater\LDAP;

class LDAPUser


{
    public $user; // This is a bound ldap connection
    protected $attributes;
    protected $conn;

    public function __construct($conn, $entry)

    {

        $this->conn = $conn;
        $this->user = $entry;


    }

    public function __get($key)
    {

        if(!$this->attributes)
        {
            $this->attributes = $this->getAttributes();
        }

        if (isset($this->attributes[$key]))
        {
            return  $this->attributes[$key];
        }
        else
        {
            return array("");
        }

    }



    public function getName()
    {
        return $this::__get('displayName')[0];
    }

    public function getEmail()
    {

        return $this::__get('mail')[0];

    }

    public function getGroups()
    {
        $groups = array();
        $raw_groups =  $this::__get('memberOf');
        foreach ($raw_groups as $group)
        {
            $str = explode("," , $group )[0];
            if (substr($str,0,2) == "CN" )
            {
                $groups[] = substr($str,3);
            }
        }
        return $groups;
    }




    private function getAttributes()
    {

        $this->attributes = ldap_get_attributes( $this->conn, $this->user );
        return $this->attributes;
    }



}
