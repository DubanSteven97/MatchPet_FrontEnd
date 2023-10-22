function ControlTag(e)
{
	tecla = (document.all) ? e.keyCode : e.which;
	if(tecla == 8 || tecla == 0 || tecla == 9) return true;
	patron = /[0-9\s]/;
	n = String.fromCharCode(tecla);
	return patron.test(n);
}

function TestText(txtString)
{
	var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
	return stringText.test(txtString);
}

function TestEntero(intCant)
{
	var intCantidad = new RegExp(/^[0-9]*$/);
	return intCantidad.test(intCant);
}

function TestEmail(email) 
{
	var stringEmail = new RegExp(/^[a-zA-Z0-9_.+-]+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
	return stringEmail.test(email);
}

function fntValidText(){
	let validText = document.querySelectorAll(".validText");
	validText.forEach(function(validText){
		validText.addEventListener('keyup',function(){
			let inputValue = this.value;
			if(!TestText(inputValue))
			{
				this.classList.add('is-invalid');
			}else
			{
				this.classList.remove('is-invalid');
			}
		});
	});
}

function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
	validNumber.forEach(function(validNumber){
		validNumber.addEventListener('keyup',function(){
			let inputValue = this.value;
			if(!TestEntero(inputValue))
			{
				this.classList.add('is-invalid');
			}else
			{
				this.classList.remove('is-invalid');
			}
		});
	});
}

function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
	validEmail.forEach(function(validEmail){
		validEmail.addEventListener('keyup',function(){
			let inputValue = this.value;
			if(!TestEmail(inputValue))
			{
				this.classList.add('is-invalid');
			}else
			{
				this.classList.remove('is-invalid');
			}
		});
	});
}

window.addEventListener('load',function(){
	fntValidText();
	fntValidNumber();
	fntValidEmail();
},false);