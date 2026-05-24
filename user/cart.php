<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['user_email'])){ header('Location: login.php'); exit; }
$em = mysqli_real_escape_string($conn,$_SESSION['user_email']);
if(isset($_GET['remove'])){
  $rid=(int)$_GET['remove'];
  mysqli_query($conn,"DELETE FROM cart WHERE id=$rid AND user_email='$em'");
  header('Location: cart.php'); exit;
}
$res = mysqli_query($conn,"SELECT c.id cid,c.qty,i.name,i.price FROM cart c JOIN items i ON i.id=c.item_id WHERE c.user_email='$em'");
$total=0;
include '../includes/header.php'; ?>
<h2 style="color:#b8342f;margin-bottom:14px">🛒 Your Cart</h2>
<?php if(mysqli_num_rows($res)==0): ?>
  <div class="card">Your cart is empty. <a href="dashboard.php">Browse menu</a></div>
<?php else: ?>
<div class="table-wrap"><table>
<tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr>
<?php while($r=mysqli_fetch_assoc($res)): $sub=$r['price']*$r['qty']; $total+=$sub; ?>
<tr>
  <td><?php echo htmlspecialchars($r['name']); ?></td>
  <td>Rs. <?php echo $r['price']; ?></td>
  <td><?php echo $r['qty']; ?></td>
  <td>Rs. <?php echo $sub; ?></td>
  <td><a href="?remove=<?php echo $r['cid']; ?>" style="color:#a01616">Remove</a></td>
</tr>
<?php endwhile; ?>
<tr><td colspan="3" style="text-align:right;font-weight:700">Total</td><td colspan="2" style="font-weight:700">Rs. <?php echo $total; ?></td></tr>
</table></div>
<div class="action-row">
  <a href="checkout.php" class="btn-primary" style="text-decoration:none">Proceed to Place Order</a>
  <a href="dashboard.php" class="btn-primary" style="background:#777;text-decoration:none">Continue Shopping</a>
</div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>
