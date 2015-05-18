<?php
class mysqlMan{
	private $mysqliConnects = array();

	 public function connect($id,$username,$password,$host,$dbName){
	 	 $this->mysqliConnects[$id] = new mysqli(
			$host,
			$username,
			$password,
			$dbName
		);
	 }
	public function get($id){
		return $this->mysqliConnects[$id];
	}
}