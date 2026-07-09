<?php 

use App\models\Paciente;

$paciente = new Paciente();

print_r($paciente->read_pacientes());
print_r($paciente->read_pacientes_con_patologias());
?>