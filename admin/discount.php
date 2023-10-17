<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_discount'])){

   $code = $_POST['code'];
   $code = filter_var($code, FILTER_SANITIZE_STRING);
   $amount = $_POST['amount'];
   $amount = filter_var($amount, FILTER_SANITIZE_STRING);

   $select_discount = $conn->prepare("SELECT * FROM `discount` WHERE code = ?");
   $select_discount->execute([$code]);

   if($select_discount->rowCount() > 0){
      $message[] = 'Mã giảm giá đã tồn tại!';
   }else{
      $insert_product = $conn->prepare("INSERT INTO `discount` (code, amount) VALUES(?,?)");
      $insert_product->execute([$code, $amount]);

      $message[] = 'Thêm mã giảm giá thành công!';
   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product = $conn->prepare("DELETE FROM `discount` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   header('location:discount.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sản phẩm</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Thêm mã giảm giá</h3>
      <input type="text" required placeholder="mã giảm giá" name="code" maxlength="100" class="box">
      <input type="number" min="0" max="100" required placeholder="% giảm" name="amount" onkeypress="if(this.value.length == 10) return false;" class="box">
      <input type="submit" value="Thêm" name="add_discount" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="accounts">

   <h1 class="heading">Mã giảm giá</h1>

   <div class="box-container">

   <?php
      $select_account = $conn->prepare("SELECT * FROM `discount`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <p> Mã giảm giá : <span><?= $fetch_accounts['code']; ?></span> </p>
      <p> Giảm : <span><?= $fetch_accounts['amount']; ?>%</span></p>
      <a href="discount.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Xác nhận xoá?');">XOÁ</a>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Chưa có mã giảm giá</p>';
   }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>