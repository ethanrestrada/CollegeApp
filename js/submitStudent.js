setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../homework/submitStudents.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        let data = xhr.response;
        document.querySelector('.main__activities').innerHTML = data;
        if(document.body.contains(document.querySelectorAll('.activities_activity-finished')[0])){
          document.querySelectorAll('.activities_activity-finished')[0].classList.add('first');
        }
      }
    } 
  }
  xhr.send();
}, 1000);