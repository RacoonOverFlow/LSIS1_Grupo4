<?php

require_once ("../bll/handle_login.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../CSS/styleGlobal.css">
  <link rel="stylesheet" href="../CSS/styleLogin.css">
</head>

<body style="background-color: #19365F;">

<div class="skewed"></div>

<section class="login-box">
  <div class="logo">
    <img src="../photos/logo.png" alt="logo">
  </div>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="login-form">
      <input type="text" name="username" class="login-form-field <?php echo (!empty($nMeca_err)) ? 'is-invalid' : ''; ?>" placeholder="Username" value="<?php echo $nMeca; ?>">
      <span class="invalid-feedback"><?php echo $nMeca_err; ?></span>
    </div>
    <div class="login-form">
      <input type="password" name="password" class="login-form-field <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password">
      <span class="invalid-feedback"><?php echo $password_err; ?></span>
    </div>
  <input type="submit" value="Login" id="login-form-submit" >
  </form>
</section>


</body>
</html>