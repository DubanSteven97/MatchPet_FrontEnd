let rowTable;
let tableModulos;
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){

	tableModulos = $('#tableModulos').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":""+BaseUrl+"/Modulos/GetModulos",
			"dataSrc":""
		},
		"columns": [
            { "data": 'idmodulo' },
            { "data": 'titulo' },
            { "data": 'descripcion' },
            { "data": 'icono' },
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

	let formModulo = document.querySelector("#formModulo");
	formModulo.onsubmit = function(e){
		e.preventDefault();
		let strTitulo = document.querySelector('#txtTitulo').value;
		let strDescripcion = document.querySelector('#txtDescripcion').value;
		let strIcono = document.querySelector('#txtIcono').value;
		let listStatus = document.querySelector("#listStatus").value;
		let srtRuta = document.querySelector("#txtRuta").value;
		

		if(strTitulo == '' || strDescripcion == '' || strIcono == '' || listStatus == '' )
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
		let ajaxUrl = BaseUrl+'/Modulos/SetModulo';
		let formData = new FormData(formModulo);
		request.open("POST",ajaxUrl,true);
		request.send(formData);

		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				let objData = JSON.parse(request.responseText);
				if(objData.status)
				{					
					if(rowTable == "")
					{
						tableModulos.api().ajax.reload();
					}else{
						rowTable.cells[1].textContent = strTitulo;
						rowTable.cells[2].textContent = strDescripcion;
						rowTable.cells[3].textContent = strIcono;
					}
					$('#modalFormModulo').modal("hide");
					formModulo.reset();
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

function fntViewModulo(idmodulo)
{
	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Modulos/GetModulo/'+idmodulo;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				let estadoModulo = objData.data.estado == 1 ?
				'<span class="badge badge-success">Activo</span>' :
				'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celTitulo").innerHTML = objData.data.titulo;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				document.querySelector("#celIcono").innerHTML = objData.data.icono;
				document.querySelector("#celRuta").innerHTML = objData.data.ruta;
				document.querySelector("#celEstado").innerHTML = estadoModulo;
				$('#modalViewModulo').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}

function fntEditModulo(element, idmodulo)
{
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar Modulo";

	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Modulos/GetModulo/'+idmodulo;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				document.querySelector("#idModulo").value = objData.data.idModulo;
				document.querySelector("#txtTitulo").value = objData.data.titulo;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
				document.querySelector("#txtIcono").value = objData.data.icono;
				document.querySelector("#txtRuta").value = objData.data.ruta;
				document.querySelector("#listStatus").value = objData.data.estado;
				$('#listStatus').selectpicker('render');
				$('#modalFormModulo').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}

function openModal()
{
	document.querySelector('#idModulo').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Modulo";
	document.querySelector('#formModulo').reset();
	$('#modalFormModulo').modal('show');
}