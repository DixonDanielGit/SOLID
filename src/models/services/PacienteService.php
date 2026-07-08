<?php 

namespace App\models\services;

use App\PacienteRepository;
use App\PacienteValidator;
use App\PacienteMapper;
use App\Paciente;


class PacienteService
{
	private $repo;
	
	function __construct($repo)
	{
		$this->repo = $repo;
	}

	public function listPacientes($filters, $page)
	{
		$colums = ['id_paciente','cedula','nacionalidad','nombre','apellido','telefono','direccion','fn','genero','estado'];
		$search = $filters['buscar'] ?? '';
		return $this->repo->paginate($colums, $search, $page);
	}
}

 ?>