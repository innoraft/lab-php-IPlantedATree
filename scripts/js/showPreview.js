$(document).ready(function(){

    $(document).keypress(function(e) {
        if(e.which == 13) {
            e.preventDefault();
        }
    });

	$('#friends').on('input', function() {
    	var userText = $(this).val();
    	$("#taggable_friends").find("option").each(function() {
      		if ($(this).val() == userText) {
        		var description = $('#description').html();
        		var thisVal = $(this).val();
        		description += " @"+thisVal;
                // console.log(description);
        		$('#description').html(description);
        		$('#friends').val('');
        		tagged_friends  += ',' + ($(this).attr('id'));
        		// console.log(tagged_friends);
        		this.remove();
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