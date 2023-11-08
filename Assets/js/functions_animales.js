document.write(`<script type="text/javascript" src="${BaseUrl}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
let tableAnimales;
let rowTable;
let divLoading = document.querySelector("#divLoading");

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});

window.addEventListener('load',function(){

	tableAnimales = $('#tableAnimales').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":""+BaseUrl+"/Animales/GetAnimales",
			"dataSrc":""
		},
		columns: [
            { "data": 'idAnimal' },
			{ "data": 'nombre' },
            { "data": 'organizacion' },
            { "data": 'tipoAnimal' },
            { "data": 'genero' },
			{ "data": 'fecha_nacimiento' },
            { "data": 'estado' },
            { "data": 'options' }
        ],
        "columnDefs": [
        	{ "className" : "textcenter", "targets": [3]},
        	{ "className" : "textrigth", "targets": [4]},
        	{ "className" : "textcenter", "targets": [5]},
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
            	"extend": "copyHtml5",
            	"text": "<i class='fas fa-copy'></i> Copiar",
            	"titleAttr": "Copiar",
            	"className": "btn btn-secondary",
            	"exportOptions" : {
            		"columns": [0,1,2,3,4,5]
            	}
            },{
            	"extend": "excelHtml5",
            	"text": "<i class='fas fa-file-excel'></i> Excel",
            	"titleAttr": "Exportar a Excel",
            	"className": "btn btn-success",
            	"exportOptions" : {
            		"columns": [0,1,2,3,4,5]
            	}
            },{
            	"extend": "pdfHtml5",
            	"text": "<i class='fas fa-file-pdf'></i> PDF",
            	"titleAttr": "Exportar a PDF",
            	"className": "btn btn-danger",
            	"exportOptions" : {
            		"columns": [0,1,2,3,4,5]
            	}
            },{
            	"extend": "csvHtml5",
            	"text": "<i class='fas fa-file-csv'></i> CSV",
            	"titleAttr": "Exportar a CSV",
            	"className": "btn btn-info",
            	"exportOptions" : {
            		"columns": [0,1,2,3,4,5]
            	}
            },
        ],
        "responsive":"true",
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[2,"asc"]]
	});

	if(document.querySelector("#formAnimal")){
		let formAnimal = document.querySelector("#formAnimal");
		formAnimal.onsubmit = function(e){
			e.preventDefault();
			let strNombre = document.querySelector("#txtNombre").value;
			let strGenero = document.querySelector("#txtGenero").value;
			let listOrganizacion = document.querySelector("#listOrganizacionId").value;
			let listTipoAnimal = document.querySelector("#listTipoAnimalId").value;
			let dateFechaNacimiento = document.querySelector("#fechaNacimiento").value;
			let listStatus = document.querySelector("#listStatus").value;
			if(strNombre == '' || strGenero == '' || listOrganizacion == '' || listTipoAnimal == '' || listStatus == '')
			{
				swal("Atención", "Todos los campos son obligatorios", "error");
				return false;
			}
			divLoading.style.display = "flex";
			tinyMCE.triggerSave();
			let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
			let ajaxUrl = BaseUrl+'/Animales/SetAnimal';
			let formData = new FormData(formAnimal);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						swal("Animales", objData.msg, "success");
						document.querySelector('#idAnimal').value = objData.idAnimal;
						document.querySelector('#containerGallery').classList.remove("notBlock");
						if(rowTable == "")
						{
							tableAnimales.api().ajax.reload();
						}else{
							htmlStatus = listStatus == 1 ? 
							'<span class="badge badge-success">Activo</span>' :
							 '<span class="badge badge-danger">Inactivo</span>';
							rowTable.cells[1].textContent = strNombre;
							const selectElement = document.querySelector("#listOrganizacionId");
							const selectedOption = selectElement.options[selectElement.selectedIndex];
							const selectedText = selectedOption.textContent;
							rowTable.cells[2].textContent = selectedText;
							const selectElement2 = document.querySelector("#listOrganizacionId");
							const selectedOption2 = selectElement2.options[selectElement2.selectedIndex];
							const selectedText2 = selectedOption2.textContent;							
							rowTable.cells[3].textContent = selectedText2;
							rowTable.cells[4].textContent = strGenero;
							rowTable.cells[5].textContent = dateFechaNacimiento;
							rowTable.cells[6].innerHTML = htmlStatus;
							rowTable = "";
						}
					}else
					{
						swal("¡Error!", objData.msg, "error");
					}
					$('#modalFormAnimal').modal("hide");
					formAnimal.reset();
				}
				divLoading.style.display = "none";
				return false;
			}

		}
	}

	if(document.querySelector(".btnAddImage")){
		let btnAddImage = document.querySelector(".btnAddImage");
		btnAddImage.onclick = function (e){
			let key = Date.now();
			let newElement = document.createElement("div");
			newElement.id = "div"+key;
			newElement.innerHTML = `
			<div class="prevImage"></div>
            <input type="file" name="foto" id="img${key}" class="inputUploadFile" accept="image/jpg, image/jpeg, image/png">
            <label class="btnUploadFile" for="img${key}"><i class="fas fa-upload"></i></label>
            <button class="btnDeleteImage notBlock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
            document.querySelector('#containerImage').appendChild(newElement);
            document.querySelector('#div'+key+' .btnUploadFile').click();
            fntInputFile();
		}
	}
	
},false);


