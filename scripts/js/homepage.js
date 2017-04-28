function changeBackground1(){
	document.getElementById("backgroundImage").src = "assets/images/plantingtrees10.jpg";
}
function changeBackground2(){
	document.getElementById("backgroundImage").src = "assets/images/treeplant.jpg";
}

$(document).ready(function() {
  $("#btn_plant").click(function() {
  $("#backgroundImage2").toggleClass("transparent");
});
});

function login(){
	window.location = 'login5.php';
}