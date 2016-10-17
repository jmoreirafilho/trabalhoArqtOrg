<?php 
namespace Inicio;

include 'Barramento.php';
include 'EntradaSaida.php';

use Barramento;
use EntradaSaida;

/**
* Início
*/
class Inicio
{
	// use Barramento;

	function __construct()
	{
		// $tamanho = $_POST['tamanho'];
		// $frequencia = $_POST['frequencia'];
		// $largura = $_POST['largura'];
		
		// setcookie("tamanho", $tamanho);
		// setcookie("frequencia", $frequencia);
		// setcookie("largura", $largura);

		new Barramento\Barramento;

		new EntradaSaida\EntradaSaida;

		\Barramento\Barramento::defineTamanho(5);
		// Barramento::sayHello();
		// new EntradaSaida();
		// new MemoriaRam();

		// echo Barramento::abertoParaES;
		// new CPU();
	}
}


new Inicio();

 ?>