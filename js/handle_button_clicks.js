$(document).ready(function(){
//Handles admin editing walkthroughs for each game
$('#editWalthroughBtn').click(function(){
  document.getElementById('WalkthroughDescription').readOnly = false;
   document.getElementById('walkthroughTitle').readOnly = false;
});

//admin wants to submit a new game in the admin panel
$('#game_add_submit_btn').click(function(){
  submitNewGameForm();
});


function submitNewGameForm(){

  //check if fields are empty

     
  var genreArray = [];
  var consoleArray = [];

 //since both the genre and console section have multiple selections, we must take all the selections(separately of course)
 // and transfer to an array
  $('#genreUL').each(function() { genreArray.push($(this).text().replace(/[\u00D7]/g,',')) });
  $('#consoleUL').each(function() {consoleArray.push($(this).text().replace(/[\u00D7]/g,',')) });
 
 //convert array to string separated by commas for each list
  var genreList = genreArray.join(",");
  var consoleList = consoleArray.join(",");
   
   //validate all input fields
   if($("#game_add_title").val().trim().length == 0||
     $("#game_add_desc").val().trim().length == 0 ||
     genreList.trim().length == 0 ||
     consoleList.trim().length == 0){
     alert('please fill all fields');
    return;
  }

  //set values
    var val = {
              "game_title":$("#game_add_title").val(),
              "date_released":$("#game_add_date").val(),
              "consoles":consoleList,
              "genres":genreList,
              "description":$("#game_add_desc").val()
              };
   //post data
    $.ajax({
        url:"./submit_new_game.php",
        type:"POST",
        data:val,
        success:function(data){
         if(data == "success"){//clear form if game was successful added,display message and clear form
            alert("game was successfully added");
            //$ ('#addGameForm').trigger("reset");
            location.reload();
         
         }else{
              alert("Error: check data fields for errors");
         }
        }

    });
}

/******************************dealing with adding multiple game genres or multiple consoles********************/

 $('.console').click(function(){
  listElements('console');
});

$('.genre').click(function(){
  listElements('genre');
});

var myNodelist = document.getElementsByTagName("DT");
var i;
for (i = 0; i < myNodelist.length; i++) {
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  myNodelist[i].appendChild(span);
}

// Click on a close button to hide the current list item
var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}



function listElements(btnId){
	var li = document.createElement("DT");
  var inputValue = document.getElementById(btnId+"List").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  
    document.getElementById(btnId+"UL").appendChild(li);
  
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }
}
/***************************END of select multiple genres********************/

/**********************Forum button clicks***********************************/
/*$('#createThreadBtn').click(function(){
   // $('threadDiv').show();
   alert('hello');
  });*/

});