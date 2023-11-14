let tableUsuarios;
let divLoading = document.querySelector("#divLoading");
let rowTable;
document.addEventListener('DOMContentLoaded',function(){

    tableUsuarios = $('#tableClientes').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":""+BaseUrl+"/Clientes/GetClientes",
            "dataSrc":""
        },
        "columns": [
            { "data": 'idpersona' },
            { "data": 'nombres' },
            { "data": 'apellidos' },
            { "data": 'email_user' },
            { "data": 'telefono' },
            { "data": 'status' },
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

    let formCliente = document.querySelector("#formCliente");
    formCliente.onsubmit = function(e){
        e.preventDefault();
        let strIdentificacion = document.querySelector('#txtIdentificacion').value;
        let strNombre = document.querySelector('#txtNombres').value;
        let strApellido = document.querySelector('#txtApellidos').value;
        let strEmail = document.querySelector('#txtEmail').value;
        let intTelefono = document.querySelector('#txtTelefono').value;
        let strPassword = document.querySelector('#txtPassword').value;
        let intStatus = document.querySelector('#listStatus').value;
        let strnit = document.querySelector('#txtIdentificacionTributaria').value;
        let strrazon = document.querySelector('#txtRazon').value;
        let strdireccion= document.querySelector('#txtDireccion').value;

        if(strIdentificacion == '' || strNombre == '' || strApellido == '' || strEmail == '' || intTelefono == '' || strnit == ''|| strrazon == ''|| strdireccion == '')
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
        let ajaxUrl = BaseUrl+'/Clientes/SetCliente';
        let formData = new FormData(formCliente);

        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
      
                if(objData.status)
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
                        rowTable.cells[5].innerHTML = htmlStatus;
                    }
                    $('#modalFormCliente').modal("hide");
                    formCliente.reset();
                    swal("Cliente", objData.msg, "success");
                    
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

function fntViewCliente(idpersona)
{
    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    let ajaxUrl = BaseUrl+'/Clientes/GetCliente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                console.log(objData);
                let estadoUsuario = objData.data.status == 1 ?
                '<span class="badge badge-success">Activo</span>' :
                '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombres").innerHTML = objData.data.nombres;
                document.querySelector("#celApellidos").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celEstado").innerHTML = estadoUsuario;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
                document.querySelector("#IdentificacionTributaria").innerHTML = objData.data.nit;
                document.querySelector("#razonSocial").innerHTML = objData.data.nombrefiscal;
                document.querySelector("#direccionFiscal").innerHTML = objData.data.direccionfiscal;
                $('#modalViewCliente').modal('show');
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
    }
}

function fntEditCliente(element, idpersona)
{
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";

    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    let ajaxUrl = BaseUrl+'/Clientes/GetCliente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idUsuario").value = objData.data.idpersona;
                document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                document.querySelector("#txtNombres").value = objData.data.nombres;
                document.querySelector("#txtApellidos").value = objData.data.apellidos;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtEmail").value = objData.data.email_user;
                document.querySelector("#listStatus").value = objData.data.status; 
                document.querySelector("#txtIdentificacionTributaria").value = objData.data.nit; 
                document.querySelector("#txtRazon").value = objData.data.nombrefiscal; 
                document.querySelector("#txtDireccion").value = objData.data.direccionfiscal; 

                $('#listStatus').selectpicker('refresh');                
                $('#modalFormCliente').modal('show');
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
    }
}

function fntDelCliente(idpersona)
{
    swal({
        title: "Eliminar Cliente",
        text: "¿Realente quiere eliminar el Cliente?",
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
            let ajaxUrl = BaseUrl+'/Clientes/DelCliente/';
            let strData = "idUsuario="+idpersona;

            console.log(request);
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
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
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    document.querySelector('#formCliente').reset();
    $('#modalFormCliente').modal('show');
}