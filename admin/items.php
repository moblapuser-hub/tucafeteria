<?php session_start(); include '../includes/db.php';
if(!isset($_SESSION['admin'])){ header('Location: login.php'); exit; }
if(isset($_GET['delete'])){ $id=(int)$_GET['delete']; mysqli_query($conn,"DELETE FROM items WHERE id=$id"); header('Location: items.php'); exit; }
if($_SERVER['REQUEST_METHOD']=='POST'){
  $n=mysqli_real_escape_string($conn,$_POST['name']);
  $c=mysqli_real_escape_string($conn,$_POST['category']);
  $p=(float)$_POST['price'];
  if(!empty($_POST['id'])){ $id=(int)$_POST['id']; mysqli_query($conn,"UPDATE items SET name='$n',category='$c',price=$p WHERE id=$id"); }
  else mysqli_query($conn,"INSERT INTO items(name,category,price) VALUES('$n','$c',$p)");
  header('Location: items.php'); exit;
}
$edit=null;
if(isset($_GET['edit'])){ $id=(int)$_GET['edit']; $edit=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM items WHERE id=$id")); }
$res=mysqli_query($conn,"SELECT * FROM items ORDER BY category,name");
include '../includes/header.php'; ?>
<h2 style="color:#b8342f">Menu Items</h2>
<div class="card">
  <h3><?php echo $edit?'Edit Item':'Add Item'; ?></h3>
  <form method="POST">
    <input type="hidden" name="id" value="<?php echo $edit['id']??''; ?>">
    <label>Name</label><input name="name" value="<?php echo htmlspecialchars($edit['name']??''); ?>" required>
    <label>Category</label>
    <select name="category">
      <?php foreach(['Breakfast','Lunch','Snacks','Drinks'] as $c){ $s=($edit && $edit['category']==$c)?'selected':''; echo "<option $s>$c</option>"; } ?>
    </select>
    <label>Price (Rs.)</label><input type="number" step="0.01" name="price" value="<?php echo $edit['price']??''; ?>" required>
    <button class="btn-primary"><?php echo $edit?'Update':'Add'; ?></button>
  </form>
</div>
<div class="table-wrap"><table>
<tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Actions</th></tr>
<?php while($r=mysqli_fetch_assoc($res)): ?>
<tr><td><?php echo $r['id']; ?></td><td><?php echo htmlspecialchars($r['name']); ?></td><td><?php echo $r['category']; ?></td><td>Rs. <?php echo $r['price']; ?></td>
<td><a href="?edit=<?php echo $r['id']; ?>">Edit</a> | <a href="?delete=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')" style="color:#a01616">Delete</a></td></tr>
<?php endwhile; ?>
</table></div>
<?php include '../includes/footer.php'; ?>
