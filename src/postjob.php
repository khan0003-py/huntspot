<?php

include 'config.php';

$id = 0;
$name = $category = $minexp = $salary = $industry = $desc = $role = $employmentType = $status = $msg = "";

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  $eid = $_SESSION['id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['update']) && isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql = "select * from post where eid=$eid and id=$id";
      $result = $conn->query($sql);
      if ($row = $result->fetch_assoc()) {
          $name = $row['name'];
          $category = $row['category'];
          $minexp = $row['minexp'];
          $salary = $row['salary'];
          $industry = $row['industry'];
          $desc = $row['desc'];
          $role = $row['role'];
          $employmentType = $row['employmentType'];
          $status = $row['status'];
      }
  }

  if (isset($_POST['submitPost'])) {

      $id = $_POST['id'];
      $name = $_POST['name'];
      $category = $_POST['category'];
      $minexp = $_POST['minexp'];
      $salary = $_POST['salary'];
      $industry = $_POST['industry'];
      $desc = $_POST['desc'];
      $role = $_POST['role'];
      $employmentType = $_POST['employmentType'];
      $status = $_POST['status'];

      if ($id > 0) {
        $sql = "UPDATE `post` SET `date`=CURRENT_DATE(),"
        . "`name`='$name', "
        . "`category`='$category', "
        . "`minexp`='$minexp', "
        . "`desc`='$desc', "
        . "`salary`='$salary', "
        . "`industry`='$industry', "
        . "`role`='$role', "
        . "`employmentType`='$employmentType', "
        . "`status`= '$status' "
        . "WHERE `id`='$id' AND `eid`='$eid';";
              $alert2 = "Updated";
      } else {
          $sql = "INSERT INTO `post` (`id`, `date`, `eid`, `name`, `category`, `minexp`, `desc`, `salary`, `industry`, `role`, `employmentType`, `status`) "
              . "VALUES (NULL, CURRENT_DATE(), '$eid', '$name', '$category', '$minexp', '$desc', '$salary', '$industry', '$role', '$employmentType', '$status');";
              $alert1 = "Created";
      }

  if ($conn->query($sql) === TRUE) {
    if(isset($alert1)){
      $err1 = "New record created successfully";
    }
    else{
      $err2 = "Update record successfully";
    }
  } else {
    $err3 = "Error something went wrong";
  }

  $conn->close();
}
}
?>

<!doctype html>
<html>

<head>
  <title>Post Job</title>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body class="bg-gray-900">

  <?php

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }


  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    include "common/header.php";
  } else {
    include "common/headeremployer.php";
  }

  if (isset($err1)) {
    echo '<div id="alert-3" class="mt-20 flex p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <span class="sr-only">Info</span>
    <div class="ml-3 text-sm font-medium">
    Success!! New record created successfully.
    </div>
    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
  </div>';
  } elseif (isset($err2)) {
    echo '<div id="alert-3" class="mt-20 flex p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <span class="sr-only">Info</span>
    <div class="ml-3 text-sm font-medium">
    Success!! Record updated successfully.
    </div>
    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
  </div>';
  }
  elseif(isset($err3)){

    echo '<div id="alert-2" class="mt-20 flex p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <span class="sr-only">Info</span>
    <div class="ml-3 text-sm font-medium">
    Error!! something went wrong<a href="postjob.php" class="font-semibold underline hover:no-underline">, Try again</a>.
    </div>
    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
  </div>';

  }

  ?>

  <div class="container bg-gray-900 mx-auto px-4 py-16 mt-20">
    <form action="postjob.php" class="bg-gray-800 rounded-lg p-8 max-w-2xl mx-auto" method="post">
    <input type='hidden' value="<?php echo $id; ?>" name='id' />
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="job-title">Job Title</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name" type="text" placeholder="Job Title" value="<?php echo $name; ?>" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="job-category">Job Category</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="category" type="text" placeholder="Job Category" value="<?php echo $category; ?>" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="minimum-experience">Minimum Experience</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="minexp" type="text" placeholder="Minimum Experience" value="<?php echo $minexp; ?>" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="salary-budget">Salary Budget</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="salary" type="text" placeholder="Salary Budget" value="<?php echo $salary; ?>" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="job-industry">Job Industry</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="industry" type="text" placeholder="Job Industry" value="<?php echo $industry; ?>" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="job-requirements">Job Requirements</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="desc" placeholder="Job Requirements" value="<?php echo $desc; ?>" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="role">Role</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="role" type="text" placeholder="Role" value="<?php echo $role; ?>" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="employment-type">Employment Type</label>
        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="employmentType" required>
          <option disabled selected>Select Employment Type</option>
          <option value="permanent">Permanent</option>
          <option value="part-time">Part-time</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block text-gray-100 text-sm font-awesome mb-2" for="status">Status</label>
        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="status" required>
          <option disabled selected>Select Status</option>
          <option value="open">Open</option>
          <option value="close">Close</option>
        </select>
      </div>
      <div class="flex items-center justify-between">
        <button class="mt-4 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="submitPost">
          Submit
        </button>
      </div>
    </form>
  </div>

  <?php

  include "common/footer.php";

  ?>

</body>

</html>