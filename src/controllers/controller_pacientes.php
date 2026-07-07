<?php  
use App\models\PacienteServer;
use App\models\Paciente;

$pacientesServer = new PacienteServer();
$paciente = new Paciente();
$paciente->setCedula(30554144);

$pacientesServer->read_pacientes($paciente);
$pacientesServer->read_pacientes_con_patologias($paciente);




?>