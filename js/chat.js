if(window.history.replaceState){
  window.history.replaceState(null, null, window.location.href);
}

let searchBox = document.querySelector('.search-user-container');
let searchInput = document.getElementById('searchUser');
let searchIcon = document.querySelector('.search-user button');
let usersList = document.querySelectorAll('#userslist');
let inputIdChat = document.getElementById('idChat');
let idUser = document.getElementById('idUser');

function searchUser(){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./search.php", true);
  xhr.onload = ()=>{
  if(xhr.readyState === XMLHttpRequest.DONE){
    if(xhr.status === 200){
      let data = xhr.response;
      usersList[0].innerHTML = data; 
    }
  }
}
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("query=" + searchInput.value);
}

var instances = OverlayScrollbars(document.querySelectorAll("#users"), {
	className: "os-theme-dark",
  scrollbars : {
    autoHide: "leave"
  }
}); 

document.querySelector('.new-chat').addEventListener('click', function(){
  searchBox.classList.add('active');
  if(searchBox.classList.contains('active')) {
    localStorage.setItem('user-search', 'true');
  }else{
    localStorage.setItem('user-search', 'false');
  }
});

if(localStorage.getItem('user-search') == 'true'){
  searchBox.classList.add('active')
}else{ 
  searchBox.classList.remove('active')
} 

searchInput.addEventListener('keyup', function(){
  if(searchInput.value != "") {
    searchIcon.classList.add('active'); 
    searchUser();
  }else{
    searchIcon.classList.remove('active');
    searchUser();
  } 
})

searchIcon.addEventListener('click', function(){
  if(searchIcon.classList.contains('active') == false){
    searchBox.classList.remove('active');
    localStorage.setItem('user-search', 'false');
  }
})

let chatSecMsg = document.querySelector('.chat-section-msg');

usersList.forEach(list=>{
  list.addEventListener('click', function(e){
    if(e.target.classList.contains('user-chat')){
      let idChat = e.target.getAttribute('id');
      inputIdChat.setAttribute('value', `${idChat}`)
      
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "./chatMsg.php", true);
      xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatSecMsg.innerHTML = data;
            
            let formSendMsg = document.getElementById('formMsg');
            let chatInputMsg = document.getElementById('chatMsg');
            let buttonSendMsg = document.getElementById('sendMsg');
            let incomingId = document.getElementById('incoming');

            OverlayScrollbars(document.getElementById('chat'), { 
              className: "os-theme-dark",
              scrollbars : {
                autoHide: "leave"
              }
            }); 

            incomingId.setAttribute('value', `${inputIdChat.value}`);
            formSendMsg.addEventListener('submit', function(e){
              e.preventDefault();
            })

            chatInputMsg.focus(); 
            chatInputMsg.addEventListener('keyup', function(){
              if(chatInputMsg.value != ""){
                buttonSendMsg.classList.add('active')
              }else{
                buttonSendMsg.classList.remove('active')
              }
            })

          buttonSendMsg.addEventListener('click', function(){
            let xhr2 = new XMLHttpRequest();
            xhr2.open("POST", "./insertMsg.php", true);
            xhr2.onload = ()=>{
              if(xhr2.readyState === XMLHttpRequest.DONE){
                if(xhr2.status === 200){
                  chatInputMsg.value = "";
                }
              }
            }
            let formData = new FormData(formSendMsg);
            xhr2.send(formData);
          })
        }
      }
    }
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("idChat=" + inputIdChat.value);
      
      setInterval(() =>{
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./getAllMsg.php", true);
        xhr.onload = ()=>{
          if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
              let data = xhr.response;
              document.querySelector('.chat-box-msg').innerHTML = data;
              }
            }
          }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("incoming=" + inputIdChat.value);
      }, 1000);
      
      if (window.matchMedia("(max-width: 1199px)").matches) {
        document.querySelector('html').scrollLeft = window.innerWidth;
      }
    }
  })
})

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./activeChat.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList[1].innerHTML = data;
          let chatInfo = "";
          if(usersList[1].childElementCount == 0){
            chatInfo = `<div class="chatInfo">
                          <span><i class="fas fa-info-circle"></i></span>
                          <span>¡Vaya! Parece que no has empezado ninguna conversacion.</span>
                        </div>`;
          } else{
            chatInfo = `<div class="chatInfo">
                          <span><i class="fas fa-info-circle"></i></span>
                          <span>¡Selecciona un usuario para seguir conversando!</span>
                        </div>`;
          }
          (chatSecMsg.childElementCount == 0) ? chatSecMsg.innerHTML = chatInfo : chatSecMsg.removeChild = chatInfo;
      }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("idUser=" + idUser.value);
}, 1000);