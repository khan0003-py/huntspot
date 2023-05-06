<!doctype html>
<html>

<head>
  <title>Employer Account</title>
  <link rel="icon" href="../img/icon.png" type="image/x-icon">
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

  include 'config.php';

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $eid = $_SESSION['id'];
  }


  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['redirect'] = "employerAccount";
    header("location: emprlogin.php");
  } else {
    include "common/headeremployer.php";
  }

  ?>

  <h1 class="text-3xl font-bold text-center text-gray-500 mt-48">Posted Jobs</h1>

  <div class="flex justify-center mt-20">
    <div class="w-full lg:w-3/4 xl:w-2/3">
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 bg-fixed">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-center">
            <tr>
              <th scope="col" class="px-6 py-3">
                Post Id
              </th>
              <th scope="col" class="px-6 py-3">
                Title
              </th>
              <th scope="col" class="px-6 py-3">
                Description
              </th>
              <th scope="col" class="px-6 py-3">
                Min Experience
              </th>
              <th scope="col" class="px-6 py-3">
                Salary
              </th>
              <th scope="col" class="px-6 py-3">
                Status
              </th>
              <th scope="col" class="px-6 py-3">
                Update
              </th>
              <th scope="col" class="px-6 py-3">
                Delete
              </th>
            </tr>
          </thead>
          <tbody>

            <?php
            $sql = "select * from post where eid = $eid ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $title = $row['name'];
                $category = $row['category'];
                $minexp = $row['minexp'];
                $salary = $row['salary'];
                $industry = $row['industry'];
                $desc = $row['desc'];
                $role = $row['role'];
                $status = $row['status'];

            ?>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                  <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $id; ?>
                  </td>
                  <td class="px-6 py-4">
                    <?php echo $title; ?>
                  </td>
                  <td class="px-6 py-4">
                    <?php echo $desc; ?>
                  </td>
                  <td class="px-6 py-4">
                    <?php echo $minexp; ?>
                  </td>
                  <td class="px-6 py-4">
                    <?php echo $salary; ?>
                  </td>
                  <td class="px-6 py-4">
                    <?php echo $status; ?>
                  </td>
                  <td class="px-6 py-4">
                    <a href="postjob.php?update=true&id=<?php echo $id; ?>" class="font-medium text-gray-400 hover:underline"><i class="fas fa-pencil-alt"></i></a>
                  </td>
                  <td class="px-6 py-4">
                    <a href="deletePost.php?id=<?php echo $id; ?>" class="font-medium text-gray-400 hover:underline"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
            <?php
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>

</html>