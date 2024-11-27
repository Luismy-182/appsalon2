

let paso=1;
let pasoInicial=1;
let pasoFinal=3;

const cita={
    id:'',
    nombre:'',
    fecha:'',
    hora:'',
    servicios:[]
}
document.addEventListener('DOMContentLoaded', ()=>{
    iniciarApp();
    mostrarSeccion();
    
});


function iniciarApp(){
    tabs(); //cambia la seccion cuando se presionen los tabs
    botonesPaginador();
    paginaSiguiente();
    paginaAnterior();
    consultarAPI();
    nombreCliente();
    idCliente();
    seleccionarFecha();
    seleccionarHora();

}


function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton =>{
        boton.addEventListener('click', (e)=> {
           paso=parseInt(e.target.dataset.paso); 
            mostrarSeccion();//no le interesa mandar ningun numero, solo llegamos asta ahi, para saber a que le dimnos click y disparar una funcion
            botonesPaginador();
            
            if(paso ===3){
                mostrarResumen();
            }
        } )
    })
    
}


function mostrarSeccion(){
    //eliminando la seccion anterion
    const seccionAnterior= document.querySelector('.mostrar');

    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }



    //seleccional la seccion con el paso...
    const pasoSelector=`#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');


    //quitar la clase actual del tab anterior
    const tabAnterior= document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    //resalta el tab actual
    const tab= document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}


function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    
    
   if(paso===1){
    paginaAnterior.classList.add('ocultar');
    paginaSiguiente.classList.remove('ocultar');
  
  
   }else if(paso===3){
    paginaSiguiente.classList.add('ocultar');
    paginaAnterior.classList.remove('ocultar');
   }else{
    paginaSiguiente.classList.remove('ocultar');
    paginaAnterior.classList.remove('ocultar');
   }

    mostrarSeccion();

}



function paginaAnterior(){
    const paginaAnterior= document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', ()=>{
        if(paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}
function paginaSiguiente(){
    const paginaSiguiente= document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', ()=>{
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
        mostrarResumen();
    });
}



async function consultarAPI(){
    try {
        const url='/api/servicios';

        const respuesta = await fetch(url);
        const resultado=  await respuesta.json();
        mostrarServicios(resultado);
        
        
        
    } catch (error) {
        console.log(error);
        
    }
}


function mostrarServicios(servicios){
  
    servicios.forEach(servicio =>{
        const {id, nombre, precio} = servicio;
        
        const nombreServicio= document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent=nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent=`$ ${precio}`;

        const servicioDiv=document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.onclick=function(){
            seleccionarServicio(servicio);
        };
        
        //para establecer una etiqueta personalizada en Js se usa un dataset. y el nombre de la etiqueta = valor
        servicioDiv.dataset.idServicio=id;


        const listadoServicios= document.querySelector('.listado-servicios');
        listadoServicios.appendChild(servicioDiv);
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        
    });    
}



function seleccionarServicio(servicio){
    //llamando al arreglo de servicios que esta en la cita 

    /*Basicamente. extrae el arreglo del objeto cita, accede al arreglo de servicios
    toma una copia de servicios que hay en memoria y le agrega el servicio nuevo que seleccionamos
     */
    const {id}= servicio;
    const {servicios}=cita;
    const divServicio=document.querySelector(`[data-id-servicio="${id}"]`);

   //comprobar si un servicio ya fue agregado

   if(servicios.some(agregado =>agregado.id === id)){
    //eliminarlo si los servicios del objeto cita coinciden con los id del servicio de la bd 
    //creamos otro arreglo con filter, y agregamos a los que no coincidan con los id  de servicios y el objeto cita
      
           
        cita.servicios=servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
   }else{
    //si no hay coincidencias lo agregamos

        cita.servicios=[...servicios, servicio];
        divServicio.classList.add('seleccionado');
   }
    
  
   


   

    
}
    
function nombreCliente(){
    const nombre = document.querySelector('#nombre').value;
    //lo que en html es una etiqueta, en JS es un objeto y se puede acceder con .
    // <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre;?>" disabled>
    cita.nombre=nombre;   
}

function idCliente(){
   
    //lo que en html es una etiqueta, en JS es un objeto y se puede acceder con .
    // <input type="text" id="id" value="<?php echo $id;?>" disabled>
    cita.id=document.querySelector('#id').value; 
}

function seleccionarFecha(){
    const inputFecha= document.querySelector('#fecha');
    inputFecha.addEventListener('input', (e)=>{
        const dia = new Date(e.target.value).getUTCDay(); // te regresa el numero de dia 0=domingo

        if([6, 0].includes(dia) ){
            mostrarAlerta('Sabados y domingos no abrimos', 'error', '.formulario');
        }else{
            cita.fecha=e.target.value; 

        
        }
        
    })

}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value;
        const hora= horaCita.split(":")[0]; //dividimos el formato Hora en 2 y tomamos = que es hora

        if(hora<10 || hora >18){
            e.target.value='';
            mostrarAlerta('Hora No Valida','error', '.formulario');

        }else{
            cita.hora= e.target.value;

            
            
      
            
        }
    })
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true){
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    };

    const alerta = document.createElement('P');
    alerta.textContent=mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
  
}




function mostrarResumen(){
   
    const resumen = document.querySelector('.contenido-resumen');
    limpiarHTML(resumen);
    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        mostrarAlerta('Error faltan datos o no seleccionaste un servicio', 'error', '.contenido-resumen', false);
        return;
    }else{
        //comenzamos con el resumen Paps

       
        //heading resumen de servicio 
        const headingCita= document.createElement('H3');
        headingCita.textContent='Resumen de cita';
        resumen.appendChild(headingCita);
       

        const {nombre, fecha, hora, servicios}=cita
        const nombreCliente=document.createElement('P');
        nombreCliente.innerHTML= `<span>Nombre: </span> ${nombre}`;
        const fechaCita=document.createElement('P');
        fechaCita.innerHTML= `<span>Fecha: </span> ${fecha}`;
        const horaCita=document.createElement('P');
        horaCita.innerHTML= `<span>Hora: </span> ${hora} Horas`;
        resumen.appendChild(nombreCliente);
        resumen.appendChild(fechaCita);
        resumen.appendChild(horaCita);  

     


               //heading resumen de servicio 
        const headingServicios= document.createElement('H3');
        headingServicios.textContent='Resumen de servicios';
        resumen.appendChild(headingServicios);

//crea boton para recervar cita
        const botonResevar = document.createElement('BUTTON');
        botonResevar.classList.add('boton');
        botonResevar.textContent = 'Reservar cita';
        botonResevar.onclick = reservarCita;

    

        servicios.forEach(servicio =>{


         



            const { precio, nombre}=servicio;
            const contenedorServicio=document.createElement('DIV');
            contenedorServicio.classList.add('contenido-servicio');

            const textoServicio = document.createElement('P');
            textoServicio.textContent= nombre;


            const precioServicio= document.createElement('P');
            precioServicio.innerHTML = `<span>Precio: </span> ${precio}`;

            contenedorServicio.appendChild(textoServicio);
            contenedorServicio.appendChild(precioServicio);

            resumen.appendChild(contenedorServicio);
            resumen.appendChild(botonResevar);
        })
    }


}

function limpiarHTML(elemento){
    while(elemento.firstChild){
        elemento.removeChild(elemento.firstChild);
    }

}


//mandando datos al servidor desde fetch APi y form Data
async function reservarCita(){
 
        //extraemos todo el objeto y el arreglo que contiene la cita
     const {id, fecha, hora, servicios}= cita;
     
     //iteramos sobre el arreglo servicios y creamos otro arreglo en idServicios
     const idServicios=servicios.map(servicio=>servicio.id);

    const datos = new FormData();
  
    datos.append('fecha', fecha);
    datos.append('hora', hora); // muy importante las mayusculas, ya que las llaves deben coincidir alas de la bd en la tabla
    datos.append('usuarioId', id); 
    datos.append('servicios', idServicios);
  
    
    try{
    //mandando una peticion a api
    const url='/api/citas';

    const respuesta= await fetch(url, {
        method:'POST',
        body:datos
    })
    const resultado= await respuesta.json();
    console.log(resultado.resultado);
    

    //sweetalert de cita recervada correctamente
    if(resultado.resultado){
      

        Swal.fire({
        title: "Cita creada!",
        text: "Tu cita se creo correctamente :)",
        icon: "success"
        }).then(()=>{
            window.location.reload();
        });




    }   

    }catch(error){
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "ALgo salio mal!",
            footer: '<a href="#">Why do I have this issue?</a>'
          });
        
    }
    
}