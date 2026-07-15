addEventListener("DOMContentLoaded",function() {

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
	          return `<button class="btn btn-warning">Editar</button>
						<button class="btn btn-danger">Eliminar</button>`;
	        },
	      },
    	];

		initDataTable('.data_table','/SOLID/test/data',columnsPacientes);
 	}
	
	read_pacientes();

})
