<?php

class tictac
{
	public $ganador;
	protected $dado;
	private $win_horizontal_1 = [1, 2, 3];
	private $win_horizontal_2 = [4, 5, 6];
	private $win_horizontal_3 = [7, 8, 9];
	private $win_vertical_1 = [1, 4, 7];
	private $win_vertical_2 = [2, 5, 8];
	private $win_vertical_3 = [3, 6, 9];
	private $win_diagonal_1 = [1, 5, 9];
	private $win_diagonal_2 = [3, 5, 7];

	public function __construct()
	{
		$this->marcados = array();

		if (empty($_SESSION['jugador'])) {
			$_SESSION['jugador'] = 'X';
		}
	}

	public function cambio_jugador()
	{
		if($_SESSION['jugador'] == 'o'){
			$_SESSION['jugador'] = 'X';
		} else {
			$_SESSION['jugador'] = 'o';
		}
	}

	public function pasar_turno()
	{
		if (!isset($_SESSION['turno'])) {
			$_SESSION['turno'] = 0;
		} elseif (isset($_GET['casilla'])) {
			$_SESSION['turno'] += 1;
		}
	}

	public function set_ganador($ganador)
	{
		$this->ganador = $ganador;
	}

	public function verificar_ganador()
	{
		if(isset($_SESSION['marcados'])){
			$marc = $_SESSION['marcados'];

			if ( (isset($marc[1]) && isset($marc[2]) && isset($marc[3])) && ($marc[1] == $marc[2] && $marc[1] == $marc[3])) {

				 return $this->win_horizontal_1;

			} else if ( (isset($marc[4]) && isset($marc[5]) && isset($marc[6])) && ($marc[4] == $marc[5] && $marc[5] == $marc[6]) ) {

				return $this->win_horizontal_2;

			} else if ( (isset($marc[7]) && isset($marc[8]) && isset($marc[9])) && ($marc[7] == $marc[8] && $marc[8] == $marc[9])) {

				return $this->win_horizontal_3;

			} else if ( (isset($marc[1]) && isset($marc[4]) && isset($marc[7])) && ($marc[1] == $marc[4] && $marc[4] == $marc[7])) {

				return $this->win_vertical_1;
				
			} else if ( (isset($marc[2]) && isset($marc[5]) && isset($marc[8])) && ($marc[2] == $marc[5] && $marc[5] == $marc[8])) {

				return $this->win_vertical_2;

			} else if ( (isset($marc[3]) && isset($marc[6]) && isset($marc[9])) && ($marc[3] == $marc[6] && $marc[6] == $marc[9]) ) {

				return $this->win_vertical_3;

			} else if ( (isset($marc[1]) && isset($marc[5]) && isset($marc[9])) && ($marc[1] == $marc[5] && $marc[5] == $marc[9]) ) {

				return $this->win_diagonal_1;

			} else if ( (isset($marc[3]) && isset($marc[5]) && isset($marc[7])) && ($marc[3] == $marc[5] && $marc[5] == $marc[7])) {

				return $this->win_diagonal_2;

			} else {
				return FALSE;
			}
		}
	}

	public function get_dado()
	{
		return $this->dado;
	}

	public function lanzar_dado($adivinar)
	{
		$this->dado = random_int(1, 6);

		return $this->adivinar_primero($adivinar);
	}

	private function adivinar_primero($adivinar)
	{
		if($this->dado%2 == 0){
			return ($adivinar == 'par') ? TRUE : FALSE;
		} else {
			return ($adivinar == 'impar') ? TRUE : FALSE;
		}
	}


}
?>