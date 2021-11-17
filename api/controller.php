<?php

include_once("webcodes.php");
include_once("resource.php");

class controll{

	public static function controller($resources,$method,$data){

		switch ($resources){
			case "webcodes":
				$webcodes=new webcodes($method,$data);
				return	$webcodes->handle();
				break;

			
		}

	}
}

?>