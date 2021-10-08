let editStudent = document.querySelectorAll('.edit');
let modifyBox = document.querySelector('.modify-table-back');
let cancelarModify = document.getElementById('cancelarModify');

let userInfo = document.getElementsByName('userInfo');
let userModifyInfo = document.querySelectorAll('#userModifyInfo');

if(window.history.replaceState){
  window.history.replaceState(null, null, window.location.href);
}

editStudent.forEach(buton=>{
  buton.addEventListener('click', function(){
    modifyBox.classList.add('active');

    if(modifyBox.classList.contains('active')){
      localStorage.setItem('table-edit', 'true');
    } else{
      localStorage.setItem('table-edit', 'false');
    }

    idButton = buton.getAttribute('id');
    userInfo.forEach(input=>{        
      if(input.getAttribute('id') == idButton){
        document.getElementById('idUser').value = idButton;
        if(input.getAttribute('class') == 'nombre'){
          userModifyInfo[0].value = input.value;
        }
        if(input.getAttribute('class') == 'apellido'){
          userModifyInfo[1].value = input.value;
        }
        if(input.getAttribute('class') == 'codigo'){
          userModifyInfo[2].value = input.value;
        }
      }
    })
  })
})

if(localStorage.getItem('table-edit') == 'true'){
  modifyBox.classList.add('active')
}else{
  modifyBox.classList.remove('active')
}

cancelarModify.onclick = function(){
  modifyBox.classList.remove('active');
  localStorage.setItem('table-edit', 'false');
}

let deleteBox = document.querySelector('.delete-back');
let deleteStudent = document.querySelectorAll('.delete');
let cancelarDelete = document.getElementById('cancelarDelete');

deleteStudent.forEach(boton=>{
  boton.addEventListener('click', function (){
    deleteBox.classList.add('active');
    idButtonDelete = boton.getAttribute('id');
    document.getElementById('idUserDelete').value = idButtonDelete;
  })
})

cancelarDelete.onclick = function(){
  deleteBox.classList.remove('active');
}

let addUser = document.querySelector('.main__add-user');
let addUserBox = document.querySelector('.add-user-back');
let cancelarAdd = document.getElementById('cancelarAdd');
let inputAdd = document.querySelectorAll('.inputAdd');

addUser.addEventListener('click', function(){
  addUserBox.classList.add('active');
  if(addUserBox.classList.contains('active')){
    localStorage.setItem('addUser', 'true');
  }else{
    localStorage.setItem('addUser', 'false');
  }
})

if(localStorage.getItem('addUser') == 'true'){
  addUserBox.classList.add('active');
}else{
  addUserBox.classList.remove('active');
}

cancelarAdd.onclick = function(){
  addUserBox.classList.remove('active');
  localStorage.setItem('addUser', 'false');
  inputAdd.forEach(input=>{
    input.value = "";
  })
}