//---- TARJETA ----//
//Nombre titular
let nameInput = document.querySelector('#cardholder');

nameInput.addEventListener('input', ()=>{
    if(nameInput.value == '')
    {
        document.getElementById('holderError').innerText= 'El campo no puede estar vacio';
    }
    else
    {
        document.getElementById('holderError').innerText= '';
    }

});

//Numero de tarjeta

let cardNumber = document.querySelector('#cardNumber')

cardNumber.addEventListener('input', event=>{

    let inputValue = event.target.value;

    if(cardNumber.value == '')
    {
        document.getElementById('cardNumberError').innerText= 'El campo no puede estar vacio';
    }else
    {
        document.getElementById('cardNumberError').innerText= '';
    }

    let regExp = /[A-z]/g;

    if(regExp.test(cardNumber.value))
    {
        document.getElementById('cardNumberError').innerText= 'El numero de tarjeta no debe poseer letras';
    }else
    {
        cardNumber.value = event.target.value.replace(/\s/g,'').replace(/([0-9]{4})/g,'$1 ').trim();
        document.getElementById('cardNumberError').innerText= '';
    }
});

//Meses
let monthInput = document.querySelector('#cardMonth');
errorMonthDiv = document.querySelector(".form_input-mm--error error")

monthInput.addEventListener('input', ()=>{
    if(monthInput.value < 1 || monthInput.value > 12)
    {
        document.getElementById('monthErrorDiv').innerText = 'Mes incorrecto'
    }
    else
    {
        document.getElementById('monthErrorDiv').innerText = ''
    }
})

let yearInput = document.querySelector('#cardYear')

yearInput.addEventListener('input', ()=>{
    if(yearInput.value < 23 || monthInput.value > 28)
    {
        document.getElementById('yearErrorDiv').innerText = 'Año incorrecto'
    }
    else
    {
        document.getElementById('yearErrorDiv').innerText = ''
    }
})

let cvcInput = document.querySelector('#cardCVC')


cvcInput.addEventListener('input', event=>{

    if(cvcInput.value == '')
    {
        document.getElementById('cvcErrorDiv').innerText= 'El campo no puede estar vacio';
    }else
    {
        document.getElementById('cvcErrorDiv').innerText= '';
    }

    let regExp = /[A-z]/g;

    if(regExp.test(cardNumber.value))
    {
        document.getElementById('cvcErrorDiv').innerText= 'El cvc no debe poseer letras';
    }else
    {
        document.getElementById('cvcErrorDiv').innerText= '';
    }
});

let subButton = document.querySelector('#subForm')


function Enviar(){
    if(!validar())
    {
        swal('Algunos campos estan vacios','Debes rellenar todos los campos', 'error')
    }else{
        swal('Gracias por confiar en nosotros','Estamos trabajando en volverlo realidad', 'success')
    }
}

let Name = document.querySelector('#dnombre');
let direccion = document.querySelector('#direccion')
let Number = document.querySelector('#Number');
let email = document.querySelector('#email')

function validar()
{
    if(Name.value == '') return false;
    if(direccion.value == '') return false;
    if(Number.value == '') return false;
    if(email.value == '') return false;
    if(nameInput.value == '') return false;
    if(cardNumber.value == '') return false;
    if(monthInput.value == '') return false;
    if(yearInput.value == '') return false;
    if(cvcInput.value == '') return false;

    return true;
}