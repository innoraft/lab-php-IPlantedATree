$(document).ready(function(){
  console.log("ready");
  $('#tagged_friends').val('');
  var tagged_friends = '';
  $(document).keypress(function(e) {
  if(e.which == 13) {
    e.preventDefault();
  }
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
        console.log(tagged_friends);
        $('#tagged_friends').val(tagged_friends);
      }
    })
  });
});
