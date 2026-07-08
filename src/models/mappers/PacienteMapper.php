<?php 

namespace App\PacienteMapper;

use App\Paciente;

class PacienteMapper
{
	
	public function toData($paciente){
		return [
			'id_paciente'=>$paciente->getIdPaciente(),
			'nacionalidad'=>$paciente->getNacionalidad(),
			'cedula'=>$paciente->getCedula(),
			'nombre'=>$paciente->getNombre(),
			'apellido'=>$paciente->getApellido(),
			'telefono'=>$paciente->getTelefono(),
			'direccion'=>$paciente->getDireccion(),
			'fn'=>$paciente->getFn(),
			'genero'=>$paciente->getGenero(),
			'estado'=>$paciente->getEstado(),
		];
	}

	public function filterData(array $data){
		
		return array_filter($data, fn($v)=> $v != null && $v !=  '');
	}

}


 ?>