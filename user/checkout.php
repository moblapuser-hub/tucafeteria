<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['user_email'])){ header('Location: login.php'); exit; }
$em=mysqli_real_escape_string($conn,$_SESSION['user_email']);
$res=mysqli_query($conn,"SELECT c.qty,i.name,i.price FROM cart c JOIN items i ON i.id=c.item_id WHERE c.user_email='$em'");
$total=0; $rows=[];
while($r=mysqli_fetch_assoc($res)){ $rows[]=$r; $total+=$r['price']*$r['qty']; }
$u=mysqli_fetch_assoc(mysqli_query($conn,"SELECT wallet FROM users WHERE email='$em'"));
$err='';
if(count($rows)==0){ header('Location: cart.php'); exit; }
if($u['wallet']<$total){ $err='<div class="msg error">Insufficient wallet balance. <a href="wallet.php">Top up</a></div>'; }
else {
  mysqli_query($conn,"INSERT INTO orders(user_email,total,status) VALUES('$em',$total,'Pending')");
  $oid=mysqli_insert_id($conn);
  foreach($rows as $r){
    $n=mysqli_real_escape_string($conn,$r['name']);
    mysqli_query($conn,"INSERT INTO order_items(order_id,item_name,price,qty) VALUES($oid,'$n',{$r['price']},{$r['qty']})");
  }
  mysqli_query($conn,"UPDATE users SET wallet=wallet-$total WHERE email='$em'");
  mysqli_query($conn,"DELETE FROM cart WHERE user_email='$em'");
  header("Location: order_placed.php?id=$oid"); exit;
}
include '../includes/header.php'; ?>
<h2 style="color:#b8342f">Checkout</h2>
<?php echo $err; ?>
<div class="card">
  <p>Total: <strong>Rs. <?php echo $total; ?></strong></p>
  <p>Wallet: <strong>Rs. <?php echo $u['wallet']; ?></strong></p>
  <a href="cart.php" class="btn-primary" style="text-decoration:none">Back to Cart</a>
</div>
<?php include '../includes/footer.php'; ?>
