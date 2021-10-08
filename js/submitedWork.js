let idTarea = document.getElementById('id_tarea').value;
let idClase = document.getElementById('id_clase').value;
let idGrado = document.getElementById('id_grado').value;

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../homework/submitedWork.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        let data = xhr.response;
        document.querySelector('.students-activity').innerHTML = data;
      }
    } 
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("id_tarea="+idTarea+"&id_clase="+idClase+"&id_grado="+idGrado);
}, 1000);