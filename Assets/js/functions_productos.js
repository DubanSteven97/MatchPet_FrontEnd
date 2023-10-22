document.write(`<script type="text/javascript" src="${BaseUrl}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
let tableProductos;
let rowTable;
let divLoading = document.querySelector("#divLoading");

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});

window.addEventListener('load',function(){

	tableProductos = $('#tableProductos').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":""+BaseUrl+"/Productos/GetProductos",
			"dataSrc":""
		},
		columns: [
            { "data": 'idproducto' },
            { "data": 'codigo' },
            { "data": 'nombre' },
            { "data": 'stock' },
            { "data": 'precio' },
            { "data": 'status' },
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

	if(document.querySelector("#formProducto")){
		let formProducto = document.querySelector("#formProducto");
		formProducto.onsubmit = function(e){
			e.preventDefault();
			let strNombre = document.querySelector("#txtNombre").value;
			let intPrecio = document.querySelector("#txtPrecio").value;
			let intStock = document.querySelector("#txtStock").value;
			let intCodigo = document.querySelector("#txtCodigo").value;
			let listStatus = document.querySelector("#listStatus").value;
			if(strNombre == '' || intPrecio == '' || intStock == '' || intCodigo == '')
			{
				swal("Atención", "Todos los campos son obligatorios", "error");
				return false;
			}
			if(intCodigo.length < 5)
			{
				swal("Atención", "El código debe ser mayor a 5 dígitos", "error");
				return false;
			}
			divLoading.style.display = "flex";
			tinyMCE.triggerSave();
			let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
			let ajaxUrl = BaseUrl+'/Productos/SetProducto';
			let formData = new FormData(formProducto);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						swal("Productos", objData.msg, "success");
						document.querySelector('#idProducto').value = objData.idproducto;
						document.querySelector('#containerGallery').classList.remove("notBlock");
						if(rowTable == "")
						{
							tableProductos.api().ajax.reload();
						}else{
							htmlStatus = listStatus == 1 ? 
							'<span class="badge badge-success">Activo</span>' :
							 '<span class="badge badge-danger">Inactivo</span>';
							rowTable.cells[1].textContent = intCodigo;
							rowTable.cells[2].textContent = strNombre;
							rowTable.cells[3].textContent = intStock;
							rowTable.cells[4].textContent = intPrecio;
							rowTable.cells[5].innerHTML = htmlStatus;
							rowTable = "";
						}
					}else
					{
						swal("¡Error!", objData.msg, "error");
					}
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
	
	fntCategorias();
},false);

if(document.querySelector('#txtCodigo')){
	let inputCodigo = document.querySelector('#txtCodigo');
	inputCodigo.onkeyup = function (){
		if(inputCodigo.value.length >= 5 && inputCodigo.value.length < 20)
		{
			document.querySelector('#divBarCode').classList.remove("notBlock");
			fntBarcode();
		}else{
			document.querySelector('#divBarCode').classList.add("notBlock");
		}
	}
}

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

function fntCategorias(){
	if(document.querySelector('#listCategoria'))
	{
		let ajaxUrl = BaseUrl+'/Categorias/GetSelectCategorias';
		let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
		request.open("GET", ajaxUrl, true);
		request.send();
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				document.querySelector('#listCategoria').innerHTML = request.responseText;
				$('#listCategoria').selectpicker('render');
			}
		}
		
	}

}

function fntBarcode()
{
	let codigo = document.querySelector('#txtCodigo').value;
	JsBarcode("#barcode", codigo);	
}

function fntPrintBarcode(area){
	let elementArea = document.querySelector(area);
	let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
	vprint.document.write(elementArea.innerHTML);
	vprint.document.close();
	vprint.print();
	vprint.close();
}

function openModal()
{
	document.querySelector('#idProducto').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
	document.querySelector('#formProducto').reset();
	$('#modalFormProducto').modal('show');

	document.querySelector('#divBarCode').classList.add("notBlock");
	document.querySelector('#containerGallery').classList.add("notBlock");
	document.querySelector("#containerImage").innerHTML = "";
	rowTable = "";
}

function fntViewProducto(idProducto)
{
	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Productos/GetProducto/'+idProducto;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{	
				let htmlImage = "";
				let estado = objData.data.status == 1 ?
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celCodigo").innerHTML = objData.data.codigo;
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celPrecio").innerHTML = objData.data.precioF;
				document.querySelector("#celStock").innerHTML = objData.data.stock;
				document.querySelector("#celCategoria").innerHTML = objData.data.categoria;
				document.querySelector("#celEstado").innerHTML = estado;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;

				if(objData.data.images.length > 0)
				{
					let objProducto = objData.data.images;
					for(let p = 0; p < objProducto.length; p++)
					{
						htmlImage += `<img src="${objProducto[p].url_image}"></img>`;
					}
				}

				document.querySelector("#celFotos").innerHTML = htmlImage;
				$('#modalViewProducto').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}

function fntEditProducto(element, idProducto)
{
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar Producto";

	let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/Productos/GetProducto/'+idProducto;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				let htmlImage = "";
				document.querySelector("#idProducto").value = objData.data.idproducto;
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
				document.querySelector("#txtCodigo").value = objData.data.codigo;
				document.querySelector("#txtPrecio").value = objData.data.precio;
				document.querySelector("#txtStock").value = objData.data.stock;
				document.querySelector("#listCategoria").value = objData.data.categoriaid;
				document.querySelector("#listStatus").value = objData.data.status;
				tinymce.activeEditor.setContent(objData.data.descripcion);
				$('#listStatus').selectpicker('render');
				$('#listCategoria').selectpicker('render');
				fntBarcode();
				document.querySelector('#divBarCode').classList.remove("notBlock");

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
				$('#modalFormProducto').modal('show');
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}


function fntDelProducto(idProducto)
{
	swal({
		title: "Eliminar Producto",
		text: "¿Realente quiere eliminar el Producto?",
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
			let ajaxUrl = BaseUrl+'/Productos/DelProducto/';
			let strData = "idProducto="+idProducto;
			request.open("POST",ajaxUrl,true);
			request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						swal("¡Eliminar!", objData.msg, "success");
						tableProductos.api().ajax.reload();
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
