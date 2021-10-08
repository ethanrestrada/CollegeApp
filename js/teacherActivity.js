let addCardWork = document.querySelector('.main__add');
let addContainerWork = document.querySelector('.add-activity-back');
let cancelarWork = document.getElementById('cancelar');
let workFile = document.querySelector('#workFile');
let nameFile = document.getElementById('nameFile');

if(window.history.replaceState){
  window.history.replaceState(null, null, window.location.href);
}

addCardWork.onclick = function (){
  addContainerWork.classList.add('active'); 
  if(addContainerWork.classList.contains('active')){
    localStorage.setItem('add-work', 'true');
  } else{
    localStorage.setItem('add-work', 'false');
  }
}

if(localStorage.getItem('add-work') == 'true'){
  addContainerWork.classList.add('active'); 
} else{
  addContainerWork.classList.remove('active'); 
}

if(document.getElementById('workName').value == "" && document.getElementById('workAbout').value == ""){
    let workDate = document.getElementById("workDueto");
    date = new Date();
    let year = date.getFullYear();
    let month = date.getMonth()+1;
    let day = date.getDate();

    (day < 10) ? day = "0"+day : day = day;
    (month < 10) ? month = "0"+month : month = month;
    workDate.value = year+"-"+month+"-"+day;
}

cancelarWork.onclick = function (){
  localStorage.setItem('add-work', 'false');
  addContainerWork.classList.remove('active');
  document.querySelector('#workName').value = "";
  document.querySelector('#workAbout').value = "";
  workFile.value = "";
  nameFile.textContent = "";
}

workFile.addEventListener('change', function(){
  nameFile.innerHTML = `<i class="far fa-times-circle" id="deleteFile"></i>` + workFile.files[0].name;
  document.getElementById('deleteFile').onclick = function (){
    workFile.value = "";
    nameFile.textContent = "";
  }
});

let editActivity = document.querySelectorAll('.editActivity');
let editBox = document.querySelector('.edit-homework-back');
let workInfo = document.getElementsByName('workInfo');
let editWorkInfo = document.querySelectorAll('#editWorkInfo');
let editWorkFile = document.getElementById('editWorkFile'); 

editActivity.forEach(button=>{
  button.addEventListener('click', function(){
    editBox.classList.add('active');
    if(editBox.classList.contains('active')){
      localStorage.setItem('edit-work', 'true');
    } else{
      localStorage.setItem('edit-work', 'false');
    }
    let idButton = button.getAttribute('id');
    workInfo.forEach(input=>{
      if(input.getAttribute('id')==idButton){
        document.getElementById('idWork').value = idButton;
        if(input.getAttribute('class') == 'workTitle'){
          editWorkInfo[0].value = input.value
        }  
        if(input.getAttribute('class') == 'workAbout'){
          editWorkInfo[1].value = input.value
        }
        if(input.getAttribute('class') == 'workDueTo'){
          editWorkInfo[2].value = input.value;
        }
        if(input.getAttribute('class') == 'workFile'){
          if(input.value == 'null'){
            editNameFile.textContent = "";
          } else{
            editNameFile.innerHTML = `<i class="far fa-times-circle" id="editDeleteFile"></i>` + input.value;
            document.getElementById('archivo').value = editNameFile.textContent;
            document.getElementById('editDeleteFile').onclick = function (){
                  editWorkFile.value = "";
                  document.getElementById('editNameFile').textContent = "";
            }
          }
        }
      }
    })
  })
});

if(localStorage.getItem('edit-work') == 'true'){
  editBox.classList.add('active'); 
} else{
  editBox.classList.remove('active'); 
}

editWorkFile.addEventListener('change', function(){
  editNameFile.innerHTML = `<i class="far fa-times-circle" id="editDeleteFile"></i>` + editWorkFile.files[0].name;
  document.getElementById('editDeleteFile').onclick = function (){
    editWorkFile.value = "";
    editNameFile.textContent = "";
  }
});

editNameFile.addEventListener('DOMSubtreeModified', function(){
  document.getElementById('archivo').value = editNameFile.textContent;
})

function cancelEdit(){
  editBox.classList.remove('active');
  localStorage.setItem('edit-work', 'false');
  editWorkFile.value = "";
}

document.querySelectorAll('.dropActivity').forEach(buttom=>{
  buttom.addEventListener('click', function(){
    document.querySelector('.delete-homework-back').classList.add('active');
    document.getElementById('idWorkDelete').value = buttom.getAttribute('id');
  })
})

function cancelDelete(){
  document.querySelector('.delete-homework-back').classList.remove('active');
}