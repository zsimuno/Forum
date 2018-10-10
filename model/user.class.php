<?php

class User
{
	protected $id, $username, $password, $reg_string, $reg ;

	function __construct( $id, $username, $password, $reg_string, $reg )
	{
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->reg_string = $reg_string;
		$this->reg = $reg;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
