<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="./src/asset/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="./src/asset/DataTable/datatables.css">
</head>
<body>

	<h1 class='h1 text-center mb-2'>vista pacientes</h1>

	<div class="container">
		<div class="mb-3">
			<form>
				<div class="mb-2">
					<label>Cedula</label>
					<input type="text" class="form-control">
				</div>
				<div class="mb-2">
					<label>Nombre</label>
					<input type="text" class="form-control">
				</div>
				<div class="mb-2">
					<label>Apellido</label>
					<input type="text" class="form-control">
				</div>
				<div class="mb-2">
					<label>Telefono</label>
					<input type="text" class="form-control">
				</div>
				<div class="mb-2">
					<label>Genero</label>
					<input type="text" class="form-control">
				</div>
				<div class="mb-2">
					<label>Fecha de nacimiento</label>
					<input type="text" class="form-control">
				</div>

				<button class='btn btn-primary'>Enviar</button>
			</form>
		</div>
		<table class='table table-sticket data_table'>
			<thead>
				<tr>
					<th>Cedula</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Telefono</th>
					<th>Genero</th>
					<th>Fecha de nacimiento</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Cedula</td>
					<td>Nombre</td>
					<td>Apellido</td>
					<td>Telefono</td>
					<td>Genero</td>
					<td>Fecha de nacimiento</td>
					<td>
						<button class="btn btn-warning">Editar</button>
						<button class="btn btn-danger">Eliminar</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<script src='./src/asset/bootstrap/js/bootstrap.js'></script>
	<script src='./src/asset/DataTable/jquery-3.7.1.js'></script>
	<script src='./src/asset/DataTable/datatables.js'></script>
	<script src='./src/asset/pacientes.js'></script>
</body>
</html>