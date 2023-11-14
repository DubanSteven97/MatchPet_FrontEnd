let rowTable;
let tableOrganizaciones;
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){

	tableOrganizaciones = $('#tableOrganizaciones').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":""+BaseUrl+"/Organizaciones/GetOrganizaciones",
			"dataSrc":""
		},
		"columns": [
            { "data": 'idOrganizacion' },
            { "data": 'nombre' },
            { "data": 'descripcion' },
            { "data": 'telefono' },
            { "data": 'direccion' },
            { "data": 'estado' },
            { "data": 'options' }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
            	"extend": "copyHtml5",
            	"text": "<i class='fas fa-copy'></i> Copiar",
            	"titleAttr": "Copiar",
            	"className": "btn btn-secondary"
            },{
            	"extend": "excelHtml5",
            	"text": "<i class='fas fa-file-excel'></i> Excel",
            	"titleAttr": "Exportar a Excel",
            	"className": "btn btn-success"
            },{
            	"extend": "pdfHtml5",
            	"text": "<i class='fas fa-file-pdf'></i> PDF",
            	"titleAttr": "Exportar a PDF",
            	"className": "btn btn-danger"
            },{
            	"extend": "csvHtml5",
            	"text": "<i class='fas fa-file-csv'></i> CSV",
            	"titleAttr": "Exportar a CSV",
            	"className": "btn btn-info"
            },
        ],
        "responsive":"true",
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
	});

	let formOrganizacion = document.querySelector("#formOrganizacion");
	formOrganizacion.onsubmit = function(e){
		e.preventDefault();
		let strNombre= document.querySelector('#txtNombre').value;
		let strTelefono = document.querySelector('#txtTelefono').value;
		let strDireccion = document.querySelector('#txtDireccion').value;
		let listStatus = document.querySelector("#listStatus").value;
		let srtDescripcion = document.querySelector("#txtDescripcion").value;
		

		if(strNombre == ''  || listStatus == '' )
		{
			swal("Atención", "Todos los campos son obligatorios", "error");
			return false;
		}

		let elementsValid = document.getElementsByClassName("valid");
		for(let i = 0; i < elementsValid.length; i++)
		{
			if(elementsValid[i].classList.contains('is-invalid'))
			{
				swal("Atención", "Por favor verifique los campos en rojo.", "error");
				return false;		
			}
		}

		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = BaseUrl+'/Organizaciones/SetOrganizacion';
		let formData = new FormData(formOrganizacion);
		request.open("POST",ajaxUrl,true);
		request.send(formData);

		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				let objData = JSON.parse(request.responseText);
				if(objData.status)
				{					
					if(rowTable == "" || rowTable === undefined)
					{
						tableOrganizaciones.api().ajax.reload();
					}else{
						htmlStatus = listStatus == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
						rowTable.cells[1].textContent = strNombre;
						rowTable.cells[2].textContent = srtDescripcion;
						rowTable.cells[3].textContent = strTelefono;
						rowTable.cells[4].textContent = srtDescripcion;
						rowTable.cells[5].innerHTML = htmlStatus;
					}
					$('#modalFormOrganizacion').modal("hide");
					formOrganizacion.reset();
					swal("Modulos", objData.msg, "success");
					
				}else
				{
					swal("¡Error!", objData.msg, "error");
				}
			}
			divLoading.style.display = "none";
			return false;
		}
	}	

}, false);


function fntViewOrganizacio(idorganizacion)
{
	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Organizaciones/GetOrganizacion/'+idorganizacion;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				let estadoOrganizacion = objData.data.estado == 1 ?
				'<span class="badge badge-success">Activo</span>' :
				'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
				document.querySelector("#celDireccion").innerHTML = objData.data.direccion;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				document.querySelector("#celEstado").innerHTML = estadoOrganizacion;
				$('#modalViewOrganizacion').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}

function fntViewUsersByOrganizacio(idorganizacion)
{
	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Organizaciones/GetUserByOrganizacion/'+idorganizacion;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				var table = document.getElementById('tableUsersByOrganizaciones');

				// Obtén el número de filas en la tabla, excluyendo el encabezado
				var rowCount = table.rows.length;
				
				// Itera sobre las filas (comenzando desde el final para evitar problemas de índice)
				for (var i = rowCount - 1; i > 0; i--) {
					table.deleteRow(i);
				}
				
				$('#modalViewUserByOrganizacion').modal('show');
				Object.entries(objData.data).forEach(([key, value]) =>{
					var estado = htmlStatus = value.estado  == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
					var fila = "<tr><td>" + value.idPersona+ "</td><td>" + value.nombres+ ' '+ value.apellidos  +"</td><td>" + value.email + "</td><td>" +value.numero_identificacion + "</td><td>" + value.telefono + "</td><td>" + estado + "</td></tr>";
					document.getElementById('tableUsersByOrganizaciones').insertRow(-1).innerHTML =fila;
				});

			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}
function fntEditOrganizacion(element, idorganizacion)
{
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar organización";

	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Organizaciones/GetOrganizacion/'+idorganizacion;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				document.querySelector("#idOrganizacion").value = objData.data.idOrganizacion;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtTelefono").value = objData.data.telefono;
				document.querySelector("#txtDireccion").value = objData.data.direccion;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
				document.querySelector("#listStatus").value = objData.data.estado;;
				$('#listStatus').selectpicker('refresh');
				$('#modalFormOrganizacion').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}


function fntDelOrganiazcion(idorganizacion)
{
    swal({
        title: "Eliminar el Rol",
        text: "¿Realmente quiere eliminar el Rol?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm){
        if(isConfirm)
        {
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
            let ajaxUrl = BaseUrl+'/Organizaciones/DelOrganizacion/'+idorganizacion;
			request.open("GET",ajaxUrl,true);
			request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.estado)
                    {
                        swal("¡Eliminar!", objData.msg, "success");
                        tableOrganizaciones.api().ajax.reload();
                    }else
                    {
                        swal("¡Error!", objData.msg, "error");
                    }
                }
                
                divLoading.style.display = "none";
                return false;
            }
        }
    });
}


function openModal()
{
	document.querySelector('#idOrganizacion').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nueva Organización";
	document.querySelector('#formOrganizacion').reset();
	$('#modalFormOrganizacion').modal('show');
}