$(document).ready(function(){

  //load recently added games when user clicks the view_games.php link
  $("#gameForm").submit();

//Handles admin editing walkthroughs for each game
$('button').click(function(){
  var button_class = $(this).attr('class').split(' ')[2];//get class name from the multiple class names in the button
  var parent_form = $(this).closest("form").attr('id');//get the parent form id so we can get its children
  if(parent_form != undefined){
      if(parent_form.includes('walkthroughForm')){//if it is a walkthrough form denoted by required id, we proceed
          var id = parent_form.split('_')[1];//get id integer
          
          if(button_class == "submitBtn"){//user wants to submit walkthrough
              submitWalkthrough(id);
          }else if(button_class == "editBtn"){//user wants to edit walkthrough
                editWalkthrough(id);
          }else{
            return;
          }
      }
    
  }
  
});

//admin wants to submit a new game in the admin panel
$('#game_add_submit_btn').click(function(){
  submitNewGameForm();
});


function editWalkthrough(id){
  //remove readonly restriction in the description box so admin can edit
  document.getElementById('description'+id).readOnly = false;
}

//to prevent page from reloading, we will use ajax to submit the walkthrough
function submitWalkthrough(id){
   var title = $('#title'+id).val();
   var text = $('#description'+id).val();

  var val = {
            'walkthrough_id':id,
            'title':title,
            'text':text
            };
      
      //post form to database
      $.ajax({
      url:"./submit_walkthrough_form.php",
      type:"POST",
      data:val,
      success:function(data){
        $('#description'+id).val(data);//after submit form, place post result into description box
      }

  });
}

function submitNewGameForm(){
 
  var genreArray = [];
  var consoleArray = [];

 //since both the genre and console section have multiple selections, we must take all the selections(separately of course)
 // and transfer to an array
  $('#genreUL').each(function() { genreArray.push($(this).text().replace(/[\u00D7]/g,',')) });
  $('#consoleUL').each(function() {consoleArray.push($(this).text().replace(/[\u00D7]/g,',')) });
 
 //convert array to string separated by commas for each list
  var genreList = genreArray.join(",");
  var consoleList = consoleArray.join(",");

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
            $ ('#addGameForm').trigger("reset");
         
         }else{
              alert("Error: check data fields for errors");
         }
        }

    });
}
/*--------------dealing with adding multiple game genres or multiple consoles-----------*/

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
/*-------------------------END of select multiple genres-------------*/

});