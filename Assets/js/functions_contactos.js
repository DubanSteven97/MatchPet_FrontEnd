let tableContactos;

tableContactos = $('#tableContactos').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":""+BaseUrl+"/Contactos/GetContactos",
			"dataSrc":""
		},
		"columns": [
            { "data": 'id' },
            { "data": 'nombre' },
            { "data": 'email' },
            { "data": 'fecha' },
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
        "iDisplayLength":10
	});


function fntViewInfo(idContacto)
{
    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    let ajaxUrl = BaseUrl+'/Contactos/GetContacto/'+idContacto;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {   
                document.querySelector("#celId").innerHTML = objData.data.id;
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                document.querySelector("#celEmail").innerHTML = objData.data.email;
                document.querySelector("#celFecha").innerHTML = objData.data.fecha;
                document.querySelector("#celMensaje").innerHTML = objData.data.mensaje;

                $('#modalViewMensaje').modal('show');
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
    }
}