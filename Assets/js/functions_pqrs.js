function openModal()
{
    $('#modalFormPQRS').modal('show');

}

function enviarModal()
{
    let formPQRS= document.querySelector("#formPQRS");

    let strTipoPqrs = document.querySelector('#tipoPQRS').value;
    let strRazon = document.querySelector('#razonPQRS').value;
    let strNombre = document.querySelector('#txtNombre').value;
    let strApellido = document.querySelector('#txtApellidos').value;
    let strEmail = document.querySelector('#txtEmail').value;
    let intTelefono = document.querySelector('#txtTelefono').value;

    console.log(strTipoPqrs,strRazon,strNombre,strApellido,strEmail,intTelefono);

    let request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = BaseUrl+'/Pqrs/sendEmail';
    let formData = new FormData(formPQRS);

    request.open("POST",ajaxUrl,true);
    request.send(formData);

    console.log(request);
    console.log(ajaxUrl);
    console.log(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

  
            let objData = JSON.parse(request.responseText);
  
            if(objData.status)
            {
                $('#modalFormPQRS').modal("hide");
                formPQRS.reset();
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