const inputs = document.querySelectorAll('#input');

if(window.history.replaceState){
  window.history.replaceState(null, null, window.location.href);
}

inputs.forEach(input => {

  input.addEventListener('focus', function() {
    let inputText = this.parentNode.parentNode;
    inputText.classList.add('focus');
  });


  input.addEventListener('blur', function() {
    let inputText = this.parentNode.parentNode;
    if(this.value == ""){
      inputText.classList.remove('focus');
    }
  }); 
});