tinymce.init({
	selector:'#txtDescripcion',
	width: "100%",
	height: 400,
	statubar: true,
	plugins:[
	"advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",

});

function fntInputFile(){
	let inputUploadFile = document.querySelectorAll('.inputUploadFile');
	inputUploadFile.forEach(function(inputUploadFile){
		inputUploadFile.addEventListener('change',function() {
			let idProducto = document.querySelector('#idProducto').value;
			let parentId = this.parentNode.getAttribute("id");
			let idFile = this.getAttribute("id");
			let uploadFoto = document.querySelector("#"+idFile).value;
			let fileImg = document.querySelector("#"+idFile).files;
			let prevImg  = document.querySelector("#"+parentId+" .prevImage");
			let nav = window.URL || window.webkitURL;
			if(uploadFoto != '')
			{
				let type = fileImg[0].type;
				let name = fileImg[0].name;
				if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
					prevImg.innerHTML = "Archivo no válido";
					uploadFoto.value = "";
					return false;
				}else
				{
					let objeto_url = nav.createObjectURL(this.files[0]);
					prevImg.innerHTML = `<img class="loading" src="${BaseUrl}/Assets/images/loading.svg">`;

					let ajaxUrl = BaseUrl+'/Productos/SetImage';
					let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
					let formData = new FormData();
					formData.append('idproducto', idProducto);
					formData.append('foto', this.files[0]);
					request.open("POST", ajaxUrl, true);
					request.send(formData);
					request.onreadystatechange = function(){
						if(request.readyState != 4) return;
						if(request.status == 200){
							let objData = JSON.parse(request.responseText);
							if(objData.status){	
								prevImg.innerHTML = `<img src="${objeto_url}">`;
								document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
								document.querySelector("#"+parentId+" .btnUploadFile").classList.add("notBlock");
								document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notBlock");
							}else{
								swal("Error", objData.msg, "error");
							}
						}
					}
				}
			}
		});
	});
}

function fntDelItem(element){
	let nameImg = document.querySelector(element + ' .btnDeleteImage').getAttribute('imgname');
	let idProducto = document.querySelector('#idProducto').value;
	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Productos/DelFile';

	let formData = new FormData();
	formData.append('idproducto', idProducto);
	formData.append('file', nameImg);
	request.open("POST", ajaxUrl, true);
	request.send(formData);

	request.onreadystatechange = function(){
		if(request.readyState != 4) return;
		if(request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status){	
				let itemRemove = document.querySelector(element);
				itemRemove.parentNode.removeChild(itemRemove);
			}else{
				swal("Error", objData.msg, "error");
			}
		}
	}
}



