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
