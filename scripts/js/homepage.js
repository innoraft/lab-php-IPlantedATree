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

$(document).ready(function(){
	$('#save').on('click',function(){
		saveContent();
	});
});
/*
var form = document.getElementById('uploadForm');
var formData = new FormData(form);
		console.log(formData.getAll());
		request = $.ajax({
	        url: "saveContent.php",
	        type: "POST",
	        data: formData,
	        contentType: false,
	        cache: false,
	        processData: false
	    });

var formData = new FormData();
formData.append('username', 'Chris');
formData.append('username', 'Bob');
formData.get('username');
*/
function saveContent(){	
		var form = document.getElementById('uploadForm');
		var formData = new FormData(form);
		console.log(form);
		request = $.ajax({
	        url: "saveContent.php",
	        type: "POST",
	        data: formData,
	        contentType: false,
	        cache: false,
	        processData: false
	    });
	    //console.log(request);
	    request.done(function (response, textStatus, jqXHR){
	        // Log a message to the console
	       console.log("Save successful!");
	       console.log(response);
	    });

	    // Callback handler that will be called on failure
	    request.fail(function (jqXHR, textStatus, errorThrown){
	        // Log the error to the console
	        console.error(
	            "The following error occurred: "+
	            textStatus, errorThrown
	        );
	    });
}