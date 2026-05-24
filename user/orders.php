<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['user_email'])){ header('Location: login.php'); exit; }
$em=mysqli_real_escape_string($conn,$_SESSION['user_email']);
$res=mysqli_query($conn,"SELECT * FROM orders WHERE user_email='$em' ORDER BY id DESC");
include '../includes/header.php'; ?>
<h2 style="color:#b8342f;margin-bottom:14px">📦 My Orders</h2>
<?php if(mysqli_num_rows($res)==0): ?>
<div class="card">No orders yet.</div>
<?php else: ?>
<div class="table-wrap"><table>
<tr><th>Order #</th><th>Date</th><th>Total</th><th>Status</th><th>Receipt</th></tr>
<?php while($o=mysqli_fetch_assoc($res)): ?>
<tr>
  <td>#<?php echo $o['id']; ?></td>
  <td><?php echo $o['created_at']; ?></td>
  <td>Rs. <?php echo $o['total']; ?></td>
  <td class="status-<?php echo $o['status']; ?>"><?php echo $o['status']; ?></td>
  <td><a href="receipt.php?id=<?php echo $o['id']; ?>" style="display:inline-block;padding:5px 14px;background:linear-gradient(135deg,#c0392b,#8e2620);color:#fff;border-radius:50px;font-size:12.5px;font-weight:700;text-decoration:none">🧾 View</a></td>
</tr>
<?php endwhile; ?>
</table></div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>
