let tablePaginas;

tablePaginas = $('#tablePaginas').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":""+BaseUrl+"/Paginas/GetPaginas",
			"dataSrc":""
		},
		"columns": [
            { "data": 'idPagina' },
            { "data": 'titulo' },
            { "data": 'fecha' },
            { "data": 'ruta' },
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


tinymce.init({
    selector:'#txtContenido',
    width: "100%",
    height: 600,
    statubar: true,
    plugins:[
    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",

});

if(document.querySelector("#formPaginas")){
    let formPaginas = document.querySelector("#formPaginas");
    formPaginas.onsubmit = function(e){
        e.preventDefault();
        let strTitulo = document.querySelector("#txtTitulo").value;
        let strContenido = document.querySelector("#txtContenido").value;
        let listStatus = document.querySelector("#listStatus").value;
        if(strTitulo == '' || strContenido == '' || listStatus == '')
        {
            swal("Atención", "Todos los campos son obligatorios", "error");
            return false;
        }
        divLoading.style.display = "flex";
        tinyMCE.triggerSave();
        let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
        let ajaxUrl = BaseUrl+'/Paginas/SetPagina';
        let formData = new FormData(formPaginas);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    swal({
                        title: "",
                        text: objData.msg,
                        type: "success",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: false,
                    },function (isConfirm){
                        location.reload();
                    });
                    
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
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
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
        if(document.querySelector('#foto_remove'))
        {
            document.querySelector('#foto_remove').value=1;
        }
        removePhoto();
    }
}


function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if(document.querySelector('#img'))
    {
        document.querySelector('#img').remove();
    }
}


function fntDelPagina(idpagina)
{
    swal({
        title: "Eliminar Página",
        text: "¿Realente quiere eliminar la Página?",
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
            let ajaxUrl = BaseUrl+'/Paginas/DelPagina/';
            let strData = "idPagina="+idpagina;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("¡Eliminar!", objData.msg, "success");
                        tablePaginas.api().ajax.reload();
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
