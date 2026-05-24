<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['admin'])){ header('Location: login.php'); exit; }
if($_SERVER['REQUEST_METHOD']=='POST'){
  $id=(int)$_POST['id']; $s=mysqli_real_escape_string($conn,$_POST['status']);
  mysqli_query($conn,"UPDATE orders SET status='$s' WHERE id=$id");
  header('Location: orders.php'); exit;
}
$res=mysqli_query($conn,"SELECT * FROM orders ORDER BY id DESC");
include '../includes/header.php'; ?>
<h2 style="color:#b8342f">All Orders</h2>
<div class="table-wrap"><table>
<tr><th>#</th><th>User</th><th>Total</th><th>Date</th><th>Status</th><th>Update</th></tr>
<?php while($o=mysqli_fetch_assoc($res)): ?>
<tr>
<td>#<?php echo $o['id']; ?></td>
<td><?php echo htmlspecialchars($o['user_email']); ?></td>
<td>Rs. <?php echo $o['total']; ?></td>
<td><?php echo $o['created_at']; ?></td>
<td class="status-<?php echo $o['status']; ?>"><?php echo $o['status']; ?></td>
<td>
<form method="POST" style="display:flex;gap:6px;margin:0">
<input type="hidden" name="id" value="<?php echo $o['id']; ?>">
<select name="status">
<?php foreach(['Pending','Preparing','Ready','Delivered'] as $s){ $sel=$o['status']==$s?'selected':''; echo "<option $sel>$s</option>"; } ?>
</select>
<button class="btn-primary" style="padding:6px 12px">Set</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</table></div>
<?php include '../includes/footer.php'; ?>
