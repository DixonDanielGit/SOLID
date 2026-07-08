<?php

namespace App\Paciente;

class Paciente
{
	private $id_paciente = null;
	private $cedula;
	private $nacionalidad;
	private $nombre;
	private $apellido;
	private $telefono;
	private $direccion;
	private $fn;
	private $genero;
	private $estado;
	private $estado_salud;
	
	
	// ── Getters & Setters ────────────────────────────────────────────────────

	public function getIdPaciente()
	{
		return $this->id_paciente;
	}
	public function getNacionalidad()
	{
		return $this->nacionalidad;
	}
	public function getCedula()
	{
		return $this->cedula;
	}
	public function getCedulaRegistrada()
	{
		return $this->cedulaRegistrada;
	}
	public function getNombre()
	{
		return $this->nombre;
	}
	public function getApellido()
	{
		return $this->apellido;
	}
	public function getTelefono()
	{
		return $this->telefono;
	}
	public function getDireccion()
	{
		return $this->direccion;
	}
	public function getFn()
	{
		return $this->fn;
	}
	public function getGenero()
	{
		return $this->genero;
	}
	public function getEstado(){
		return $this->estado;
	}



	public function setIdPaciente($id_paciente)
	{
		$this->id_paciente = (int)$id_paciente;
	}

	public function setNacionalidad($nacionalidad)
	{
		$this->nacionalidad = $nacionalidad;
	}

	public function setCedula($cedula)
	{
		$this->cedula = $cedula;
	}

	public function setCedulaRegistrada($cedula)
	{
		$this->cedulaRegistrada = $cedula;
	}

	public function setNombre($nombre)
	{
		$this->nombre = $nombre;
	}

	public function setApellido($apellido)
	{
		$this->apellido = $apellido;
	}

	public function setTelefono($telefono)
	{
		$this->telefono = $telefono;
	}

	public function setDireccion($direccion)
	{
		$this->direccion = $direccion;
	}

	public function setFn($fn)
	{
		$this->fn = $fn;
	}

	public function setGenero($genero)
	{
		$this->genero = $genero;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}
}

?>