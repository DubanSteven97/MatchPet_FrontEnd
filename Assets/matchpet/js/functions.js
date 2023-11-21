var divLoading = document.querySelector("#divLoading");

$(".js-select2").each(function(){
	$(this).select2({
		minimumResultsForSearch: 20,
		dropdownParent: $(this).next('.dropDownSelect2')
	});
})

$('.parallax100').parallax100();

$('.gallery-lb').each(function() { // the containers for all your galleries
	$(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
        	enabled:true
        },
        mainClass: 'mfp-fade'
    });
});

$('.js-addwish-b2').on('click', function(e){
	e.preventDefault();
});

$('.js-addwish-b2').each(function(){
	var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
	$(this).on('click', function(){
		swal(nameProduct, "is added to wishlist !", "success");

		$(this).addClass('js-addedwish-b2');
		$(this).off('click');
	});
});

$('.js-addwish-detail').each(function(){
	var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

	$(this).on('click', function(){
		swal(nameProduct, "is added to wishlist !", "success");

		$(this).addClass('js-addedwish-detail');
		$(this).off('click');
	});
});

/*---------------------------------------------*/

$('.js-addcart-detail').each(function(){
	var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
	$(this).on('click', function(){
		let id = this.getAttribute('id');
		let cant = document.querySelector("#cant-product").value;
		if(isNaN(cant) || cant < 1)
		{
			swal("","La cantidad debe ser mayor o igual a 1", "error");
			return;
		}

		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
		let ajaxUrl = BaseUrl+'/Tienda/AddCarrito';
		let formData = new FormData();
		formData.append('id',id);
		formData.append('cant',cant);
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if(request.readyState != 4) return;
			if(request.status == 200){
				let objData = JSON.parse(request.responseText);
				if(objData.status)
				{
					document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
					document.querySelector("#cantCarrito").setAttribute("data-notify",objData.cantCarrito);
					document.querySelector("#cantCarritoM").setAttribute("data-notify",objData.cantCarrito);
					swal(nameProduct, objData.msg, "success");
				}else
				{
					swal("", objData.msg, "error");
				}
			}
			return false;
		}
	});
});

$('.js-pscroll').each(function(){
	$(this).css('position','relative');
	$(this).css('overflow','hidden');
	var ps = new PerfectScrollbar(this, {
		wheelSpeed: 1,
		scrollingThreshold: 1000,
		wheelPropagation: false,
	});

	$(window).on('resize', function(){
		ps.update();
	})
});


/*==================================================================
[ +/- num product ]*/
$('.btn-num-product-down').on('click', function(){
    let numProduct = Number($(this).next().val());
    let idpr = this.getAttribute('idpr');
    if(numProduct > 1) $(this).next().val(numProduct - 1);
    let cant = $(this).next().val();
    if(idpr != null){
    	fntUpdateCant(idpr, cant);
    }
});

$('.btn-num-product-up').on('click', function(){
    let numProduct = Number($(this).prev().val());
    let idpr = this.getAttribute('idpr');
    $(this).prev().val(numProduct + 1);
    let cant = $(this).prev().val();
    if(idpr != null){
    	fntUpdateCant(idpr, cant);
    }
});

if(document.querySelector(".num-product"))
{
	let inputCant = document.querySelectorAll(".num-product");
	inputCant.forEach(function(inputCant){
		inputCant.addEventListener('keyup',function(){
			let idpr = this.getAttribute('idpr');
			let cant = this.value;
			if(idpr != null){
		    	fntUpdateCant(idpr, cant);
		    }
		});
	});
}

