let tableRoles;
let divLoading = document.querySelector("#divLoading");
let rowTable;
document.addEventListener('DOMContentLoaded',function(){

    tableRoles = $('#tableRoles').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":""+BaseUrl+"/Roles/GetRoles",
            "dataSrc":""
        },
        "columns": [
            { "data": 'idRol' },
            { "data": 'nombreRol' },
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

    let formRol = document.querySelector("#formRol");
    formRol.onsubmit = function(e){
        e.preventDefault();
        let strNombreRol = document.querySelector('#txtNombre').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let intStatus = document.querySelector('#listStatus').value;


        if(strNombreRol == '' || strDescripcion == '')
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
        let ajaxUrl = BaseUrl+'/Roles/SetRol';
        let formData = new FormData(formRol);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                console.log(request.responseText);
                let objData = JSON.parse(request.responseText);
                if(objData.estado)
                {
                    if(rowTable == "")
                    {
                        tableRoles.api().ajax.reload();
                    }else{
                        htmlStatus = intStatus == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
                        rowTable.cells[1].textContent = strNombreRol;
                        rowTable.cells[2].textContent = strDescripcion;
                        rowTable.cells[3].innerHTML = htmlStatus;
                    }
                    $('#modalFormRol').modal("hide");
                    formRol.reset();
                    swal("Roles", objData.msg, "success");
                    
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

function fntPermisos(idrol)
{
	var idRol = idrol;
	var request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	var ajaxUrl = BaseUrl+'/Permisos/GetPermisosRol/'+idRol;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200)
		{
			document.querySelector('#contentAjax').innerHTML = request.responseText;
			$('.modalPermisos').modal('show');

			document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
		}
	}
}

function fntEditRol(element, idRol)
{
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Rol";

    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    let ajaxUrl = BaseUrl+'/Roles/GetRol/'+idRol;
    console.log(ajaxUrl);
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.estado)
            {
                document.querySelector("#idrol").value = objData.data.idRol;
                document.querySelector("#txtNombre").value = objData.data.nombreRol;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                document.querySelector("#listStatus").value = objData.data.estado;       
                $('#listStatus').selectpicker('refresh');                
                $('#modalFormRol').modal('show');
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
    }
}

function fntDelRol(idRol)
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
            let ajaxUrl = BaseUrl+'/Roles/DelRol/';
            let strData = "idRol="+idRol;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.estado)
                    {
                        swal("¡Eliminar!", objData.msg, "success");
                        tableRoles.api().ajax.reload();
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


function fntSavePermisos(event){
	event.preventDefault();
	var request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	var ajaxUrl = BaseUrl+'/Permisos/SetPermisos/';
	var formElement = document.querySelector('#formPermisos');
	var formData = new FormData(formElement);
	request.open("POST",ajaxUrl,true);
	request.send(formData);

	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var objData = JSON.parse(request.responseText);
			if(objData.estado)
			{
				swal("¡Permisos de usuario!", objData.msg, "success");
			}else
			{
				swal("¡Error!", objData.msg, "error");
			}
		}
	}
}


function openModal()
{
    rowTable = "";
    document.querySelector('#idrol').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector('#formRol').reset();
    $('#modalFormRol').modal('show');
}
