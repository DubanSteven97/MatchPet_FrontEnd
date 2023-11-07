let tableTipoAnimal;
let rowTable;
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){

	tableTipoAnimal = $('#tableTipoAnimal').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":""+BaseUrl+"/TipoAnimal/GetTipoAnimales",
			"dataSrc":""
		},
		columns: [
            { "data": 'idTipoAnimal' },
            { "data": 'nombre' },
            { "data": 'descripcion' },
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
        "order":[[1,"asc"]]
	});


	if(document.querySelector("#foto")){
	    let foto = document.querySelector("#foto");
	    foto.onchange = function(e) {
	        let uploadFoto = document.querySelector("#foto").value;
	        let fileimg = document.querySelector("#foto").files;
	        let nav = window.URL || window.webkitURL;
	        let contactAlert = document.querySelector('#form_alert');
	        if(uploadFoto !=''){
	            let type = fileimg[0].type;
	            let name = fileimg[0].name;
	            if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
	                contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
	                if(document.querySelector('#img')){
	                    document.querySelector('#img').remove();
	                }
	                document.querySelector('.delPhoto').classList.add("notBlock");
	                foto.value="";
	                return false;
	            }else{  
	                    contactAlert.innerHTML='';
	                    if(document.querySelector('#img')){
	                        document.querySelector('#img').remove();
	                    }
	                    document.querySelector('.delPhoto').classList.remove("notBlock");
	                    let objeto_url = nav.createObjectURL(this.files[0]);
	                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src='"+objeto_url+"' width='300'>";
	                }
	        }else{
	            alert("No selecciono foto");
	            if(document.querySelector('#img')){
	                document.querySelector('#img').remove();
	            }
	        }
	    }
	}

	if(document.querySelector(".delPhoto")){
	    let delPhoto = document.querySelector(".delPhoto");
	    delPhoto.onclick = function(e) {
	    	document.querySelector('#foto_remove').value=1;
	        removePhoto();
	    }
	}

	let formCategoria = document.querySelector("#formTipoAnimal");
	formCategoria.onsubmit = function(e){
		e.preventDefault();
		let strNombre = document.querySelector("#txtNombre").value;
		let strDescripcion = document.querySelector("#txtDescripcion").value;
		let listStatus = document.querySelector("#listStatus").value;
		let foto = document.querySelector("#foto").value;
		if(strNombre == '' || strDescripcion == '' || listStatus == '')
		{
			swal("Atención", "Todos los campos son obligatorios", "error");
			return false;
		}
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
		let ajaxUrl = BaseUrl+'/TipoAnimal/SetTipoAnimal';
		let formData = new FormData(formCategoria);
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				let objData = JSON.parse(request.responseText);
				if(objData.status)
				{
					if(rowTable == "")
					{
						tableTipoAnimal.api().ajax.reload();
					}else{
						htmlStatus = listStatus == 1 ? 
						'<span class="badge badge-success">Activo</span>' :
						 '<span class="badge badge-danger">Inactivo</span>';
						rowTable.cells[1].textContent = strNombre;
						rowTable.cells[2].textContent = strDescripcion;
						rowTable.cells[3].innerHTML = htmlStatus;
						rowTable = "";
					}

					$('#modalFormTipoAnimal').modal("hide");
					formCategoria.reset();
					swal("Tipo de animal", objData.msg, "success");
					removePhoto();
				}else
				{
					swal("¡Error!", objData.msg, "error");
				}
			}
			divLoading.style.display = "none";
			return false;
		}

	}

},false);

function openModal()
{
	document.querySelector('#idTipoAnimal').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo tipo de animal";
	document.querySelector('#formTipoAnimal').reset();
	$('#modalFormTipoAnimal').modal('show');
	rowTable = "";
	removePhoto();
}

function fntViewTipoAnimal(idTipoAnimal)
{
	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/TipoAnimal/GetTipoAnimal/'+idTipoAnimal;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{	
				let estado = objData.data.estado == 1 ?
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celId").innerHTML = objData.data.idTipoAnimal;
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				document.querySelector("#celEstado").innerHTML = estado;
				document.querySelector("#imgAnimal").innerHTML = '<img src="'+objData.data.url_portada+'" width="300"></img>';
				$('#modalViewTipoAnimal').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}

function fntEditTipoAnimal(element, idTipoAnimal)
{
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar tipo animal";

	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/TipoAnimal/GetTipoAnimal/'+idTipoAnimal;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				document.querySelector("#idTipoAnimal").value = objData.data.idTipoAnimal;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
				document.querySelector("#foto_actual").value = objData.data.img;
				document.querySelector('#foto_remove').value = 0;

				if(objData.data.status == 1)
				{
					document.querySelector("#listStatus").value = 1;
				}else
				{
					document.querySelector("#listStatus").value = 2;
				}
				$('#listStatus').selectpicker('render');

				if(document.querySelector("#img"))
				{
					document.querySelector("#img").src = objData.data.url_portada;
				}else
				{
					document.querySelector(".prevPhoto div").innerHTML = '<img src="'+objData.data.url_portada+'" width="300"></img>';
				}

				if(objData.data.portada == 'portada_categoria.png')
				{
					document.querySelector('.delPhoto').classList.add('notBlock');
				}else
				{
					document.querySelector('.delPhoto').classList.remove('notBlock');
				}

				$('#modalFormTipoAnimal').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}

function fntDelTipoAnimal(idTipoAnimal)
{
	swal({
		title: "Eliminar Tipo animal",
		text: "¿Realente quiere eliminar el tipo de animal?",
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
			let ajaxUrl = BaseUrl+'/TipoAnimal/DelTipoAnimal/';
			let strData = "idTipoAnimal="+idTipoAnimal;
			request.open("POST",ajaxUrl,true);
			request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						swal("¡Eliminar!", objData.msg, "success");
						tableTipoAnimal.api().ajax.reload();
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



function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if(document.querySelector('#img'))
    {
    	document.querySelector('#img').remove();
    }
}
