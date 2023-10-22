
document.addEventListener('DOMContentLoaded',function(){
	if(document.querySelector("#formRegister"))
	{
		let formRegister = document.querySelector("#formRegister");
		formRegister.onsubmit = function (e){
			e.preventDefault();

			let strnombre = document.querySelector("#nombres").value;
			let strapellido= document.querySelector("#apellidos").value;

			if(strnombre == "" || strapellido == "")
			{
				swal("Por favor","Escribe usuario y contraseña.", "error");
				return false;
			}
		}
	}
}, false);