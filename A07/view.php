<?php
include("connect.php");

$userID = $_GET['userID'];

if (isset($_POST['btnEdit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
  $birthDay = mysqli_real_escape_string($conn, $_POST['birthDay']);
  $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);

  $updateUserQuery = "UPDATE users SET username='$username', email='$email', phoneNumber='$phoneNumber' WHERE userID='$userID'";
  executeQuery($updateUserQuery);

  $updateUserInfoQuery = "UPDATE userinfo SET firstName='$firstName', lastName='$lastName', birthDay='$birthDay' WHERE userID='$userID'";
  executeQuery($updateUserInfoQuery);

  header("Location: index.php");
}

$query = "SELECT * FROM userinfo LEFT JOIN users ON userinfo.userID = users.userID WHERE userinfo.userID='$userID'";
$results = executeQuery($query);
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Helvetica, Arial, sans-serif;
    }
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

  <?php
  if (mysqli_num_rows($results) > 0) {
    while ($userinfo = mysqli_fetch_assoc($results)) {
      ?>

      <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 500px;">
          <h2 class="text-center mb-4">Edit NBA Player</h2>
          <form method="post" class="row g-3">
            <div class="col-md-6">
              <input type="text" class="form-control" name="username"
                value="<?php echo htmlspecialchars($userinfo['username']); ?>" placeholder="Username" required>
            </div>
            <div class="col-md-6">
              <input type="email" class="form-control" name="email"
                value="<?php echo htmlspecialchars($userinfo['email']); ?>" placeholder="Email" required>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="firstName"
                value="<?php echo htmlspecialchars($userinfo['firstName']); ?>" placeholder="First Name" required>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="lastName"
                value="<?php echo htmlspecialchars($userinfo['lastName']); ?>" placeholder="Last Name" required>
            </div>
            <div class="col-md-6">
              <input type="date" class="form-control" name="birthDay"
                value="<?php echo htmlspecialchars($userinfo['birthDay']); ?>" placeholder="Birth Date">
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="phoneNumber"
                value="<?php echo htmlspecialchars($userinfo['phoneNumber']); ?>" placeholder="Phone Number">
            </div>
            <div class="col-12 text-start">
              <button type="submit" class="btn btn-primary" name="btnEdit">Save Changes</button>
            </div>
          </form>
        </div>

        <?php
    }
  }
  ?>
  
  </div>

  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-muted">© 2024 NBA, Inc</p>
    <a href="https://nba.onesports.ph/"
      class="col-md-4 d-flex align-items-center justify-content-center link-dark text-decoration-none">
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