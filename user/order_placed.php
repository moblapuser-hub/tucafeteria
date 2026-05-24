<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['user_email'])){ header('Location: login.php'); exit; }
$oid=(int)($_GET['id'] ?? 0);
include '../includes/header.php'; ?>
<div class="card" style="text-align:center;padding:40px">
  <div style="font-size:60px">✅</div>
  <h2 style="color:#27ae60;margin:10px 0">Order Placed Successfully!</h2>
  <p>Your order #<?php echo $oid; ?> has been received and is being prepared.</p>
  <div class="action-row" style="justify-content:center">
    <a href="orders.php" class="btn-primary" style="text-decoration:none">📦 Track My Order</a>
    <a href="receipt.php?id=<?php echo $oid; ?>" class="btn-primary" style="background:#f7b500;color:#2b2b2b;text-decoration:none">🖨️ Print Receipt</a>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
