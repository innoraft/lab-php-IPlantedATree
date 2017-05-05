$(document).ready(function() {
  
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
        console.log($taggable_friends);
        this.remove();
        //alert("Make Ajax call here.");
      }
    })
  });

  $("input[type='reset']").on("click", function(event){
        event.preventDefault();
        // stops the form from resetting after this function
        $(this).closest('form').get(0).reset();
        // resets the form before continuing the function
        $('#imagePreview').attr('src','assets/images/placeholder.jpg');
        $('#submit').attr('disabled','true');
        // executes after the form has been reset
    });

  $("input[type='submit']").on("click", function(event){
    // stops the form from resetting after this function
    if((document.getElementById("imagePreview").src).includes('placeholder.jpg')){
        alert('You need to select an image first!');
        event.preventDefault();
    }
    // executes after the form has been reset
    else{
        // console.log(document.getElementById("imagePreview").src);
        // console.log(document.getElementById("imagePreview").src == "http://treeplant123.com/assets/images/placeholder.jpg");
        //$('#tagged_friends').html(tagged_friends);
        $('#tagged_friends').val(tagged_friends);
        console.log($('#tagged_friends').val());
        // alert('OK');
    }
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
            
        reader.onload = function (e) {
        $('#imagePreview').attr('src', e.target.result);
        document.getElementById('submit').disabled = false;
      }
            
      reader.readAsDataURL(input.files[0]);
      /*input.files[0].name; //displays the filename*/
    }
  }

  $("#fileToUpload").change(function(){
          readURL(this);
  });

});


