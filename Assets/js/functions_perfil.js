var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){
	var formPerfil = document.querySelector("#formPerfil");
	formPerfil.onsubmit = function(e){
		e.preventDefault();
		var strNombre = document.querySelector('#txtNombres').value;
		var strApellido = document.querySelector('#txtApellidos').value;
		var intTelefono = document.querySelector('#txtTelefono').value;
		var strPassword = document.querySelector("#txtPassword").value;
		var strPasswordConfirm = document.querySelector("#txtPasswordConfirm").value;

		if(strNombre == '' || strApellido == '' || intTelefono == '')
		{
			swal("Atención", "Todos los campos son obligatorios", "error");
			return false;
		}

		if(strPassword != "" || strPasswordConfirm != "")
		{
			if(strPassword.length < 5)
			{
				swal("Por favor", "La contraseña debe tener al menos 5 caracteres.", "error");
				return false;
			}
			if(strPassword != strPasswordConfirm)
			{
				swal("Por favor", "Las contraseñas no son iguales.", "error");
				return false;
			}
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
		var request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BaseUrl+'/Usuarios/PutPerfil';
		var formData = new FormData(formPerfil);
		request.open("POST",ajaxUrl,true);
		request.send(formData);

		request.onreadystatechange = function(){
			if(request.readyState != 4) return;
			if(request.status == 200){
				var objData = JSON.parse(request.responseText);
				if(objData.status)
				{
					$('#modalFormPerfil').modal("hide");
					swal({
						title: "",
						text: objData.msg,
						type: "success",
						showCancelButton: true,
						confirmButtonText: "Aceptar",
						closeOnConfirm: false
					}, function(isConfirm){
						if(isConfirm)
						{
							location.reload();
						}
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

	var formDataFiscal = document.querySelector("#formDataFiscal");
	formDataFiscal.onsubmit = function(e){
		e.preventDefault();
		divLoading.style.display = "flex";
		var strNit = document.querySelector('#txtNit').value;
		var strNombreFiscal = document.querySelector('#txtNombreFiscal').value;
		var strDireccionFiscal = document.querySelector('#txtDireccionFiscal').value;

		if(strNit == '' || strNombreFiscal == '' || strDireccionFiscal == '')
		{
			swal("Atención", "Todos los campos son obligatorios", "error");
			return false;
		}

		var request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BaseUrl+'/Usuarios/PutDFiscal';
		var formData = new FormData(formDataFiscal);
		request.open("POST",ajaxUrl,true);
		request.send(formData);

		request.onreadystatechange = function(){
			if(request.readyState != 4) return;
			if(request.status == 200){
				var objData = JSON.parse(request.responseText);
				if(objData.status)
				{
					swal({
						title: "",
						text: objData.msg,
						type: "success",
						showCancelButton: true,
						confirmButtonText: "Aceptar",
						closeOnConfirm: false
					}, function(isConfirm){
						if(isConfirm)
						{
							location.reload();
						}
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
},false);

window.addEventListener('load',function(){
	
},false);



function OpenModalPerfil()
{
	$('#modalFormPerfil').modal('show');
}