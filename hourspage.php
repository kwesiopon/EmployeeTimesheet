<?php
  ini_set('display_errors', '1');
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  if(isset($_POST['submit'])){
    $conn = new mysqli('localhost','root','','employeeTS');

    if(!$conn){
      die("Connection failed: ". mysqli_connect_error());
    }


    $hours= $_POST['hourPHP'];
    $rate= $_POST['ratePHP'];
    $date= $_POST['datePHP'];
    $user= $_SESSION['email'];
    //prepared statement
    $stmt =$conn->prepare("INSERT INTO Paysheet(`Hours`,`Rate`,`Date`,`Employee_email`) VALUES(?,?,?,?)");
    $stmt->bind_param("idss",$hours,$rate,$date,$user);
    $stmt->execute();

    echo "New record created succesfully.";

    $stmt->close();
    $conn->close();
  }
?>

<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
     integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="">Income Calculator</a>
          <a class="nav-link justify-content-right" href="logout.php">Logout</a>
      </ul>
    </nav>
    <div class="jumbotron justify-content-center">
      <h1 class="text-info justify-content-center">Get Your Income</h1>
    </div>
    <div class="container">
      <div  class="row">
        <div class="col"></div>
        <div class="col-4 justify-content-center">
          <div class="card bg-light">
            <div class="card-header">Input Your Rate and Hours</div>
            <div class="card-body">
              <form method="post" action="tsserver.php">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label"for="hours">Hours</label>
                  <div class ="col-sm-5">
                    <input type="number" min="1" max="24"class="form-control"id="hours" class="form-control " placeholder="Enter Hours"required>
                  </div>

                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label"for="rate">Rate</label>
                  <div class="col-sm-5">
                    <input type="number" step=".01"class="form-control" id="rate"  placeholder="Enter Rate" required >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label"for="date">Date</label>
                  <div class="col-sm-5">
                    <input type="date"class="form-control" id="date" required >
                  </div>
                </div>
                <div class="form-group row">
                  <div class="dropdown">
                    <div class="col-sm-4">
                      <select class="form-control-4">
                        <option value="Wisconsin">Wisconsin</option>
                        <option value="Illinois">Illinois</option>
                      </select>
                    </div>
                  </div>

                </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary" id="submit">Submit Hours</button>
                  </div>
                </div>
              </form>
              <p class="income_field">Your income is $<span id="incomef"></span>.</p>
              <p id="response"></p>
              </div>
            </div>

        </div>
      <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"></script>
      <script type="text/javascript">
        $(document).ready(function(){
          //function to determine total pay-out
          $('#submit_pay').on('click',function(){
            var hoursf=$("#hours").val();
            var ratef=$("#rate").val();
            var datef=$("#date").val();
            var statef = $('#dropdown-item').val();
            //validation check to see if all fields have been filled
            if(hoursf==""&&ratef==""){
              alert("Please fill out all fields");
            }else{
            if(hoursf==""||ratef==""){
                alert("Please fill out required field");
              }}




            //send data off to server
            $.ajax(
              {
                url:"hourspage.php",
                type:"POST",
                data:{
                  submit:1,
                  hourPHP:hoursf,
                  ratePHP:ratef,
                  datePHP:datef
                },
                success: function(response){

                  $('#response').html(response);
                  console.log(data);

                    },
                datatype:"text"
              }
            );
            //calc income so user knows how much they are getting
            var incomef = hoursf*ratef;
            $('span#incomef').text(incomef);
            $('p#income_field').show();


          })
        });
      </script>
    <div class="col"></div>
    </div>
  </div>
  </body>
</html>
