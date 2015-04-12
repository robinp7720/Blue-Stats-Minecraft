<?php
class config{
	public $serverId = 1;
	public function set($option,$value){

		$stmt =  $mysqli->stmt_init();
		if ($stmt->prepare("")) {

		    /* bind parameters for markers */
		    $stmt->bind_param("ss", $_SESSION["uid"],$_SESSION["uid"]);

		    /* execute query */
		    $stmt->execute();

		    /* close statement */
		    $stmt->close();
		}



	}

	public function get($option){

	}
}