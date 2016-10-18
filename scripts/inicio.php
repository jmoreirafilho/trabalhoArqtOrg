<?php 

include 'Componente.php';
include 'EntradaSaida.php';
include 'MemoriaRam.php';

/**
* Início
*/
class Inicio
{

	function __construct()
	{
		$tamanho = $_POST['tamanho'];
		$largura = $_POST['largura'];
		$frequencia = $_POST['frequencia'];

		new Componente();

		Componente::$barramento->defineTamanho($tamanho);
		Componente::$barramento->defineLargura($largura);
		Componente::$barramento->defineTamanho($frequencia);

		new EntradaSaida();
		new MemoriaRam();
	}
}


new Inicio();

 ?>