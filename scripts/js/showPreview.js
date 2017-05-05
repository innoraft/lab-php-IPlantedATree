$(document).ready(function(){

	document.getElementById("lbl_tag_friends").style.visibility = "hidden";
	document.getElementById("friends").style.visibility = "hidden";
	

	$('#btn_tag_friends').on("click",function(){
		document.getElementById("lbl_tag_friends").style.visibility = "visible";
		document.getElementById("friends").style.visibility = "visible";
		$(this).hide();
	});

	$('#friends').on('input', function() {
    	var userText = $(this).val();

    	$("#taggable_friends").find("option").each(function() {
      		if ($(this).val() == userText) {
        		var description = $('#description').val();
        		var thisVal = $(this).val();
        		description += "@"+thisVal;
        		$('#description').val(description);
        		$('#friends').val('');
        		tagged_friends  += ',' + ($(this).attr('id'));
        		console.log(tagged_friends);
        		this.remove();
        		//alert("Make Ajax call here.");
      		}
    	})
  	});



  	$("input[type='submit']").on("click", function(event){
    	
    	
        	// console.log(document.getElementById("imagePreview").src);
        	// console.log(document.getElementById("imagePreview").src == "http://treeplant123.com/assets/images/placeholder.jpg");
        	//$('#tagged_friends').html(tagged_friends);
        	$('#tagged_friends').val(tagged_friends);
        	// console.log($('#tagged_friends').val());
        	// alert('OK');

    	
  	});
});