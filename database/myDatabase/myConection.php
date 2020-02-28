<?php  

/**
 * 
 */
class myConection
{
	
	public static function dbConection()
	{
		$SERVER_NAME = "database-1.cqjkn9audmnv.us-east-1.rds.amazonaws.com";
		$USERNAME = "admin";
		$PASSWORD = "Aquafina80";

		//create conetion 
		$connection = new mysqli($SERVER_NAME,$USERNAME,$PASSWORD);

		// check connection 
		if (!$connection) {
			die("Connection failed: " .mysqli_error());

		}
	}
}