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


<button type="button" id="btn_open_modal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Registrar
</button>


	<h1 class='h1 text-center mb-2'>vista pacientes</h1>

	<div class="container">
		
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


	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form id="form-paciente">
		      <div class="modal-body">
		        <div class="mb-3">
						<div class="mb-2">
							<input type="hidden" name="id" value='116' id="id_input">
							<label>Cedula</label>
							<input required type="text" name="cedula" class="form-control inputs">
						</div>
						<div class="mb-2">
							<label>Nombre</label>
							<input  required type="text" name="nombre" class="form-control inputs">
						</div>
						<div class="mb-2">
							<label>Apellido</label>
							<input  required type="text" name="apellido"  class="form-control inputs">
						</div>
						<div class="mb-2">
							<label>Telefono</label>
							<input  required type="text" name="telefono"  class="form-control inputs">
						</div>
						<div class="mb-2">
							<label>Genero</label>
							<select required name="genero"  class="form-control inputs">
								<option value="Masculino">Masculino</option>
								<option value="Femenino">Femenino</option>
							</select>
						</div>
						<div class="mb-2">
							<label>Fecha de nacimiento</label>
							<input  required type="date" name="fn"  class="form-control inputs">
						</div>
				</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
		        <button type="submit" class="btn btn-primary">Enviar</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>


	<script src='./src/asset/bootstrap/js/bootstrap.js'></script>
	<script src="./src/asset/sweetalert2/sweetalert2@11.js"></script>
	<script src='./src/asset/DataTable/jquery-3.7.1.js'></script>
	<script src='./src/asset/DataTable/datatables.js'></script>
	<script src='./src/asset/pacientes.js'></script>
</body>
</html>