<?php
//database credentials
// session_start();
// $servername = "localhost";
// $dbname = "id16978089_iotnow";
// $username = "id16978089_iotnowdb";
// $password = 'xFzN%Gm8X$x4Ds$D';
// $conn = new mysqli($servername, $username, $password, $dbname); // create mysqli connection
// if ($conn->connect_error) { // check whether connection successful
//     die("Connection failed: " . $conn->connect_error); 
// } 
include "connection.php";

// initializing variables
$email    = "";
$errors = array(); 
$password = "";

// REGISTER USER
if (isset($_POST['email'])) {
  // receive all input values from the form
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password)) { array_push($errors, "Password is required"); }

  $password=md5($password);
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  $userId = $user['userId'];

  
  if ($user and count($errors) == 0) { // if user exists
    $_SESSION['userId']=$userId;
    $_SESSION['email']=$email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: ./home/index.php');
  }
  else{
      echo "User doesn't exist";
  }
}
?>