if(document.querySelector("#formRegister")){
	let formRegister = document.querySelector("#formRegister");
	formRegister.onsubmit = function(e){
		e.preventDefault();
		let strNombre = document.querySelector('#txtNombre').value;
		let strApellido = document.querySelector('#txtApellido').value;
		let strEmail = document.querySelector('#txtEmailCliente').value;
		let intTelefono = document.querySelector('#txtTelefono').value;
	

		if(strNombre == '' || strApellido == '' || strEmail == '' || intTelefono == '')
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
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = BaseUrl+'/Adoptables/Registro';
		let formData = new FormData(formRegister);
		request.open("POST",ajaxUrl,true);
		request.send(formData);

		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				let objData = JSON.parse(request.responseText);
				if(objData.status)
				{					
					swal("¡Bienvenido a MatchPet!", objData.msg, "success").then((value) => {

						window.location.reload(false);	
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

if(document.querySelector(".methodpago")){
	let methodpago = document.querySelectorAll(".methodpago");
	methodpago.forEach(function(optmetodo){
		optmetodo.addEventListener('click', function(){
			if(this.value == "Paypal")
			{
				document.querySelector("#msgpaypal").classList.remove("notBlock");
				document.querySelector("#divtipopago").classList.add("notBlock");
				document.querySelector("#msgmercadopago").classList.add("notBlock");
			}else{
				if(this.value == "MercadoPago")
				{
					document.querySelector("#msgpaypal").classList.add("notBlock");
					document.querySelector("#divtipopago").classList.add("notBlock");
					document.querySelector("#msgmercadopago").classList.remove("notBlock");
				}else
				{
					document.querySelector("#msgpaypal").classList.add("notBlock");
					document.querySelector("#divtipopago").classList.remove("notBlock");
					document.querySelector("#msgmercadopago").classList.add("notBlock");
				}
			}
		});
	});
}
function fntDelItem(element)
{
	//Option 1 = Modal
	//Option 2 = Carrito
	let option = element.getAttribute("op");
	let idpr = element.getAttribute("idpr");

	if(option == 1 || option == 2)
	{
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
		let ajaxUrl = BaseUrl+'/Tienda/DelCarrito';
		let formData = new FormData();
		formData.append('id',idpr);
		formData.append('option',option);
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if(request.readyState != 4) return;
			if(request.status == 200){
				let objData = JSON.parse(request.responseText);
				if(objData.status)
				{
					if(option == 1){
						document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
						document.querySelector("#cantCarrito").setAttribute("data-notify",objData.cantCarrito);
						document.querySelector("#cantCarritoM").setAttribute("data-notify",objData.cantCarrito);
					}else
					{
						element.parentNode.parentNode.remove();
						document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
						document.querySelector("#totalCompra").innerHTML = objData.total;

						if(document.querySelectorAll("#tblCarrito tr").length == 1)
						{
							window.location.href = BaseUrl;
						}
					}
				}else
				{
					swal("", objData.msg, "error");
				}
			}
			return false;
		}
	}
}

function fntUpdateCant(pro, can){
	if(can <= 0)
	{
		document.querySelector("#btnComprar").classList.add("notBlock");
	}else{
		document.querySelector("#btnComprar").classList.remove("notBlock");
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
		let ajaxUrl = BaseUrl+'/Tienda/UpdCarrito';
		let formData = new FormData();
		formData.append('id',pro);
		formData.append('cant',can);
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if(request.readyState != 4) return;
			if(request.status == 200){
				let objData = JSON.parse(request.responseText);
				if(objData.status)
				{
					let colSubtotal = document.getElementsByClassName(pro)[0];
					colSubtotal.cells[4].textContent = objData.totalProducto;
					document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
					document.querySelector("#totalCompra").innerHTML = objData.total;
				}else
				{
					swal("", objData.msg, "error");
				}
			}
			return false;
		}
	}
}


if(document.querySelector("#txtDireccion"))
{
	let direccion = document.querySelector("#txtDireccion");
	direccion.addEventListener('keyup',function(){
		let dir = this.value;
		fntViewPago();
	});
}

if(document.querySelector("#txtCiudad"))
{
	let ciudad = document.querySelector("#txtCiudad");
	ciudad.addEventListener('keyup',function(){
		let ciu = this.value;
		fntViewPago();
	});
}

if(document.querySelector("#condiciones"))
{
	let optCondiciones = document.querySelector("#condiciones");
	optCondiciones.addEventListener('click',function(){
		let opcion = this.checked;
		if(opcion)
		{
			document.querySelector('#optMetodoPago').classList.remove("notBlock");
		}else{
			document.querySelector('#optMetodoPago').classList.add("notBlock");
		}
	});
}

function confirmacionAdopcion(idPersona,idAnimal,idOrganizacionAnimal) {
	divLoading.style.display = "flex";
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
	let ajaxUrl = BaseUrl+'/ProcesoAdopcion/SolicitudAdopcion';
	let formData = new FormData();
	formData.append('idPersona',idPersona);
	formData.append('idAnimal',idAnimal);
	formData.append('idOrganizacionAnimal',idOrganizacionAnimal);
	request.open("POST",ajaxUrl,true);
	request.send(formData);
	request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.estado)
            {    
				swal("¡Proceso exitoso!", objData.msg, "success").then((value) => {

					window.location.href = BaseUrl;
				});
            }else
            {
                swal("¡Error!", objData.msg, "error");
            }
        }
    }

}

function fntViewPago()
{
	let direccion = document.querySelector("#txtDireccion").value;
	let ciudad = document.querySelector("#txtCiudad").value;

	if(direccion == "" || ciudad =="")
	{
		document.querySelector('#divMetodoPago').classList.add("notBlock");
	}else
	{
		document.querySelector('#divMetodoPago').classList.remove("notBlock");
	}
}

if(document.querySelector("#btnComprar")){
	btnPago = document.querySelector("#btnComprar");
	btnPago.addEventListener('click', function(){
		let dir = document.querySelector("#txtDireccion").value;
    	let ciudad = document.querySelector("#txtCiudad").value;
    	let intTipoPago = document.querySelector("#listTipoPago").value;
    	if(txtDireccion == "" || txtCiudad == "" || intTipoPago == "")
    	{
    		swal("","Complete datos de envío.", "error");
    		return;
    	}else{
    		divLoading.style.display = "flex";
    		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
			let ajaxUrl = BaseUrl+'/Tienda/ProcesarVenta';
			let formData = new FormData();
			formData.append('direccion',dir);
			formData.append('ciudad',ciudad);
			formData.append('inttipopago',intTipoPago);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function(){
				if(request.readyState != 4) return;
				if(request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						window.location = BaseUrl+"/tienda/ConfirmarPedido/";
					}else
					{
						swal("", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
				return false;
			}
    	}
	},false);
}


function fntSelectOrg(idOrg)
{
	id = '#selectOrg'+idOrg;
	select = $(id);
	$('.cardOrg').removeClass("border-primary");
	if(select.hasClass("border-primary"))
	{
		select.removeClass("border-primary");
	}
	else
	{
		select.addClass("border-primary");
	}
	
}
