<?php
include 'config.php';
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `users` WHERE `email` = '$email' && `password` = '$password'";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        echo '<script>alert("Login Successful")</script>';
        echo '<script>window.location.href = "./usedash.php"</script>';
        $_SESSION['email'] = $email;
    }else{
        echo '<script>alert("Login Failed")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="Tsc0Z9Vmtv4BD2HdKuD4I68jj51vNjRFpXX7sW30">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Octa Invest | Premier Copy Trading and Investments</title>



   <!-- Google Fonts -->
  <link href="css-2?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="temp/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
        <link href="temp/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="temp/lib/animate/animate.min.css" rel="stylesheet">
        <link href="temp/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
        <link href="temp/lib/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="temp/lib/icofont/icofont.min.css" rel="stylesheet">
        <link href="https://www.realglobalfx.com/temp/lib/jquery/magnific-popup.css" rel="stylesheet">
        <link href="temp/lib/aos/aos.css" rel="stylesheet">
        <link href="temp/lib/venobox/venobox.css" rel="stylesheet">
        <link href="temp/lib/icofont/icofont.min.css" rel="stylesheet">

        <link href="temp/css/frontend_style_blue.css" rel="stylesheet">
        
        <!-- JavaScript Libraries -->
        
        <script src="temp/lib/jquery/jquery.min.js"></script>
        <script src="temp/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="temp/lib/jquery.easing/jquery.easing.min.js"></script>
        <script src="https://www.realglobalfx.com/temp/lib/php-email-form/validate.js"></script>
        <script src="temp/lib/waypoints/jquery.waypoints.min.js"></script>
        <script src="temp/lib/counterup/counterup.min.js"></script>
        <script src="temp/lib/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="temp/lib/venobox/venobox.min.js"></script>
        <script src="temp/lib/owl.carousel/owl.carousel.min.js"></script>
        <script src="temp/lib/aos/aos.js"></script>

        <!-- Template Main Javascript File -->
        <script src="temp/js/main.js"></script>

</head>
<body class="d-flex flex-column h-100 auth-page">
    <!-- ======= Loginup Section ======= -->
    <section class="auth">
        <div class="container">
            <div class="row justify-content-center user-auth">
                <div class="col-12 col-md-6 col-lg-6 col-sm-10 col-xl-6 ">
                    <div class="text-center mb-4">
                        <a href="index.htm"><img class="auth__logo img-fluid" src="https://realglobalfx.com/cloud/app/images/real.png" alt="Octa Invest"> </a>
                            
                                                </div>
                    
                    <div class="card ">
                        <h1 class="text-center mt-3"> User Login</h1>
                        <form method="POST" class="mt-5 card__form">
                            <input type="hidden" name="_token" value="Tsc0Z9Vmtv4BD2HdKuD4I68jj51vNjRFpXX7sW30"> 
                            
                            <div class="form-group ">
                                                                <label for="email">Email address</label>
                                <input type="email" class="form-control" name="email" value="" id="email" placeholder="name@example.com" required="">
                            </div>
                            <div class="form-group">
                                                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required="">
                            </div>
                            
                            <div class="form-group">
                                <button class="btn btn-primary mt-4" name="login" type="submit">Login</button>
                            </div>
    
                            <div class="text-center mb-3">
                                <small class=" text-center mb-2">Forget your Password <a href="password/reset.html" class="link ml-1">Reset.</a> </small>
                                <small class=" text-center">Dont have an Account yet? <a href="register.php" class="link ml-1">Sign up.</a> </small>
                            </div>
                            <div class="text-center">
                                <hr>
                                <small class=" text-center">&copy; Copyright  2024 &nbsp; Octa Invest &nbsp; All Rights Reserved.</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
    </section>
</body>
</html>
