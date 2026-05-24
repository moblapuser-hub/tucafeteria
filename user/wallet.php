<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['user_email'])){ header('Location: login.php'); exit; }
// auto-create table if missing
mysqli_query($conn,"CREATE TABLE IF NOT EXISTS wallet_txn (id INT AUTO_INCREMENT PRIMARY KEY, user_email VARCHAR(100) NOT NULL, amount DECIMAL(10,2) NOT NULL, method VARCHAR(50) NOT NULL, reference_no VARCHAR(80) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
$em=mysqli_real_escape_string($conn,$_SESSION['user_email']);
$msg='';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $amt=(float)$_POST['amount'];
  $method=mysqli_real_escape_string($conn,$_POST['method']);
  $ref=trim(mysqli_real_escape_string($conn,$_POST['reference_no'] ?? ''));
  if($amt<=0){ $msg='<div class="msg error">Invalid amount.</div>'; }
  elseif($ref===''){ $msg='<div class="msg error">Reference number is required (needed for withdrawal/verification).</div>'; }
  else{
    mysqli_query($conn,"UPDATE users SET wallet=wallet+$amt WHERE email='$em'");
    mysqli_query($conn,"INSERT INTO wallet_txn (user_email,amount,method,reference_no) VALUES ('$em',$amt,'$method','$ref')");
    $msg='<div class="msg success">Rs. '.number_format($amt,2).' added via '.$method.' (Ref: '.htmlspecialchars($ref).').</div>';
  }
}
$u=mysqli_fetch_assoc(mysqli_query($conn,"SELECT wallet FROM users WHERE email='$em'"));
$txns=mysqli_query($conn,"SELECT * FROM wallet_txn WHERE user_email='$em' ORDER BY id DESC LIMIT 10");
include '../includes/header.php'; ?>
<h2 style="color:#b8342f;font-family:'Playfair Display',serif">💳 Wallet</h2>
<div class="card" style="background:linear-gradient(135deg,#c0392b,#8e2620);color:#fff">
  <div style="font-size:14px;opacity:.85">Current Balance</div>
  <div style="font-size:34px;font-weight:800;margin-top:4px">Rs. <?php echo number_format($u['wallet'],2); ?></div>
</div>
<div class="card">
  <h3 style="margin-bottom:10px">Add Money</h3>
  <?php echo $msg; ?>
  <form method="POST">
    <label>Amount (Rs.)</label>
    <input type="number" name="amount" min="1" step="0.01" required>
    <label>Payment Method</label>
    <select name="method">
      <option>JazzCash</option><option>EasyPaisa</option><option>Bank Transfer</option>
    </select>
    <label>Reference Number <span style="color:#a01616">*</span></label>
    <input type="text" name="reference_no" placeholder="Transaction / Reference No. (used for withdrawal)" required>
    <small style="display:block;margin:-8px 0 14px;color:#666">Yeh reference number withdrawal / verification ke liye save hoga.</small>
    <button class="btn-primary">Add Money</button>
  </form>
</div>
<?php if(mysqli_num_rows($txns)): ?>
<div class="card">
  <h3 style="margin-bottom:12px">Recent Transactions</h3>
  <div class="table-wrap"><table>
    <tr><th>Date</th><th>Amount</th><th>Method</th><th>Reference No.</th></tr>
    <?php while($t=mysqli_fetch_assoc($txns)): ?>
    <tr>
      <td><?php echo $t['created_at']; ?></td>
      <td>Rs. <?php echo number_format($t['amount'],2); ?></td>
      <td><?php echo htmlspecialchars($t['method']); ?></td>
      <td><?php echo htmlspecialchars($t['reference_no']); ?></td>
    </tr>
    <?php endwhile; ?>
  </table></div>
</div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>
