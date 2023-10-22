let rowTable
let tablePedidos = $('#tablePedidos').dataTable({
	"aProcessing":true,
	"aServerSide":true,
	"language":{
		"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
	},
	"ajax":{
		"url":""+BaseUrl+"/Pedidos/GetPedidos",
		"dataSrc":""
	},
	columns: [
        { "data": 'idpedido' },
        { "data": 'transaccion' },
        { "data": 'fecha' },
        { "data": 'monto' },
        { "data": 'tipopago' },
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
    "order":[[0,"desc"]]
});

function fntTransaccionPP(idtransaccion)
{
    divLoading.style.display = "flex";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = BaseUrl+'/Pedidos/GetTransaccionPP/'+idtransaccion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState != 4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#divModal").innerHTML = objData.html;
                $('#modalReembolso').modal("show");
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
        divLoading.style.display = "none";
        return false;
    }
}

function fntTransaccionMP(idtransaccion)
{
    divLoading.style.display = "flex";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = BaseUrl+'/Pedidos/GetTransaccionMP/'+idtransaccion;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState != 4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#divModal").innerHTML = objData.html;
                $('#modalReembolso').modal("show");
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
        divLoading.style.display = "none";
        return false;
    }
}


function fntReembolsar()
{
    let idtransaccion = document.querySelector('#idTransaccion').value;
    let observacion = document.querySelector('#txtObservacion').value;

    if(idTransaccion == '' || observacion == '')
    {
        swal("","Complete los datos para continuar.", "error");
        return false;
    }
    swal({
        title: "Hacer Reembolso",
        text: "¿Realente quiere hacer el reembolso?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, reembolsar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm){
        if(isConfirm)
        {
            divLoading.style.display = "flex";
            $('#modalReembolso').modal("hide");
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = BaseUrl+'/Pedidos/SetReembolso';
            request.open("POST",ajaxUrl,true);
            let formData = new FormData();
            formData.append('idtransaccion',idtransaccion);
            formData.append('observacion',observacion);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4) return;
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        window.location.reload();
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

function fntEditProducto(element, idpedido)
{
    rowTable = element.parentNode.parentNode.parentNode;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = BaseUrl+'/Pedidos/GetPedido/'+idpedido;
    divLoading.style.display = "flex";
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#divModal").innerHTML = objData.html;
                $('#modalFormPedido').modal('show');
                $('select').selectpicker();
                fntUpdateInfo();
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
        divLoading.style.display = "none";
        return false;
    }
}

function fntUpdateInfo()
{
    let formUpdatePedido = document.querySelector("#formPedido");
    formUpdatePedido.onsubmit = function(e){
        e.preventDefault();
        if(document.querySelector("#txtTransaccion")){
            transaccion = document.querySelector("#txtTransaccion").value;
            if (transaccion == "") {
                swal("","Complete los datos para continuar","error");
                return false;
            }
        }
         let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = BaseUrl+'/Pedidos/SetPedido/';
        divLoading.style.display = "flex";
        let formData = new FormData(formUpdatePedido);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    swal("", objData.msg, "success");
                    $('#modalFormPedido').modal('hide');
                    if(document.querySelector("#txtTransaccion"))
                    {
                        rowTable.cells[1].textContent = document.querySelector("#txtTransaccion").value;
                        rowTable.cells[4].textContent = document.querySelector("#listTipopago").selectedOptions[0].innerText;
                        rowTable.cells[5].textContent = document.querySelector("#listEstado").value;
                    }else{
                        rowTable.cells[5].textContent = document.querySelector("#listEstado").value;
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