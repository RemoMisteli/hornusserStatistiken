<?php
include_once("resource.php");

class webcodes extends resource {




	public function __construct($methode, $data) {


		parent::__construct($methode, $data);
	}



	public function getAll() {
		$result = dbUtils::sqlSelect("select * from Webcodes order by vereinsname");
		return dbUtils::formatMessage(200, $result);
	}

	public function insert() {

		$sql = "INSERT INTO `webcodes`(`webcode`, `vereinsname`) VALUES ('".str_replace("'","",$this->data->webcode)."','".str_replace("'","",$this->data->vereinsname)."')";
		dbUtils::sqlQuery($sql);
		return dbUtils::formatMessage(200, "Done");
	}



	public function update() {
	}

	public function delete() {
	}

	public function isDataValid() {


		if (is_null($this->data->vereinsname)) {
			return	dbUtils::formatMessage(420,"vereinsname");
		}


		if (is_null($this->data->webcode)) {
			return	dbUtils::formatMessage(420,"webcode");
		}

		return true;
	}
}
