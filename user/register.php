<?php session_start(); include '../includes/db.php';
$msg='';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $name=mysqli_real_escape_string($conn,$_POST['name']);
  $email=mysqli_real_escape_string($conn,$_POST['email']);
  $pass=mysqli_real_escape_string($conn,$_POST['password']);
  $check=mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
  if(mysqli_num_rows($check)>0){ $msg='<div class="msg error">Email already registered.</div>'; }
  else{
    mysqli_query($conn,"INSERT INTO users(name,email,password,wallet) VALUES('$name','$email','$pass',0)");
    $msg='<div class="msg success">Registered! <a href="login.php">Login now</a></div>';
  }
}
include '../includes/header.php'; ?>
<div class="auth-box">
  <h2>Create Account</h2>
  <?php echo $msg; ?>
  <form method="POST">
    <label>Name</label><input name="name" required>
    <label>Email</label><input type="email" name="email" required>
    <label>Password</label><input type="password" name="password" required>
    <button class="btn-primary" type="submit">Register</button>
  </form>
  <p style="margin-top:12px;text-align:center">Already have account? <a href="login.php">Login</a></p>
</div>
<?php include '../includes/footer.php'; ?>
