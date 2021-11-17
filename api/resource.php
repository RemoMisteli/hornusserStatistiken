<?php

include_once("dbUtils.php");
include_once("comonValidatePattern.php");
include_once("authenticationGeneral.php");


abstract class resource extends dbUtils {

	protected $methode;
	protected $data;


	public function __construct($methode,$data) {
		$this->methode=$methode;
		$this->data=$data;
	

	}

	public function handle(){

			switch ($this->methode){
				case 'GET':
						return $this->getAll();
				case 'POST':
					$isValid=$this->isDataValid();
				if ($isValid===true) {
						return $this->insert();
				}else{
						return $isValid;
					}
				case 'PUT':
					$isValid=$this->isDataValid();
					if ($isValid===true) {
						return $this->update();
					}else{
						return $isValid;
					}
				case 'DELETE':
					return $this->delete($this->delete());
				case 'OPTIONS':
					return dbUtils::formatMessage(200);
				default:
					return dbUtils::formatMessage(404);
			}
		

		}
			abstract function isDataValid();



}
?>