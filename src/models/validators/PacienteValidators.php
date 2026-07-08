<?php 

namespace App\PacienteValidators;

use InvalidArgumentException;
use DateTime;

class PacienteValidators
{
	

	public function validateIdPaciente($id_paciente)
	{
		if (!preg_match("/^[0-9]+$/", $id_paciente) || (int)$id_paciente <= 0) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}
	}

	public function validateNacionalidad($nacionalidad)
	{
		if ($nacionalidad !== 'V' && $nacionalidad !== 'E') {
			throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
		}
	}

	public function validateCedula($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
		}
	}

	public function validateCedulaRegistrada($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula registrada debe contener entre 7 y 8 dígitos.");
		}
	}

	public function validateNombre($nombre)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $nombre)) {
			throw new \InvalidArgumentException("El nombre debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
		}
	}

	public function validateApellido($apellido)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $apellido)) {
			throw new \InvalidArgumentException("El apellido debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
		}
	}

	public function validateTelefono($telefono)
	{
		if (!preg_match("/^(0?)(412|422|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/", $telefono)) {
			throw new \InvalidArgumentException("El teléfono debe comenzar con un código válido y contener solo números.");
		}
	}

	public function validateDireccion($direccion)
	{
		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $direccion)) {
			throw new \InvalidArgumentException("La dirección debe estar completa y detallada.");
		}
	}

	public function validateFn($fn)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fn);
		if (!$dt || $dt->format('Y-m-d') !== $fn) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fn >= date("Y-m-d")) {
			throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
		}
	}

	public function validateGenero($genero)
	{
		if (!preg_match("/^(Masculino|Femenino)$/", $genero)) {
			throw new \InvalidArgumentException("El género debe ser 'Masculino' o 'Femenino'.");
		}
	}

	public function validateEstado($estado){
		if (in_array($estado, ['ACT','DES'])) {
			throw new \InvalidArgumentException("El estado no es valido");
		}
	}


}

 ?>