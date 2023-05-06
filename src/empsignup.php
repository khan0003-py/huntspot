<?php
require_once "config.php";

$name = $email = $password = $confirm_password = "";
$name_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if name is empty
    if(empty(trim($_POST["name"]))){
        $name_err = "name cannot be blank";
    }
    else{
        $sql = "SELECT id FROM seeker WHERE name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_name);

            // Set the value of param name
            $param_name = trim($_POST['name']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    header("location: signupfailed.php");
                    $name_err = "This name is already taken"; 
                }
                else{
                    $name = trim($_POST['name']);
                }
            }
            else{
                header("location: signupfailed.php");
            }
        }
    }

    mysqli_stmt_close($stmt);

//check for email address field

if(empty(trim($_POST['email']))){
  $email_err = "Email cannot be blank";
}

else{
  $sql = "SELECT id FROM seeker WHERE email = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if($stmt)
  {
      mysqli_stmt_bind_param($stmt, "s", $param_email);

      // Set the value of param name
      $param_email = trim($_POST['email']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1)
          {
              header("location: signup_failed.php");
              $email_err = "This email is already taken"; 
          }
          else{
              $email = trim($_POST['email']);
          }
      }
      else{
          header("location: signup_failed.php");
      }
  }
}

mysqli_stmt_close($stmt);

// Check for password fields

if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field

if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($name_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err))
{
    $param_qualification = $_POST['qualification'];
    $param_dob = $_POST['dob'];
    $param_skills = $_POST['skills'];
    $sql = "INSERT INTO seeker (name, email, password, qualification, dob, skills) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_email ,$param_password, $param_qualification, $param_dob, $param_skills);

        // Set these parameters
        $param_name = $name;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
          
            header("location: emplogin.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>
<!doctype html>
<html>

<head>
<title>SignUp</title>
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

<body class="bg-zinc-100">

  <?php include "common/header.php"; ?>

  <?php if($password_err != ""){
        echo ' <div id="alert-2" class="flex p-4 bg-red-100 dark:bg-red-200 mt-16" role="alert">
        <svg class="flex-shrink-0 w-5 h-5 text-red-700 dark:text-red-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <div class="ml-3 text-sm font-medium text-red-700 dark:text-red-800">
          <strong class="font-bold">Error!! </strong>Something went wrong!!. <a href="emplogin.php" class="font-semibold underline hover:text-red-800 dark:hover:text-red-900">Try Again</a>.
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300" data-dismiss-target="#alert-2" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </div>';
    } ?>
  

  <div class="flex items-center min-h-screen mt-20">
    <div class="flex-1 h-full max-w-4xl mx-auto bg-white rounded-lg shadow-xl">
      <div class="flex flex-col md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
          <img class="object-cover w-full h-full"
            src="https://source.unsplash.com/500x600/?jobfinder,signup,jobseeker,jobs" alt="Loading..." />
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 bg-gray-800">
          <div class="w-full">
            <h1 class="mb-4 text-2xl font-bold text-center text-white">
              Register
            </h1>
            <form action="empsignup.php" method="post">
            <div class="mt-4">
                <input type="text"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Username" name="name" id="id_name" required />
              </div>
              <div class="mt-4">
                <input type="email"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Email Id" name="email" id="id_email" required />
              </div>
              <div class="mt-4">
                <input
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Qualification" type="text" name="qualification" id="id_qualification"
                  required />
              </div>
              <div class="mt-4">
                <input
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Skills" type="text" name="skills" id="id_skills"
                  required />
              </div>
              <div class="mt-4">
                <input
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Date of Birth" type="date" name="dob" id="id_dob"
                  required />
              </div>
              <div class="mt-4">
                <input
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="password" type="password" name="password" id="id_password" required />
              </div>
              <div class="mt-4">
                <input
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Confirm password" type="password" name="confirm_password" id="confirm_password"
                  required />
              </div>
              <input type="submit" value="Register"
                class="ml-1 w-40 px-4 py-2 mt-6 text-sm font-medium leading-5 text-center  border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:bg-gray-900 text-white dark:border-gray-700  dark:focus:ring-gray-800 hover:text-gray-900">
              <input type="Reset"
                class="ml-5 w-40 px-4 py-2 mt-6 text-sm font-medium leading-5 text-center  border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:bg-gray-900 text-white dark:border-gray-700  dark:focus:ring-gray-800 hover:text-gray-900">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'common/footer.php'; ?>

</body>

</html>