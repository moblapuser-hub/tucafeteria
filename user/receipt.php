<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['user_email'])){ header('Location: login.php'); exit; }
$oid=(int)$_GET['id'];
$em=mysqli_real_escape_string($conn,$_SESSION['user_email']);
$o=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM orders WHERE id=$oid AND user_email='$em'"));
if(!$o){ die('Order not found'); }
$items=mysqli_query($conn,"SELECT * FROM order_items WHERE order_id=$oid");
$rows=[]; $subtotal=0;
while($i=mysqli_fetch_assoc($items)){ $rows[]=$i; $subtotal += $i['price']*$i['qty']; }
$status = $o['status'];
$statusColor = ['Pending'=>'#e67e22','Preparing'=>'#2980b9','Ready'=>'#27ae60','Delivered'=>'#16a085','Cancelled'=>'#c0392b'][$status] ?? '#888';
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Receipt #<?php echo $oid; ?> — TU Cafeteria</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:linear-gradient(135deg,#fdf6ee 0%,#f5e9d6 100%);min-height:100vh;padding:30px 16px;color:#1a1a1a}
.rc{max-width:580px;margin:0 auto;background:#fff;border-radius:22px;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.12);position:relative}
.rc-top{background:linear-gradient(135deg,#c0392b 0%,#8e2620 100%);color:#fff;padding:30px 30px 70px;position:relative;overflow:hidden}
.rc-top::after{content:'';position:absolute;left:0;right:0;bottom:-1px;height:26px;background:#fff;-webkit-mask:radial-gradient(circle 10px at 15px 0,transparent 98%,#000) 0 0/30px 26px;mask:radial-gradient(circle 10px at 15px 0,transparent 98%,#000) 0 0/30px 26px}
.rc-top::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 90% 10%,rgba(232,160,32,.28),transparent 55%);pointer-events:none}
.rc-brand{display:flex;align-items:center;gap:10px;font-weight:700;font-size:17px;opacity:.95}
.rc-brand span{font-size:22px}
.rc-title{font-family:'Playfair Display',serif;font-size:30px;font-weight:800;margin-top:14px;letter-spacing:.3px}
.rc-sub{opacity:.8;font-size:13.5px;margin-top:4px}
.rc-num{position:absolute;right:26px;top:26px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.3);padding:8px 14px;border-radius:50px;font-size:12.5px;font-weight:700;letter-spacing:1.2px;backdrop-filter:blur(6px)}
.rc-body{padding:24px 30px 10px}
.rc-meta{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:22px;padding:16px;background:#fbf7f0;border-radius:14px;border:1px dashed #e0d9c8}
.rc-meta div{font-size:13px}
.rc-meta b{display:block;font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:#888;margin-bottom:4px;font-weight:600}
.rc-meta span{color:#1a1a1a;font-weight:600;font-size:14px;word-break:break-word}
.rc-status{display:inline-block;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:700;color:#fff}
.rc-items{margin-top:6px}
.rc-items h3{font-size:11px;text-transform:uppercase;letter-spacing:2px;color:#999;margin-bottom:10px;font-weight:700}
.rc-row{display:grid;grid-template-columns:1fr 60px 90px;gap:8px;padding:12px 0;border-bottom:1px dashed #ebe4d5;font-size:14px;align-items:center}
.rc-row:last-child{border-bottom:none}
.rc-row .n{font-weight:600;color:#1a1a1a}
.rc-row .q{text-align:center;color:#666;font-size:13px;background:#fbf7f0;border-radius:50px;padding:3px 0}
.rc-row .p{text-align:right;font-weight:700;color:#c0392b}
.rc-totals{margin-top:18px;padding:18px 20px;background:linear-gradient(135deg,#fdf6ee,#f5e9d6);border-radius:14px;border:1px solid rgba(192,57,43,.1)}
.rc-tline{display:flex;justify-content:space-between;align-items:center;font-size:14px;color:#555;margin-bottom:6px}
.rc-tline:last-child{margin-top:10px;padding-top:12px;border-top:1.5px solid rgba(192,57,43,.18);font-family:'Playfair Display',serif;font-size:24px;font-weight:800;color:#1a1a1a;margin-bottom:0}
.rc-tline:last-child b{color:#c0392b}
.rc-thanks{text-align:center;padding:22px 20px 18px;background:#fbf7f0;margin-top:18px;border-radius:14px}
.rc-thanks h4{font-family:'Playfair Display',serif;font-size:18px;color:#c0392b;margin-bottom:4px}
.rc-thanks p{font-size:12.5px;color:#888}
.rc-foot{padding:16px 30px 22px;text-align:center;color:#aaa;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;border-top:1.5px dashed #ebe4d5;margin-top:8px}
.rc-foot-logo{font-size:22px;margin-bottom:4px}
.rc-foot-tagline{font-size:10.5px;color:#ccc;margin-top:3px;font-style:italic;text-transform:none;letter-spacing:.5px}
.rc-actions{display:flex;gap:10px;justify-content:center;margin:22px auto 0;max-width:580px;flex-wrap:wrap;padding:0 16px}
.rc-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 26px;border-radius:50px;border:none;cursor:pointer;font-family:inherit;font-weight:700;font-size:14px;text-decoration:none;transition:.2s}
.rc-btn-p{background:linear-gradient(135deg,#c0392b,#8e2620);color:#fff;box-shadow:0 8px 20px rgba(192,57,43,.32)}
.rc-btn-p:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(192,57,43,.45)}
.rc-btn-s{background:#fff;color:#1a1a1a;border:1.5px solid #e0d9c8}
.rc-btn-s:hover{background:#fbf7f0;border-color:#c0392b;color:#c0392b}
@media(max-width:520px){
  .rc-top{padding:24px 22px 60px}.rc-body{padding:20px 22px 8px}
  .rc-title{font-size:24px}.rc-num{top:20px;right:18px;font-size:11px;padding:6px 12px}
  .rc-meta{grid-template-columns:1fr;gap:10px;padding:14px}
  .rc-row{grid-template-columns:1fr 50px 80px;font-size:13px}
  .rc-tline:last-child{font-size:20px}
}

.rc-modal{position:fixed;inset:0;background:rgba(20,12,8,.55);backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;z-index:9999;padding:20px;animation:rcfade .2s ease}
.rc-modal.open{display:flex}
@keyframes rcfade{from{opacity:0}to{opacity:1}}
.rc-modal-card{background:#fff;border-radius:18px;max-width:430px;width:100%;padding:30px 26px 24px;box-shadow:0 30px 70px rgba(0,0,0,.25);text-align:center;animation:rcpop .25s ease}
@keyframes rcpop{from{transform:translateY(15px) scale(.96);opacity:0}to{transform:translateY(0) scale(1);opacity:1}}
.rc-modal-ic{width:62px;height:62px;border-radius:50%;background:linear-gradient(135deg,#fff3e0,#ffe0b2);display:flex;align-items:center;justify-content:center;font-size:30px;margin:0 auto 14px}
.rc-modal h3{font-family:'Playfair Display',serif;font-size:22px;color:#1a1a1a;margin-bottom:8px}
.rc-modal p{color:#666;font-size:14px;line-height:1.55;margin-bottom:20px}
.rc-modal p b{color:#c0392b}
.rc-modal-actions{display:flex;gap:10px;justify-content:center;flex-wrap:wrap}
.rc-modal-actions .rc-btn{padding:11px 22px;font-size:13.5px}
.rc-modal-close{position:absolute;top:14px;right:16px;background:none;border:none;font-size:22px;color:#aaa;cursor:pointer;line-height:1}
.rc-modal-close:hover{color:#c0392b}
@media print{.rc-modal{display:none !important}}

@media print{
  body{background:#fff;padding:0}
  .rc{box-shadow:none;border-radius:0;max-width:100%}
  .rc-actions{display:none}
}
</style>
</head><body>
<div class="rc">
  <div class="rc-top">
    <div class="rc-brand"><span>🍽️</span> TU Cafeteria</div>
    <div class="rc-title">Order Receipt</div>
    <div class="rc-sub">Thank you for your purchase</div>
    <div class="rc-num">#<?php echo str_pad($oid,4,'0',STR_PAD_LEFT); ?></div>
  </div>
  <div class="rc-body">
    <div class="rc-meta">
      <div><b>Customer</b><span><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Customer'); ?></span></div>
      <div><b>Date</b><span><?php echo date('d M Y, h:i A', strtotime($o['created_at'])); ?></span></div>
      <div><b>Order ID</b><span>#<?php echo str_pad($oid,4,'0',STR_PAD_LEFT); ?></span></div>
      <div><b>Status</b><span class="rc-status" style="background:<?php echo $statusColor; ?>"><?php echo htmlspecialchars($status); ?></span></div>
    </div>
    <div class="rc-items">
      <h3>Order Items</h3>
      <?php foreach($rows as $i): ?>
      <div class="rc-row">
        <div class="n"><?php echo htmlspecialchars($i['item_name']); ?><div style="font-size:11.5px;color:#999;font-weight:500;margin-top:2px">Rs. <?php echo $i['price']; ?> each</div></div>
        <div class="q">×<?php echo $i['qty']; ?></div>
        <div class="p">Rs. <?php echo $i['price']*$i['qty']; ?></div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="rc-totals">
      <div class="rc-tline"><span>Subtotal</span><span>Rs. <?php echo $subtotal; ?></span></div>
      <div class="rc-tline"><span>Service Charge</span><span>Rs. 0</span></div>
      <div class="rc-tline"><span>Total</span><b>Rs. <?php echo $o['total']; ?></b></div>
    </div>
    <div class="rc-thanks">
      <h4>Enjoy your meal! 🍽️</h4>
      <p>Please collect your order from the counter when ready.</p>
    </div>
  </div>
  <div class="rc-foot">
    <div class="rc-foot-logo">🍽️</div>
    Thal University Bhakkar &middot; Cafeteria
    <div class="rc-foot-tagline">Good food, great memories</div>
  </div>
</div>
<div class="rc-actions">
  <button class="rc-btn rc-btn-p" onclick="rcTryPrint()">🖨️ Print Receipt</button>
  <a class="rc-btn rc-btn-s" href="orders.php">← Back to Orders</a>
</div>

<div class="rc-modal" id="rcModal" role="dialog" aria-modal="true">
  <div class="rc-modal-card" style="position:relative">
    <button class="rc-modal-close" onclick="rcCloseModal()" aria-label="Close">&times;</button>
    <div class="rc-modal-ic">⏳</div>
    <h3>Order not ready yet</h3>
    <p>Your receipt can only be printed once the order status is <b>Delivered</b>.<br>Current status: <b><?php echo htmlspecialchars($status); ?></b></p>
    <p style="margin-bottom:14px;font-size:13.5px">Where would you like to go next?</p>
    <div class="rc-modal-actions">
      <a class="rc-btn rc-btn-p" href="dashboard.php">🍽️ Menu</a>
      <a class="rc-btn rc-btn-s" href="orders.php">📋 My Orders</a>
    </div>
  </div>
</div>
<script>
var rcOrderStatus = <?php echo json_encode($status); ?>;
function rcTryPrint(){
  if(rcOrderStatus === 'Delivered'){ window.print(); }
  else { document.getElementById('rcModal').classList.add('open'); }
}
function rcCloseModal(){ document.getElementById('rcModal').classList.remove('open'); }
document.addEventListener('keydown',function(e){ if(e.key==='Escape') rcCloseModal(); });
document.getElementById('rcModal') && document.getElementById('rcModal').addEventListener('click',function(e){ if(e.target===this) rcCloseModal(); });
</script>

</body></html>
