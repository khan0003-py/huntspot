<?php
//This script will handle login
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}


$flag = 1;

// check if the user is already logged in
if (isset($_SESSION['name'])) {
  header("location: employerAccount.php");
}

require_once "config.php";

$name = $email = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (empty(trim($_POST['name'])) && empty(trim($_POST['password']))) {
    $err = "Please enter name + password";
  } else {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
  }

  if (empty($err)) {
    $sql = "SELECT id, name, email, password FROM employer WHERE name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_name);
    $param_name = $name;


    // Try to execute this statement
    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_store_result($stmt);
      if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password);
        if (mysqli_stmt_fetch($stmt)) {
          if (password_verify($password, $hashed_password)) {
            // this means the password is correct. Allow user to login
            session_start();
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            $_SESSION["id"] = $id;
            $_SESSION["loggedin"] = true;

            if ($_SESSION['redirect']) {
              header("location: " . $_SESSION['redirect'] . ".php");
            } else {
              //Redirect user to index page
              header("location: employerAccount.php");
            }
          } else {

            $flag = "password_err";
          }
        }
      } else {
        $flag = "name_err";
      }
    }
  }
}
?>

<!doctype html>
<html>

<head>
  <title>Login</title>
  <link rel="icon" href="../img/icon.png" type="image/x-icon">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/dist/style.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            clifford: '#da373d',
          }
        }
      }
    }
  </script>
  <style type="text/tailwindcss">
    @layer utilities {
      .content-auto {
        content-visibility: auto;
      }
    }
  </style>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>

<body class="bg-gray-900">

  <?php include "common/header.php"; ?>

  <?php
  if ($flag == "password_err") {

    echo '<div id="alert-2" class="mt-20 flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <span class="sr-only">Info</span>
    <div class="ml-3 text-sm font-medium">
    <strong class="font-bold">Error!! </strong>Please Enter Correct Password. <a href="emprlogin.php" class="font-semibold underline hover:no-underline">Try Again</a>
    </div>
    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
  </div>';

  } elseif ($flag == "name_err") {

    echo '<div id="alert-2" class="mt-20 flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <span class="sr-only">Info</span>
    <div class="ml-3 text-sm font-medium">
    <strong class="font-bold">Error!! </strong>User not found. <a href="emprlogin.php" class="font-semibold underline hover:no-underline">Try Again</a>
    </div>
    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
  </div>';
  }
  ?>

  <div class="flex items-center min-h-screen mt-20">
    <div class="flex-1 h-full max-w-4xl mx-auto bg-white rounded-lg shadow-xl">
      <div class="flex flex-col md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
          <img class="object-cover w-full h-full"
            src="https://source.unsplash.com/500x600/?jobfinder,login,jobseeker,jobs" alt="Loading..." />
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 bg-gray-800">
          <div class="w-full">
            <!-- <div class="flex justify-center">
                            <img src="img/logo.png" class="w-20 h-15">
                        </div> -->
            <h1 class="mb-4 text-2xl font-bold text-center text-white">
              Login
            </h1>
            <form action="emprlogin.php" method="post">
              <div class="mt-4">
                <label for="id_name"
                  class="block mb-2 text-sm font-medium text-white">Username</label>
                <input type="text" name="name" id="id_name"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Username" required="">
              </div>
              <div class="mt-4">
                <label for="id_password"
                  class="block mb-2 text-sm font-medium text-white">Password</label>
                <input type="password" name="password" id="id_password"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="********" required="">
              </div>

              <input type="submit" value="Login"
                class="ml-1 w-40 px-4 py-2 mt-6 text-sm font-medium leading-5  border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:bg-gray-900 text-white dark:border-gray-700  dark:focus:ring-gray-800 hover:text-gray-900">
              <input type="Reset"
                class="ml-5 w-40 px-4 py-2 mt-6 text-sm font-medium leading-5 text-center  border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:bg-gray-900 text-white dark:border-gray-700  dark:focus:ring-gray-800 hover:text-gray-900">
            </form>

            <div class="mt-4 text-center text-white">
              <p class="text-sm">Don't have an account ? <a href="emprsignup.php" class="hover:underline"> <strong>Sign
                    Up</strong> </a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'common/footer.php'; ?>

</body>

</html>