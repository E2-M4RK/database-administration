<?php
include("connect.php");

if (isset($_POST['btnSubmitUser'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $birthDay = $_POST['birthDay'];
  $phoneNumber = $_POST['phoneNumber'];

  
  
  $userQuery = "INSERT INTO users (username, email, phoneNumber) VALUES ('$username', '$email', '$phoneNumber')";
  executeQuery($userQuery);

  $userID = mysqli_insert_id($conn);

  $userinfoQuery = "INSERT INTO userinfo (userID, firstName, lastName, birthDay) VALUES ('$userID', '$firstName', '$lastName', '$birthDay')";
  executeQuery($userinfoQuery);
}

$query = "SELECT * FROM userinfo LEFT JOIN users ON userinfo.userID = users.userID";
$results = executeQuery($query);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Helvetica, Arial, sans-serif; }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg" style="background-color: #1D428A;">
    <div class="container">
      <a class="navbar-brand" href="https://nba.onesports.ph/">
        <img src="Images/NBA-LOGO.png" alt="NBA Logo" width="60" height="54">
      </a>
    </div>
  </nav>

  <div class="container my-5">
    <h2>Add New NBA Player</h2>
    <form method="post" class="row g-3">
      <div class="col-md-6">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
      </div>
      <div class="col-md-6">
        <input type="email" class="form-control" name="email" placeholder="Email" required>
      </div>
      <div class="col-md-6">
        <input type="text" class="form-control" name="firstName" placeholder="First Name" required>
      </div>
      <div class="col-md-6">
        <input type="text" class="form-control" name="lastName" placeholder="Last Name" required>
      </div>
      <div class="col-md-6">
        <input type="date" class="form-control" name="birthDay" placeholder="Birth Date">
      </div>
      <div class="col-md-6">
        <input type="text" class="form-control" name="phoneNumber" placeholder="Phone Number">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary" name="btnSubmitUser">Add Player</button>
      </div>
    </form>
  </div>

  <div class="container">
    <h1 class="display-3">NBA Players</h1>
    <?php 
    if (mysqli_num_rows($results) > 0) {
      while ($userinfo = mysqli_fetch_assoc($results)) { 
    ?>
      <div class="card my-3 p-4 rounded-5">
        <div class="card-header" style="background-image: url('Images/nbaplayers.png'); height: 200px; background-size: cover;">
          <img src="Images/No profile.png" class="rounded-circle" alt="User Profile Picture" style="width: 150px; position: absolute; top: 150px; left: 20px;">
        </div>
        <div class="card-body pt-5" style="margin-top: 10px;">
          <h5 class="card-title"><?php echo $userinfo['firstName'] . " " . $userinfo['lastName']; ?></h5>
          <ul class="nav nav-tabs mt-3">
            <li class="nav-item"><span class="nav-link active">Details</span></li>
            <li class="nav-item"><span class="nav-link">Milestones</span></li>
            <li class="nav-item"><span class="nav-link">Career Stats</span></li>
          </ul>
          <div class="mt-4">
            <h6 class="text-primary">Profile Info</h6>
            <div class="mb-2"><strong>Username:</strong> <span class="ms-2"><?php echo $userinfo['username']; ?></span></div>
            <div class="mb-2"><strong>Email:</strong> <span class="ms-2"><?php echo $userinfo['email']; ?></span></div>
            <div class="mb-2"><strong>Birth Date:</strong> <span class="ms-2"><?php echo $userinfo['birthDay']; ?></span></div>
            <div class="mb-2"><strong>Phone Number:</strong> <span class="ms-2"><?php echo $userinfo['phoneNumber']; ?></span></div>
          </div>
        </div>
      </div>
    <?php 
      }
    } 
    ?>
  </div>

  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-muted">© 2024 NBA, Inc</p>
    <a href="https://nba.onesports.ph/" class="col-md-4 d-flex align-items-center justify-content-center link-dark text-decoration-none">
      <img src="Images/nba logs.png" alt="NBA Logo" width="60" height="52">
    </a>
    <ul class="nav col-md-4 justify-content-end">
      <li class="nav-item"><a href="https://nba.onesports.ph/" class="nav-link px-2 text-muted">Home</a></li>
      <li class="nav-item"><a href="https://nba.onesports.ph/" class="nav-link px-2 text-muted">Features</a></li>
      <li class="nav-item"><a href="https://nba.onesports.ph/" class="nav-link px-2 text-muted">Pricing</a></li>
      <li class="nav-item"><a href="https://nba.onesports.ph/" class="nav-link px-2 text-muted">FAQs</a></li>
      <li class="nav-item"><a href="https://nba.onesports.ph/" class="nav-link px-2 text-muted">About</a></li>
    </ul>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
