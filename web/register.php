<?php
//database credentials
$servername = "localhost";
$dbname = "id16978089_iotnow";
$username = "id16978089_iotnowdb";
$password = 'xFzN%Gm8X$x4Ds$D';
$conn = new mysqli($servername, $username, $password, $dbname); // create mysqli connection
if ($conn->connect_error) { // check whether connection successful
    die("Connection failed: " . $conn->connect_error); 
} 

// initializing variables
$name = "";
$email    = "";
$errors = array(); 
$password = "";

// REGISTER USER
if (isset($_POST['name'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password)) { array_push($errors, "Password is required"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
      echo "email already exists";
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (name, email, password) 
  			  VALUES('$name', '$email', '$password')";
  	mysqli_query($conn, $query);

    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    $userId = $user['userId'];
    session_start();
    $_SESSION['userId'] = $userId;
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: ../home');
  }
}
?>