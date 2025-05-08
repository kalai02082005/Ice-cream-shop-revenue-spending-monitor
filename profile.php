

<?php 
require_once "include/header.php"; 
?>

<div class="container">

  <div class="row">
      <div class="col-4">

      </div>

      <div class="col-4 col-12-md">
      <div class="card shadow">
    <img src="resorce/images/users/1.jpg" class="img-thumbnail"  height="4px" alt="im">
    <div class="card-body">

      <h1 class=" text-center"> <?php  echo ucwords($_SESSION["name"]); ?> </h1>
      <p class="card-text mt-5">Full Name : <?php echo ucwords($_SESSION["name"]); ?></p>
      <p class="card-text">Email: <?php echo $_SESSION["email"]; ?></p>
      <p class="card-text"> Date of Birth : <?php echo date( 'jS F, Y' , strtotime($_SESSION["dob"]) ); ?> </p>

      <div class="text-center"> 
      <a class='btn  btn-primary text-white' href="update-profile.php" >Update Profile </a>
      <a class='btn btn-primary text-white' href="change-pass.php" >Change Password </a>
      </div>

    </div>
  </div>
    </div>

  </div>

</div>

<script>

</script>

<?php 
    require_once "include/footer.php";
?>
<style>
  /* General Styles */
body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
}

.container {
    margin-top: 50px;
}

/* Card Styles */
.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.card.shadow {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card img {
    border-bottom: 2px solid #007bff;
    max-height: 300px;
    object-fit: cover;
}

/* Text Centering */
.text-center {
    text-align: center;
}

/* Button Styles */
.btn-primary {
    background-color: #007bff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    margin: 10px;
    text-decoration: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Profile Text */
.card-text {
    font-size: 16px;
    margin: 10px 0;
}

h1 {
    font-size: 28px;
    margin: 20px 0;
    color: #343a40;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card {
        margin: 0 auto;
        width: 100%;
    }

    .container {
        margin-top: 30px;
        padding: 0 15px;
    }

    h1 {
        font-size: 24px;
    }

    .card-text {
        font-size: 14px;
    }

    .btn-primary {
        font-size: 14px;
        padding: 8px 16px;
    }
}
body{
    background: url(ice5.jpg) no-repeat;
    background-size: cover;
 }

</style>