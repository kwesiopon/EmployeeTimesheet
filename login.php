<?php
  session_start();

  //saved session for if user already logged on
  if(isset ($_SESSION['loggedIN'])){
    header('Location:hourspage.php');
    exit();
  }
  if(isset($_POST['login'])){
    $connection = new mysqli('localhost','root','','employeeTS');

    $email = $connection->real_escape_string($_POST['emailPHP']);
    $password = $connection->real_escape_string($_POST['passwordPHP']);
    $hpass = hash('sha1',$password);

    $data = $connection->query("SELECT id FROM Users WHERE email_address='$email'AND password='$hpass'");
    if($data->num_rows > 0){
      $_SESSION['loggedIN']='1';
      $_SESSION['email']=$email;
      exit('Login success');
    }else{
      exit('Please check your inputs!');
    }
  }
?>
<html>
  <head>
    <title>Employee Log In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
     integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <style type="text/css">
        body {
          background: #34A3CA !important;
        }

     </style>
  </head>
  <body>
    <div class="row">
    <div class="col"></div>
    <div class="col-4 justify-content-center">
      <div class="card bg-light">
        <div class="card-body">
      <form method="post" action="login.php">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Email: </label><input class="form-control"type="text" id="email" placeholder="Email"><br>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Password: </label><input class="form-control" type="password" id="password" placeholder="Password"><br>
        </div>
          <input class="btn btn-primary"type="submit" value="Log-in" id="login">
        </form>
      </div>
      </div>
    <p id="response"></p>
    </div>
    <div class="col"></div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      //login code here
      $("#login").click(function () {
        //store email and password info in var
        var email = $("#email").val();
        var passw = $("#password").val();

        //perform validation check for fields
        if(email=="" || passw==""){
          alert('Please fill in required fields');
        }
        else{
          $.ajax(
            {
              url:"login.php",
              method:"POST",
              data:{
                  login:1,
                  emailPHP: email,
                  passwordPHP: passw
              },
              success: function(response){
                $('#response').html(response);

              },
              datatype:"text"
            }
          );
        }

      })
    });
    </script>
    </div>
  </body>
</html>
