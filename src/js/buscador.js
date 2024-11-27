document.addEventListener('DOMContentLoaded', ()=>{
    iniciarApp();
});


function iniciarApp(){
    buscarFecha();
}


function buscarFecha(){
    const fechaInput = document.querySelector('#fecha');

    fechaInput.addEventListener('input', function (e){
        fechaSeleccionada= e.target.value;

        window.location = `?fecha=${fechaSeleccionada}` ;
        
    });
}