<?php 


use App\config\Connection;
use App\models\services\PacienteService;
use App\models\repositories\PacienteRepository;

$connection = new Connection();
$pacienteRepositori = new PacienteRepository($connection);
$pacienteService = new PacienteService($pacienteRepositori);

$page = 1;
$filters =[];

print_r($pacienteService->listPacientes($filters, $page));

?>