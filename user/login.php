<?php session_start(); include '../includes/db.php';
$msg='';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $email=mysqli_real_escape_string($conn,$_POST['email']);
  $pass=mysqli_real_escape_string($conn,$_POST['password']);
  $r=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$pass'");
  if(mysqli_num_rows($r)==1){
    $u=mysqli_fetch_assoc($r);
    $_SESSION['user_email']=$u['email'];
    $_SESSION['user_name']=$u['name'];
    header('Location: dashboard.php'); exit;
  } else $msg='<div class="msg error">Invalid credentials.</div>';
}
include '../includes/header.php'; ?>
<div class="auth-box">
  <h2>Student Login</h2>
  <?php echo $msg; ?>
  <form method="POST">
    <label>Email</label><input type="email" name="email" required>
    <label>Password</label><input type="password" name="password" required>
    <button class="btn-primary" type="submit">Login</button>
  </form>
  <p style="margin-top:12px;text-align:center">New here? <a href="register.php">Register</a></p>
</div>
<?php include '../includes/footer.php'; ?>
