addEventListener("DOMContentLoaded",function() {


	const modal = new bootstrap.Modal(
    document.getElementById("exampleModal"),
  	);
	const form_paciente = document.getElementById('form-paciente');
	const btn_open_modal = document.getElementById('btn_open_modal');
	const id_input = document.getElementById('id_input');

	//function generica for execute petiticon ajax
	const execute_petition = async (url, method = 'GET', data = null) => {
	  try {
	    const options = { method: method };

	    if (data instanceof FormData) {
	      options.body = data;
	    } else if (data && typeof data === "object") {
	      options.headers = {
	        "Content-Type": "application/json",
	      };
	      options.body = JSON.stringify(data);
	    }

	    let response = await fetch(url, options);
	    return response.json();
	  } catch (error) {
	    return error;
	  }
	};

	const alertConfirm = (text, action, param = "") => {
	  Swal.fire({
	    icon: "question",
	    title: "Confirmacion",
	    text: text,
	    showCancelButton: true,
	    confirmButtonText: "Aceptar",
	    cancelButtonText: "Cancelar",
	    customClass: {
	      popup: "switAlert",
	      confirmButton: "btn-agregarcita-modal",
	      cancelButton: "btn-agregarcita-modal-cancelar",
	    },
	  }).then((result) => {
	    if (result.isConfirmed) {
	      action(param);
	    }
	  });
	};

	const alertError = (title, text) => {
	  Swal.fire({
	    icon: "error",
	    title: title,
	    text: text,
	    customClass: {
	      popup: "switAlert",
	      confirmButton: "btn-agregarcita-modal",
	      cancelButton: "btn-agregarcita-modal-cancelar",
	    },
	  });
	};

	const alertSuccess = (text = 'todo bien.') => {
	  Swal.fire({
	    icon: "success",
	    title: "Exito",
	    text: text,
	    customClass: {
	      popup: "switAlert",
	      confirmButton: "btn-agregarcita-modal",
	      cancelButton: "btn-agregarcita-modal-cancelar",
	    },
	  });
	};


	const initDataTable = (
	  selector,
	  urlControlador,
	  columnas,
	  callbackDatos = null,
	  callbackEventos = null
	) => {
	  return $(selector).DataTable({
	    processing: true,
	    serverSide: true,
	    ajax: {
	      url: urlControlador,
	      type: "GET",
	      //esto es para si lo necesito guardar la data en una variable
	      dataSrc: function (json) {
	        if (callbackDatos && typeof callbackDatos === "function") {
	          callbackDatos(json.data);
	        }
	        return json.data;
	      },
	      error: function (xhr, error, thrown) {
	        console.error("Error en DataTables Ajax: ", error);
	      },
	    },
	    columns: columnas,

	    // basicamente esto es para llamar a los eventos que esten relacionados con la tabla ejemplo los botones de eliminar
	    drawCallback: function (settings) {
	      if (callbackEventos && typeof callbackEventos === "function") {
	        callbackEventos();
	      }
	    },
	    language: {
	      decimal: ",",
	      thousands: ".",
	      lengthMenu: "Mostrar por página _MENU_ ",
	      zeroRecords: "No se encontraron resultados",
	      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
	      infoEmpty: "No hay registros disponibles",
	      infoFiltered: "(filtrado de _MAX_ registros en total)",
	      search: "Buscar:",
	      processing: "Cargando Registros...",
	    },
	  });
	};

 	const read_pacientes =()=>{
 		console.log($('.data_table'))
 		// si ya existe DataTable, destrúyela
	    if ($.fn.DataTable.isDataTable('.data_table')) {
	      $('.data_table').DataTable().clear().destroy();
	    }

 		const columnsPacientes = [
	      {
	        data: "cedula",
	        render: (data, type, row) => `${row.nacionalidad}-${data}`,
	      },
	      { data: "nombre" },
	      { data: "apellido" },
	      { data: "telefono" },
	      { data: "genero" },
	      { data: 'fn' },
	      {
	        data: null,
	        orderable: false,
	        render: function (data, type, row) {
	          return `<button class="btn btn-warning btn-editar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-index="${row.id_paciente}">Editar</button>
						<button class="btn btn-danger btn-eliminar" data-index="${row.id_paciente}">Eliminar</button>`;
	        },
	      },
    	];

    	const asignarEventos = ()=>{
    		document.querySelectorAll('.btn-eliminar').forEach(btn=>{
    			btn.addEventListener('click', function(){
    				let id = btn.getAttribute('data-index');
    				alertConfirm("¿Desea eliminar el paciente?", delete_pacientes, id);
    			})
    		});

    		document.querySelectorAll('.btn-editar').forEach(btn=>{
    			btn.addEventListener('click', function(){
    				form_paciente.classList.add('editar');

    				const inputs = document.querySelectorAll('.inputs');
    				const columns = btn.closest('tr').children;

    				id_input.value = btn.getAttribute('data-index');
    				inputs[0].value = columns[0].textContent.slice(2,);
    				inputs[1].value = columns[1].textContent;
    				inputs[2].value = columns[2].textContent;
    				inputs[3].value = columns[3].textContent;
    				inputs[4].value = columns[4].textContent;
    				inputs[5].value = columns[5].textContent;
    			})
    		});
    	}

		initDataTable('.data_table','/SOLID/test/data',columnsPacientes,(datos)=>console.log(datos), asignarEventos);
 	}

 	const save_pacientes = async(form)=>{
 		try{
       		const data = new FormData(form);
 			const result = await execute_petition('/SOLID/test/save', 'POST', data);
 			if(result.ok){
	 			alertSuccess();
	 			modal.hide();
	 			form.reset();
	 			read_pacientes();
 			} else throw new Error(`${result.error}`);
 		}catch(error){
 			alertError('Error',error);
 		}
 	}

 	const update_pacientes = async(form)=>{
 		try{
       		const data = new FormData(form);
 			const result = await execute_petition('/SOLID/test/update', 'POST', data);
 			if(result.ok){
	 			alertSuccess();
	 			modal.hide();
	 			form.reset();
	 			read_pacientes();
 			} else throw new Error(`${result.error}`);
 		}catch(error){
 			alertError('Error',error);
 		}
 	}


 	const delete_pacientes = async(id)=>{
 		try{
 			const result = await execute_petition('/SOLID/test/delete/'+id);
 			if(result.ok){
 			alertSuccess();
 			read_pacientes();
 			} else throw new Error(`${result.error}`);
 		}catch(error){
 			alertError("Error", error);
 		}
 	}
	
	read_pacientes();

	btn_open_modal.addEventListener('click', function(){
    	form_paciente.classList.remove('editar');
    	form_paciente.reset();
	})

	form_paciente.addEventListener('submit', function(e){
		e.preventDefault();
		if (this.classList.contains('editar')) {
			update_pacientes(this);
			return;
		}
		save_pacientes(this);
	})

})
