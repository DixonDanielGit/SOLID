<?php 

use App\models\Paciente;

// $paciente = new Paciente();
// $paciente->setIdPaciente(111);
// $paciente->setNacionalidad("V");
// $paciente->setCedula('10181000');
// $paciente->setNombre("Xxxxx");
// $paciente->setApellido("Xddddxxxx");
// $paciente->setTelefono('04121338031');
// $paciente->setDireccion("Xxxxx sff dgdsg dgd");
// // $paciente->setFn('2026-07-07');
// $paciente->setGenero('Masculino');
// $paciente->setEstado();

function test()
{
	require_once './src/views/view_pacientes.php';
}

function data(){
	$paciente = new Paciente();

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limit = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$search = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['id_paciente', 'cedula', 'nombre', 'apellido', 'telefono','genero', 'fn'];


	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_paciente';

	$paciente->set_tables(["paciente"]);
	$paciente->set_colums(['nacionalidad','cedula','nombre','apellido','telefono','direccion','fn','genero','estado']);
	$paciente->set_condicion_aditional("estado ='ACT'");

	$paciente->set_orden_column($ordenColumna);
	$paciente->set_limit($limit);
	$paciente->set_start($start);
	$paciente->set_search($search);
	$paciente->set_orden_dir($ordenDir);

	//registros como tal
	$pacientes = $paciente->read();

	//total de los registros
	$paciente->set_colums(['COUNT(*) AS total']);
	$paciente->set_limit(0);
	$total = $paciente->read();

	//total de registrso filtrados
	$paciente->set_search($search);
	$total_filtrado = !empty($search) ? $paciente->read() : $total;

	$response = [
		"draw" => $draw,
		"recordsTotal" => (int)$total[0],
		"recordsFiltered" => (int)'68',
		"data" => is_array($pacientes) ? $pacientes : []
	];
	echo json_encode($response);
	exit();
}

?>