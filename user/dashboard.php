<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['user_email'])){ header('Location: login.php'); exit; }
$cat = isset($_GET['cat']) ? $_GET['cat'] : 'All';
$cats = ['All','Breakfast','Lunch','Snacks','Drinks'];
$where = $cat==='All' ? '' : "WHERE category='".mysqli_real_escape_string($conn,$cat)."'";
$res = mysqli_query($conn,"SELECT * FROM items $where ORDER BY category, name");
include '../includes/header.php'; ?>
<h2 style="color:#b8342f;margin-bottom:14px">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
<div class="cat-tabs">
  <?php foreach($cats as $c): ?>
    <a href="?cat=<?php echo $c; ?>" class="<?php echo $c===$cat?'active':''; ?>"><?php echo $c; ?></a>
  <?php endforeach; ?>
</div>
<div class="menu-grid">
<?php while($it = mysqli_fetch_assoc($res)): ?>
  <div class="menu-item">
    <h3><?php echo htmlspecialchars($it['name']); ?></h3>
    <div style="font-size:13px;color:#888"><?php echo $it['category']; ?></div>
    <div class="price">Rs. <?php echo $it['price']; ?></div>
    <button class="btn-primary add-cart-btn" data-id="<?php echo $it['id']; ?>">Add to Cart</button>
  </div>
<?php endwhile; ?>
</div>
<script src="../assets/js/main.js"></script>
<?php include '../includes/footer.php'; ?>
