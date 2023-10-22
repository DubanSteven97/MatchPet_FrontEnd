
let formCliente = document.querySelector("#formEmpresa");
formCliente.onsubmit = function(e){
    e.preventDefault();
    let strDireccion= document.querySelector('#txtDireccion').value;
    let strTelefono = document.querySelector('#txtTelefono').value;


    if(strDireccion == '' )
    {
        swal("Atención", "Todos los campos son obligatorios", "error");
        return false;
    }


    divLoading.style.display = "flex";
    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = BaseUrl+'/Configuraciones/UpdateEmpresa';
    let formData = new FormData(formCliente);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
    
            if(objData.status)
            {
                fntCancelEditEmpresa();
                swal("Empresa", objData.msg, "success");
                
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
        divLoading.style.display = "none";
        return false;
    }
}

function fntViewEmpresa(idempresa)
{
    let formEmpresa = document.querySelector("#formEmpresa");
    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    let ajaxUrl = BaseUrl+'/Configuraciones/GetEmpresa/'+idempresa;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                formEmpresa.querySelector("#txtDireccion").value = objData.data.direccion;
                formEmpresa.querySelector("#txtTelefono").value = objData.data.telefono;
                formEmpresa.querySelector("#txtEmailPedidos").value = objData.data.correo_pedidos;
                formEmpresa.querySelector("#txtEmailEmpresa").value = objData.data.correo_empresa;
                formEmpresa.querySelector("#txtNombreRemitente").value = objData.data.nombre_remitente;
                formEmpresa.querySelector("#txtEmailRemitente").value = objData.data.correo_remitente;
                formEmpresa.querySelector("#txtNombreEmpresa").value = objData.data.nombre_empresa;
                formEmpresa.querySelector("#txtNombreAplicación").value = objData.data.nombre_aplicacion;
                formEmpresa.querySelector("#txtSitioWeb").value = objData.data.sitio_web;
                formEmpresa.querySelector("#txtSimboloMoneda").value = objData.data.simbolo_moneda;
                formEmpresa.querySelector("#txtMoneda").value = objData.data.moneda;
                formEmpresa.querySelector("#txtDivisa").value = objData.data.divisa;
                formEmpresa.querySelector("#txtSeparadorDecimal").value = objData.data.separador_decimales;
                formEmpresa.querySelector("#txtSeparadorMilesMillones").value = objData.data.separador_miles_millones;
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
    }
}

function fntEditEmpresa()
{

    let formEmpresa = document.querySelector("#formEmpresa");
    formEmpresa.querySelector("#txtDireccion").disabled = false;
    formEmpresa.querySelector("#txtTelefono").disabled = false;
    formEmpresa.querySelector("#txtEmailPedidos").disabled = false;
    formEmpresa.querySelector("#txtEmailEmpresa").disabled = false;
    formEmpresa.querySelector("#txtNombreRemitente").disabled = false;
    formEmpresa.querySelector("#txtEmailRemitente").disabled = false;
    formEmpresa.querySelector("#txtNombreEmpresa").disabled = false;
    formEmpresa.querySelector("#txtNombreAplicación").disabled = false;
    formEmpresa.querySelector("#txtSitioWeb").disabled = false;
    formEmpresa.querySelector("#txtSimboloMoneda").disabled = false;
    formEmpresa.querySelector("#txtMoneda").disabled = false;
    formEmpresa.querySelector("#txtDivisa").disabled = false;
    formEmpresa.querySelector("#txtSeparadorDecimal").disabled = false;
    formEmpresa.querySelector("#txtSeparadorMilesMillones").disabled = false;
    formEmpresa.querySelector("#editar").style.display = 'none';
    formEmpresa.querySelector("#cancelar").style.display = 'inline';
    formEmpresa.querySelector("#actualizar").style.display = 'inline';
    formEmpresa.querySelector("#actualizar").disabled = false;
    
}

function fntCancelEditEmpresa()
{

    let formEmpresa = document.querySelector("#formEmpresa");
    formEmpresa.querySelector("#txtDireccion").disabled = true;
    formEmpresa.querySelector("#txtTelefono").disabled = true;
    formEmpresa.querySelector("#txtEmailPedidos").disabled = true;
    formEmpresa.querySelector("#txtEmailEmpresa").disabled = true;
    formEmpresa.querySelector("#txtNombreRemitente").disabled = true;
    formEmpresa.querySelector("#txtEmailRemitente").disabled = true;
    formEmpresa.querySelector("#txtNombreEmpresa").disabled = true;
    formEmpresa.querySelector("#txtNombreAplicación").disabled = true;
    formEmpresa.querySelector("#txtSitioWeb").disabled = true;
    formEmpresa.querySelector("#txtSimboloMoneda").disabled = true;
    formEmpresa.querySelector("#txtMoneda").disabled = true;
    formEmpresa.querySelector("#txtDivisa").disabled = true;
    formEmpresa.querySelector("#txtSeparadorDecimal").disabled = true;
    formEmpresa.querySelector("#txtSeparadorMilesMillones").disabled = true;
    formEmpresa.querySelector("#editar").style.display = 'inline';
    formEmpresa.querySelector("#cancelar").style.display = 'none';
    formEmpresa.querySelector("#actualizar").style.display = 'none';
    formEmpresa.querySelector("#actualizar").disabled = true;
    
}
