let usersContainer = document.querySelector('.main__container-users');
let activeBox = document.querySelector('.active-user-back');
let idUser = document.getElementById('id_user');

if(document.body.contains(document.querySelectorAll('.teacher')[0])){
  document.querySelectorAll('.teacher')[0].classList.add('first');
}
if(document.body.contains(document.querySelectorAll('.student')[0])){
  document.querySelectorAll('.student')[0].classList.add('first');
}

usersContainer.addEventListener('click', function(e){
  if(e.target.classList.contains('active-icon')){
    activeBox.classList.add('active');
    getIdUser = e.target.parentNode.getAttribute('id')
    idUser.setAttribute('value', getIdUser)
  }
})

function cancelActive(){
  activeBox.classList.remove('active');
}

function confirmActive(){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../editTable/activeUser.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        activeBox.classList.remove('active');
        location.reload();
      }
    } 
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("id_user="+idUser.value);
}