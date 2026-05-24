<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['admin'])){ header('Location: login.php'); exit; }
$users=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM users"))['c'];
$orders=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM orders"))['c'];
$items=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM items"))['c'];
$rev=mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(total) s FROM orders"))['s'] ?? 0;
include '../includes/header.php'; ?>
<h2 style="color:#b8342f;margin-bottom:14px">Admin Dashboard</h2>
<div class="menu-grid">
  <div class="menu-item"><h3>👥 Users</h3><div class="price"><?php echo $users; ?></div></div>
  <div class="menu-item"><h3>🍽️ Items</h3><div class="price"><?php echo $items; ?></div></div>
  <div class="menu-item"><h3>📦 Orders</h3><div class="price"><?php echo $orders; ?></div></div>
  <div class="menu-item"><h3>💰 Revenue</h3><div class="price">Rs. <?php echo $rev; ?></div></div>
</div>
<?php include '../includes/footer.php'; ?>
