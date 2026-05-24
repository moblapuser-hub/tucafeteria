<?php session_start(); include '../includes/db.php';
$msg='';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $u=mysqli_real_escape_string($conn,$_POST['username']);
  $p=mysqli_real_escape_string($conn,$_POST['password']);
  $r=mysqli_query($conn,"SELECT * FROM admin WHERE username='$u' AND password='$p'");
  if(mysqli_num_rows($r)==1){ $_SESSION['admin']=$u; header('Location: dashboard.php'); exit; }
  $msg='<div class="msg error">Invalid username or password.</div>';
}
include '../includes/header.php'; ?>
<div class="auth-box">
  <div style="text-align:center;margin-bottom:6px">
    <span style="font-size:38px">🔐</span>
  </div>
  <h2>Admin Login</h2>
  <p style="text-align:center;color:#888;font-size:13px;margin-top:-12px;margin-bottom:18px">Sign in to manage the cafeteria</p>
  <?php echo $msg; ?>
  <form method="POST" autocomplete="off">
    <label>Username</label>
    <input type="text" name="username" required placeholder="Enter admin username">
    <label>Password</label>
    <input type="password" name="password" required placeholder="Enter password">
    <button class="btn-primary" type="submit" style="width:100%;margin-top:4px">Sign In →</button>
  </form>
  <p style="margin-top:16px;text-align:center;font-size:13px"><a href="../index.php" style="color:#888;text-decoration:none">← Back to home</a></p>
</div>
<?php include '../includes/footer.php'; ?>
