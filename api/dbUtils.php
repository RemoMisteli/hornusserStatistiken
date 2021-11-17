<?php
include_once("config.php");
class dbUtils{

static function formatMessage($status=200, $data=null) {
		$message = array();
		$message['status'] = $status;
		$message['data'] = $data;
		return $message;
	}

	static function connectDB() {
		global $dbhandle;
		$dbhandle = mysqli_connect(config::HOST, config::DBUSER, config::DBPASSWORD, config::DB);
		if ( !$dbhandle ) {
			throw new Exception( mysqli_connect_error() );
		}
	}

static function sqlSelect($sql) {
		global $dbhandle;
		$result = mysqli_query($dbhandle, $sql);
		if ( !$result ) die("Fehler: ".mysqli_error($dbhandle));
		$data = array();
		while ( $row=mysqli_fetch_assoc($result) ) $data[]=$row;
		return $data;
	}

static function sqlQuery($sql) {
		global $dbhandle;
		$result = mysqli_query($dbhandle, $sql);
		if ( !$result ) die(mysqli_error($dbhandle)."<pre>".$sql."</pre>");
	}


}

?>