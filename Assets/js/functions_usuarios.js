let tableUsuarios;
let divLoading = document.querySelector("#divLoading");
let rowTable;
document.addEventListener('DOMContentLoaded',function(){

    tableUsuarios = $('#tableUsuarios').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":""+BaseUrl+"/Usuarios/GetUsuarios",
            "dataSrc":""
        },
        "columns": [
            { "data": 'idPersona' },
            { "data": 'nombres' },
            { "data": 'apellidos' },
            { "data": 'email' },
            { "data": 'telefono' },
            { "data": 'nombreRol' },
            { "data": 'nombre' },
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

    let formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = function(e){
        e.preventDefault();
        let strIdentificacion = document.querySelector('#txtIdentificacion').value;
        let strNombre = document.querySelector('#txtNombres').value;
        let strApellido = document.querySelector('#txtApellidos').value;
        let strEmail = document.querySelector('#txtEmail').value;
        let intTelefono = document.querySelector('#txtTelefono').value;
        let intTipoUsuario = document.querySelector('#listRolId').value;
        let strPassword = document.querySelector('#txtPassword').value;
        let intStatus = document.querySelector('#listStatus').value;
        let intOrganizacion = document.querySelector('#listOrganizacionId').value;

    
        if(strIdentificacion == '' || strNombre == '' || strApellido == '' || strEmail == '' || intTelefono == '' || intTipoUsuario == '' || intOrganizacion == '')
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
        let ajaxUrl = BaseUrl+'/Usuarios/SetUsuario';
        let formData = new FormData(formUsuario);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.estado)
                {
                    if(rowTable == "")
                    {
                        tableUsuarios.api().ajax.reload();
                    }else{
                        htmlStatus = intStatus == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
                        rowTable.cells[1].textContent = strNombre;
                        rowTable.cells[2].textContent = strApellido;
                        rowTable.cells[3].textContent = strEmail;
                        rowTable.cells[4].textContent = intTelefono;
                        rowTable.cells[5].textContent = document.querySelector("#listRolId").selectedOptions[0].text;
                        rowTable.cells[6].textContent = document.querySelector("#listOrganizacionId").selectedOptions[0].text;
                        rowTable.cells[7].innerHTML = htmlStatus;
                    }
                    $('#modalFormUsuario').modal("hide");
                    formUsuario.reset();
                    swal("Usuarios", objData.msg, "success");
                    
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

window.addEventListener('load',function(){
    fntRolesUsuario();
    fntOrganizacion();
},false);

function fntRolesUsuario()
{
    let ajaxUrl = BaseUrl+'/Roles/GetSelectRoles';
    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector("#listRolId").innerHTML = request.responseText;
            $('#listRolId').selectpicker('render');     
            $('#listStatus').selectpicker('render');
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

function fntViewUsuario(idpersona)
{
    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    let ajaxUrl = BaseUrl+'/Usuarios/GetUsuario/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.estado)
            {
                let estadoUsuario = objData.data.estado == 1 ?
                '<span class="badge badge-success">Activo</span>' :
                '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celIdentificacion").innerHTML = objData.data.numero_identificacion;
                document.querySelector("#celNombres").innerHTML = objData.data.nombres;
                document.querySelector("#celApellidos").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email;
                document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
                document.querySelector("#celEstado").innerHTML = estadoUsuario;
                document.querySelector("#celOrganizacion").innerHTML = objData.data.nombre;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
                $('#modalViewUser').modal('show');
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
    }
}

function fntEditUsuario(element, idpersona)
{
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";

    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    let ajaxUrl = BaseUrl+'/Usuarios/GetUsuario/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.estado)
            {
                document.querySelector("#idUsuario").value = objData.data.idpersona;
                document.querySelector("#txtIdentificacion").value = objData.data.numero_identificacion;
                document.querySelector("#txtNombres").value = objData.data.nombres;
                document.querySelector("#txtApellidos").value = objData.data.apellidos;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtEmail").value = objData.data.email;
                document.querySelector("#listRolId").value = objData.data.idrol;
                document.querySelector("#listOrganizacionId").value = objData.data.idOrganizacion;
                document.querySelector("#listStatus").value = objData.data.estado;
                $('#listRolId').selectpicker('refresh');         
                $('#listStatus').selectpicker('refresh'); 
                $('#listOrganizacionId').selectpicker('refresh');                   
                $('#modalFormUsuario').modal('show');
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
    }
}

function fntDelUsuario(idpersona)
{
    swal({
        title: "Eliminar Usuario",
        text: "¿Realente quiere eliminar el Usuario?",
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
            let ajaxUrl = BaseUrl+'/Usuarios/DelUsuario/';
            let strData = "idUsuario="+idpersona;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.estado)
                    {
                        swal("¡Eliminar!", objData.msg, "success");
                        tableUsuarios.api().ajax.reload();
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
    rowTable = "";
    document.querySelector('#idUsuario').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector('#formUsuario').reset();
    $('#modalFormUsuario').modal('show');
}