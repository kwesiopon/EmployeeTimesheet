//simple function to calculate income based off information given 
function calcIncome(){
  var hoursf=$("input#hours").val();
  var ratef=$("input#rate").val();
  var statef = $('#dropdown-item').val();
  if(hoursf==""&&ratef==""){
    alert("Please fill out all fields");
  }else{
  if(hoursf==""){
    alert("Please fill out Hours field");
  }
  if(ratef==""){
    alert("Please fill out Rate field");
  }
}

  var incomef = hoursf*ratef;
   $('span#incomef').text(incomef);
   $('p#income_field').show();
}


function setUp(){
  $('p#income_field').hide();
  $('#submit_pay').click(calcIncome);
}
$(document).ready(setUp);
