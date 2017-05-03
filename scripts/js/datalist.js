document.querySelector('input[list="taggable_friends"]').addEventListener('input', onInput);
function onInput(e) {
   var input = e.target,
       val = input.value;
       list = input.getAttribute('list'),
       options = document.getElementById(list).childNodes;

  for(var i = 0; i < options.length; i++) {
    if(options[i].innerText === val) {
      // An item was selected from the list!
      // yourCallbackHere()
      //alert('item selected: ' + val);
      var div = document.createElement("div");
  	  //div.setAttribute("id","1");
  	  div.setAttribute("id",val);
      div.setAttribute("style","width:100px;border:1px solid #000;float:left;");
  	  div.setAttribute("onclick","this.remove()");
  	  var t = document.createTextNode(val);
  	  div.appendChild(t);
  	  document.getElementById('selected_friends').appendChild(div);
      break;
    }
  }
}


var form = document.getElementById("myForm");
var str="";
form.onsubmit = function(e){
	var selectedFriendsChildren = document.getElementById("selected_friends").children;
	var noOfChildren = selectedFriendsChildren.length;
	var i = 0;
	var str = "";
	while(i < noOfChildren){
		str = str + selectedFriendsChildren[i].innerHTML;
		i++;
	}
	console.log(str);
	e.preventDefault();
}