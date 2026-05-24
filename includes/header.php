<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/db.php';

$cartCount = 0;
if (isset($_SESSION['user_email'])) {
  $em = mysqli_real_escape_string($conn, $_SESSION['user_email']);
  $r = mysqli_query($conn, "SELECT SUM(qty) as c FROM cart WHERE user_email='$em'");
  if ($r) { $row = mysqli_fetch_assoc($r); $cartCount = (int)($row['c'] ?? 0); }
}
$currentDir = basename(dirname($_SERVER['PHP_SELF']));
$base = ($currentDir === 'admin' || $currentDir === 'user' || isset($_SESSION['admin'])) ? '../' : '';
$pageFull = isset($pageFull) ? $pageFull : false;
$isLogged = isset($_SESSION['user_email']) || isset($_SESSION['admin']);
$logoutUrl = isset($_SESSION['admin']) ? $base.'admin/logout.php' : $base.'user/logout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TU Cafeteria</title>
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <a class="logo" href="<?php echo $base; ?>index.php"
       <?php if($isLogged): ?>data-confirm-home="1" data-logout="<?php echo $logoutUrl; ?>"<?php endif; ?>>
      <span class="logo-icon" aria-hidden="true">🍽️</span>
      <span class="logo-text">TU Cafeteria</span>
    </a>
    <button class="nav-toggle" aria-label="Menu" onclick="document.querySelector('.nav').classList.toggle('open')">
      <span></span><span></span><span></span>
    </button>
    <nav class="nav">
      <?php if (isset($_SESSION['user_email'])): ?>
        <a href="<?php echo $base; ?>user/dashboard.php">Menu</a>
        <a href="<?php echo $base; ?>user/cart.php" class="cart-btn">
          🛒 Cart <span class="cart-count"><?php echo $cartCount; ?></span>
        </a>
        <a href="<?php echo $base; ?>user/wallet.php">Wallet</a>
        <a href="<?php echo $base; ?>user/orders.php">My Orders</a>
        <a href="<?php echo $base; ?>user/logout.php">Logout</a>
      <?php elseif (isset($_SESSION['admin'])): ?>
        <a href="<?php echo $base; ?>admin/dashboard.php">Dashboard</a>
        <a href="<?php echo $base; ?>admin/items.php">Menu Items</a>
        <a href="<?php echo $base; ?>admin/orders.php">Orders</a>
        <a href="<?php echo $base; ?>admin/logout.php">Logout</a>
      <?php else: ?>
        <a href="<?php echo $base; ?>admin/login.php" class="btn-outline">Admin Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<?php if($isLogged): ?>
<!-- Logout confirm modal (only shown when navigating to landing) -->
<div id="lcModal" class="lc-overlay" aria-hidden="true">
  <div class="lc-box" role="dialog" aria-modal="true" aria-labelledby="lcTitle">
    <div class="lc-icon">⚠️</div>
    <h3 id="lcTitle">Leaving so soon?</h3>
    <p>Going back to the home page will <b>log you out</b> of your session. Are you sure you want to continue?</p>
    <div class="lc-btns">
      <button type="button" class="lc-no" onclick="lcClose()">Stay Signed In</button>
      <button type="button" class="lc-yes" onclick="lcConfirm()">Yes, Log Me Out</button>
    </div>
  </div>
</div>
<script>
(function(){
  var logoutUrl = <?php echo json_encode($logoutUrl); ?>;
  var modal = document.getElementById('lcModal');
  document.querySelectorAll('[data-confirm-home]').forEach(function(el){
    el.addEventListener('click', function(e){
      e.preventDefault();
      modal.classList.add('open');
      document.body.style.overflow='hidden';
    });
  });
  window.lcClose = function(){ modal.classList.remove('open'); document.body.style.overflow=''; };
  window.lcConfirm = function(){ window.location.href = logoutUrl; };
  modal.addEventListener('click', function(e){ if(e.target===modal) lcClose(); });
  document.addEventListener('keydown', function(e){ if(e.key==='Escape') lcClose(); });
})();
</script>
<?php endif; ?>

<main class="site-main<?php echo $pageFull ? ' full' : ''; ?>">
<?php if (!$pageFull): ?><div class="container page-container"><?php endif; ?>