function fntOrganizacion()
{
    let ajaxUrl = BaseUrl+'/Organizaciones/GetSelectOrganizaciones';
    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector("#listOrganizacionId").innerHTML = request.responseText;
            $('#listOrganizacionId').selectpicker('render');     
        }
    }

}
function fntTipoAnimal(){
    let ajaxUrl = BaseUrl+'/TipoAnimal/GetSelectTipoAnimal';
    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector("#listTipoAnimalId").innerHTML = request.responseText;
            $('#listTipoAnimalId').selectpicker('render');     
        }
    }

}

window.addEventListener('load',function(){
    fntOrganizacion();
	fntTipoAnimal()
},false);





function openModal()
{
	document.querySelector('#idAnimal').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo animal";
	document.querySelector('#formAnimal').reset();
	$('#modalFormAnimal').modal('show');

	document.querySelector('#containerGallery').classList.add("notBlock");
	document.querySelector("#containerImage").innerHTML = "";
	rowTable = "";
}

function fntViewAnimal(idAnimal)
{
	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Animales/GetAnimal/'+idAnimal;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{	
				let htmlImage = "";
				let estado = objData.data.estado == 1 ?
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celCodigo").innerHTML = objData.data.idAnimal;
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celOrganizacion").innerHTML = objData.data.idOrganizacion;
				document.querySelector("#celTipoAnimal").innerHTML = objData.data.idTipoAnimal;
				document.querySelector("#celGenero").innerHTML = objData.data.genero;
				document.querySelector("#celFechaNacimiento").innerHTML = objData.data.fecha_nacimiento;
				document.querySelector("#celEstado").innerHTML = estado;
	

				if(objData.data.images.length > 0)
				{
					let objProducto = objData.data.images;
					for(let p = 0; p < objProducto.length; p++)
					{
						htmlImage += `<img src="${objProducto[p].url_image}"></img>`;
					}
				}

				document.querySelector("#celFotos").innerHTML = htmlImage;
				$('#modalViewAnimal').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}

function fntEditAnimal(element, idAnimal)
{
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar Animal";

	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Animales/GetAnimal/'+idAnimal;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				let htmlImage = "";

				document.querySelector("#idAnimal").value = objData.data.idAnimal;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#listOrganizacionId").value = objData.data.idOrganizacion;
				document.querySelector("#listTipoAnimalId").value = objData.data.idTipoAnimal;
				document.querySelector("#txtGenero").value = objData.data.genero;
				const fechaNacimiento = new Date(objData.data.fecha_nacimiento);
				const formattedFechaNacimiento = fechaNacimiento.toISOString().slice(0, 10);
				document.querySelector("#fechaNacimiento").value = formattedFechaNacimiento;

				document.querySelector("#listStatus").value = objData.data.estado;

				$('#listOrganizacionId').selectpicker('render');
				$('#listStatus').selectpicker('render');
				$('#listTipoAnimalId').selectpicker('render');


				if(objData.data.images.length > 0)
				{
					let objProducto = objData.data.images;
					for(let p = 0; p < objProducto.length; p++)
					{
						let key = Date.now()+p;
						htmlImage += `<div id="div${key}">
						<div class="prevImage">
						<img src="${objProducto[p].url_image}"></img></div>
			            <button class="btnDeleteImage" type="button" onclick="fntDelItem('#div${key}')" imgname="${objProducto[p].img}"><i class="fas fa-trash-alt"></i></button></div>`;
					}
				}
				document.querySelector('#containerImage').innerHTML = htmlImage;
				$('#modalFormAnimal').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}


function fntDelAnimal(idAnimal)
{
	swal({
		title: "Eliminar Animal",
		text: "¿Realente quiere eliminar el Animal?",
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
			let ajaxUrl = BaseUrl+'/Animales/DelAnimal/';
			let strData = "idAnimal="+idAnimal;
			request.open("POST",ajaxUrl,true);
			request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						swal("¡Eliminar!", objData.msg, "success");
						tableAnimales.api().ajax.reload();
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
