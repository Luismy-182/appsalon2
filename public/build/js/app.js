let paso=1,pasoInicial=1,pasoFinal=3;const cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),nombreCliente(),idCliente(),seleccionarFecha(),seleccionarHora()}function tabs(){document.querySelectorAll(".tabs button").forEach((e=>{e.addEventListener("click",(e=>{paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador(),3===paso&&mostrarResumen()}))}))}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");const t=`#paso-${paso}`;document.querySelector(t).classList.add("mostrar");const o=document.querySelector(".actual");o&&o.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function botonesPaginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocultar"),t.classList.remove("ocultar")):3===paso?(t.classList.add("ocultar"),e.classList.remove("ocultar")):(t.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(()=>{paso<=pasoInicial||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(()=>{paso>=pasoFinal||(paso++,botonesPaginador(),mostrarResumen())}))}async function consultarAPI(){try{const e="/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach((e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.classList.add("nombre-servicio"),n.textContent=o;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent=`$ ${a}`;const r=document.createElement("DIV");r.classList.add("servicio"),r.onclick=function(){seleccionarServicio(e)},r.dataset.idServicio=t;document.querySelector(".listado-servicios").appendChild(r),r.appendChild(n),r.appendChild(c)}))}function seleccionarServicio(e){const{id:t}=e,{servicios:o}=cita,a=document.querySelector(`[data-id-servicio="${t}"]`);o.some((e=>e.id===t))?(cita.servicios=o.filter((e=>e.id!==t)),a.classList.remove("seleccionado")):(cita.servicios=[...o,e],a.classList.add("seleccionado"))}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function idCliente(){cita.id=document.querySelector("#id").value}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(e=>{const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?mostrarAlerta("Sabados y domingos no abrimos","error",".formulario"):cita.fecha=e.target.value}))}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<10||t>18?(e.target.value="",mostrarAlerta("Hora No Valida","error",".formulario")):cita.hora=e.target.value}))}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("P");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(o).appendChild(c),a&&setTimeout((()=>{c.remove()}),3e3)}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");if(limpiarHTML(e),Object.values(cita).includes("")||0===cita.servicios.length)mostrarAlerta("Error faltan datos o no seleccionaste un servicio","error",".contenido-resumen",!1);else{const t=document.createElement("H3");t.textContent="Resumen de cita",e.appendChild(t);const{nombre:o,fecha:a,hora:n,servicios:c}=cita,r=document.createElement("P");r.innerHTML=`<span>Nombre: </span> ${o}`;const i=document.createElement("P");i.innerHTML=`<span>Fecha: </span> ${a}`;const s=document.createElement("P");s.innerHTML=`<span>Hora: </span> ${n} Horas`,e.appendChild(r),e.appendChild(i),e.appendChild(s);const d=document.createElement("H3");d.textContent="Resumen de servicios",e.appendChild(d);const l=document.createElement("BUTTON");l.classList.add("boton"),l.textContent="Reservar cita",l.onclick=reservarCita,c.forEach((t=>{const{precio:o,nombre:a}=t,n=document.createElement("DIV");n.classList.add("contenido-servicio");const c=document.createElement("P");c.textContent=a;const r=document.createElement("P");r.innerHTML=`<span>Precio: </span> ${o}`,n.appendChild(c),n.appendChild(r),e.appendChild(n),e.appendChild(l)}))}}function limpiarHTML(e){for(;e.firstChild;)e.removeChild(e.firstChild)}async function reservarCita(){const{id:e,fecha:t,hora:o,servicios:a}=cita,n=a.map((e=>e.id)),c=new FormData;c.append("fecha",t),c.append("hora",o),c.append("usuarioId",e),c.append("servicios",n);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:c}),o=await t.json();console.log(o.resultado),o.resultado&&Swal.fire({title:"Cita creada!",text:"Tu cita se creo correctamente :)",icon:"success"}).then((()=>{window.location.reload()}))}catch(e){Swal.fire({icon:"error",title:"Oops...",text:"ALgo salio mal!",footer:'<a href="#">Why do I have this issue?</a>'})}}document.addEventListener("DOMContentLoaded",(()=>{iniciarApp(),mostrarSeccion()}));