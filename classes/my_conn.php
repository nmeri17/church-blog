<?php

class My_conn extends PDO {
	/* @PDO connection class.
	* @Author: Al Nmeri
	* @param: PDO connection vars
	* @returns: null
	**/

	private $host;
	private $username;
	private $pass;
	private $options;

	public function __construct($host, $username, $pass, $options=NULL) {
			$this->host = $host;
			$this->username =$username;
			$this->pass = $pass;
			$this->options = $options;
	}

	private function connect ()	{
		return new PDO ($this->host, $this->username, $this->pass, $this->options);
	}

	/* @param: null.
	* @returns: returns a valid PDO connection
	**/
	public function gc (){
		// ideally, there should be a condition met before we allow access to this connection
		$test = $this->connect();
		$test->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $test;
	}
}

?>