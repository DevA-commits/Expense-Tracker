var elements = document.getElementsByClassName("light-dark-mode");
// var fullscreen = document.getElementById("fullscreencus");


var myFunction = function() {
  var a  = sessionStorage.getItem('data-layout-mode');
  var value = a;
  console.log(a);

  if(a === 'dark'){
    value = 'light';
  }else{
    value = 'dark';
  }

  sessionStorage.setItem('data-layout-mode', value)

};

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', myFunction, false);
}



