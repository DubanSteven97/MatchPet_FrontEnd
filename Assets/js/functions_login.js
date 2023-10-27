 $('.login-content [data-toggle="flip"]').click(function() {
	$('.login-box').toggleClass('flipped');
	return false;
});

var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){
	if(document.querySelector("#formLogin"))
	{
		let formLogin = document.querySelector("#formLogin");
		formLogin.onsubmit = function (e){
			e.preventDefault();

			let strEmail = document.querySelector("#txtEmail").value;
			let strPassword = document.querySelector("#txtPassword").value;

			if(strEmail == "" || strPassword == "")
			{
				swal("Por favor","Escribe usuario y contraseña.", "error");
				return false;
			}else
			{
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
				var ajaxUrl = BaseUrl+'/Login/LoginUser';
				var formData = new FormData(formLogin);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200)
					{
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							//window.location = BaseUrl+'/dashboard';
							window.location.reload(false);
						}else
						{
							swal("Atención",objData.msg, "error");
							document.querySelector('#txtPassword').value = "";
						}
					}else{
						swal("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
				}
			}
		}
	}

	if(document.querySelector("#formRecetPass"))
	{
		let formRecetPass = document.querySelector("#formRecetPass");
		formRecetPass.onsubmit = function (e){
			e.preventDefault();
			let strEmailReset = document.querySelector("#txtEmailReset").value;
			if(strEmailReset == "")
			{
				swal("Por favor","Escribe tu correo electrónico.", "error");
				return false;
			}else
			{
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
				var ajaxUrl = BaseUrl+'/Login/ResetPass';
				var formData = new FormData(formRecetPass);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200)
					{
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							swal({
								title: "",
								text: objData.msg,
								type: "success",
								confirmButtonText: "Aceptar",
								closeOnConfirm: false,
							}, function(isConfirm){
								if(isConfirm){
									window.location = BaseUrl;
								}
							});
						}else
						{
							swal("Atención",objData.msg, "error");
						}
					}else{
						swal("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
				}
			}
		}
	}

	if(document.querySelector("#formCambiarPass"))
	{
		let formCambiarPass = document.querySelector("#formCambiarPass");
		formCambiarPass.onsubmit = function(e){
			e.preventDefault();

			let strPassword = document.querySelector("#txtPassword").value;
			let strPasswordConfirm = document.querySelector("#txtPasswordConfirm").value;
			let idUsuario = document.querySelector("#idUsuario").value;

			if(strPassword == "" || strPasswordConfirm == "")
			{
				swal("Por favor", "Escribe la nueva contraseña", "error");
				return false;
			}else
			{
				if(strPassword.length < 5)
				{
					swal("Por favor", "La contraseña debe tener al menos 5 caracteres", "error");
					return false;
				}
				if(strPassword != strPasswordConfirm)
				{
					swal("Por favor", "Las contraseñas no son iguales", "error");
					return false;
				}
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ? XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
				var ajaxUrl = BaseUrl+'/Login/SetPassword';
				var formData = new FormData(formCambiarPass);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200)
					{
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							swal({
								title: "",
								text: objData.msg,
								type: "success",
								confirmButtonText: "Iniciar Sesión",
								closeOnConfirm: false,
							}, function(isConfirm){
								if(isConfirm){
									window.location = BaseUrl+'/Login';
								}
							});
						}else
						{
							swal("Atención",objData.msg, "error");
						}
					}else{
						swal("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
				}
			}
		}
	}

}, false);