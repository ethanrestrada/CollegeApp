let uploadFile = document.querySelector('#uploadFile');
let nameUploadFile = document.getElementById('nameUploadFile');
let fileForm = document.querySelector('form');
let idTarea = document.getElementById('idTarea');
let archivo = document.getElementById('archivo');
let result = document.querySelector('.result');

if(window.history.replaceState){
  window.history.replaceState(null, null, window.location.href);
}

fileForm.addEventListener('submit', function(e){
  e.preventDefault();
})

if(!nameUploadFile.classList.contains('entregado')){
  let submitWork = document.getElementById('entregar');

  uploadFile.addEventListener('change', function(){
    nameUploadFile.classList.add('active');
    nameUploadFile.innerHTML = `<div class='uploadFileName'> 
                                  <i class="fas fa-file"></i> ${uploadFile.files[0].name}
                                </div>` + `<i class="far fa-times-circle" id="deleteFile"></i>`;
    document.querySelector('#deleteFile').onclick = function(){
      uploadFile.value = "";
      nameUploadFile.textContent = "";
      nameUploadFile.classList.remove('active');
    }
  })

  if(nameUploadFile.textContent != ''){
    let deleteFile2 = document.getElementById('deleteFile2');

    deleteFile2.onclick = function(){
      nameUploadFile.innerHTML = "";
      nameUploadFile.classList.remove('active');
      archivo.value = "";
    }
  }

  nameUploadFile.addEventListener('DOMSubtreeModified', function(){
    archivo.value = nameUploadFile.textContent;
  })
    
  submitWork.addEventListener('click', function(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../homework/submitWork.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
            let data = xhr.response;
            result.innerHTML = data;
            if(result.childElementCount == 0){
              location.reload();
            }
          }
        }
      }
    let formData = new FormData(fileForm);
    xhr.send(formData);
  })

}else{
  let cancelWork = document.getElementById('undo');
  cancelWork.addEventListener('click', function(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../homework/cancelSubmitWork.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          result.innerHTML = data;
          location.reload();
          }
        }
      }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('idTarea='+idTarea.value);
  })
}
