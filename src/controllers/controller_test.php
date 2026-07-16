<?php 

use App\models\Paciente;



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
	$paciente->set_colums(['id_paciente','nacionalidad','cedula','nombre','apellido','telefono','direccion','fn','genero','estado']);
	$paciente->set_condicion_aditional(" estado ='ACT'  ");

	$paciente->set_orden_column($ordenColumna);
	$paciente->set_limit($limit);
	$paciente->set_start($start);
	$paciente->set_search($search);
	$paciente->set_orden_dir($ordenDir);

	//registros como tal
	$pacientes = $paciente->read();

	//total de los registros
	$paciente->set_limit(0);
	$total = count($paciente->read());

	//total de registrso filtrados
	$paciente->set_search($search);
	$total_filtrado = !empty($search) ? count($paciente->read()) : $total;

	$response = [
		"draw" => $draw,
		"recordsTotal" => (int)$total,
		"recordsFiltered" => (int)$total_filtrado,
		"data" => is_array($pacientes) ? $pacientes : []
	];
	echo json_encode($response);
	exit();
}

function save(){

	if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
		$paciente = new Paciente();
		$paciente->set_tables('paciente');

		$paciente->setNacionalidad("V");
		$paciente->setCedula($_POST['cedula']);
		$paciente->setNombre($_POST['nombre']);
		$paciente->setApellido($_POST['apellido']);
		$paciente->setTelefono($_POST['telefono']);
		$paciente->setDireccion('Esto es una direccion');
		$paciente->setFn($_POST['fn']);
		$paciente->setGenero($_POST['genero']);
		$paciente->setEstado('ACT');

		$paciente->set_colums($paciente->get_all());

		$insercion = $paciente->create();

        if (!empty($insercion)) {
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data'=>$insercion]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }

	} catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}


function update(){

	if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
		$paciente = new Paciente();

		$paciente->setIdPaciente($_POST['id']);
		$paciente->setNacionalidad("V");
		$paciente->setCedula($_POST['cedula']);
		$paciente->setNombre($_POST['nombre']);
		$paciente->setApellido($_POST['apellido']);
		$paciente->setTelefono($_POST['telefono']);
		$paciente->setDireccion('Esto es una direccion pero editarda');
		$paciente->setFn($_POST['fn']);
		$paciente->setGenero($_POST['genero']);
		$paciente->setEstado('ACT');

		$paciente->set_tables('paciente');
		$paciente->set_colums($paciente->get_all());

		$update = $paciente->update(['id_paciente'=>$paciente->getIdPaciente()]);

        if (!empty($update)) {
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data'=>$update]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $update]);
            exit;
        }

	} catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

function delete($parametro){

	if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try{
		$paciente = new Paciente();

		$paciente->setIdPaciente($parametro[0]);

		$paciente->set_tables('paciente');
		$delete = $paciente->delete(['id_paciente'=>$paciente->getIdPaciente()]);

		if (!empty($delete)) {
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $delete]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

?>