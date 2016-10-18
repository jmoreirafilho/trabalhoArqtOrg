<?php 

include('Barramento.php');

class Componente
{
	
	public static $teste = "opaaaa"; 
	public static $barramento;

	function __construct()
	{
		Componente::$barramento = new Barramento;
	}
}

 ?>