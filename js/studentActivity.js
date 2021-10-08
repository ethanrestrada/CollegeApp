let idCatedra = document.getElementById('idCatedra').value;

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../homework/studentsWork.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          document.querySelector('.main__activities').innerHTML = data;
        }
    } 
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("clase="+idCatedra);
}, 1500);