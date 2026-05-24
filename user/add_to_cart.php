<?php
session_start();
header('Content-Type: application/json');
include '../includes/db.php';
if(!isset($_SESSION['user_email'])){ echo json_encode(['success'=>false,'message'=>'Login required']); exit; }
$id = (int)($_GET['id'] ?? 0);
$em = mysqli_real_escape_string($conn,$_SESSION['user_email']);
if($id<=0){ echo json_encode(['success'=>false,'message'=>'Invalid item']); exit; }
$chk = mysqli_query($conn,"SELECT id,qty FROM cart WHERE user_email='$em' AND item_id=$id");
if($row = mysqli_fetch_assoc($chk)){
  $nq = $row['qty']+1;
  mysqli_query($conn,"UPDATE cart SET qty=$nq WHERE id={$row['id']}");
} else {
  mysqli_query($conn,"INSERT INTO cart(user_email,item_id,qty) VALUES('$em',$id,1)");
}
$r = mysqli_query($conn,"SELECT SUM(qty) c FROM cart WHERE user_email='$em'");
$c = mysqli_fetch_assoc($r)['c'] ?? 0;
echo json_encode(['success'=>true,'count'=>(int)$c]);
