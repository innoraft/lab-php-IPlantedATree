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
        		$('#description').html(description);
        		$('#friends').val('');
        		tagged_friends  += ',' + ($(this).attr('id'));
        		this.remove();
      		}
    	})
  	});

  	$("input[type='submit']").on("click", function(event){
        	$('#tagged_friends').val(tagged_friends);
  	});
});