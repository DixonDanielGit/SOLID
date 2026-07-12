<?php 

use App\models\Paciente;

$paciente = new Paciente();
$paciente->setIdPaciente(111);
$paciente->setNacionalidad("V");
$paciente->setCedula('10181000');
$paciente->setNombre("Xxxxx");
$paciente->setApellido("Xddddxxxx");
$paciente->setTelefono('04121338031');
$paciente->setDireccion("Xxxxx sff dgdsg dgd");
$paciente->setFn('2026-07-07');
$paciente->setGenero('Masculino');
$paciente->setEstado();


require_once './src/views/view_pacientes.php';
?>