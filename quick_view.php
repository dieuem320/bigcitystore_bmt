<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view" style="width: 100%;">


   <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <h1 class="title"><?= $fetch_products['name']; ?></h1>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
      <div class="cover">
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <img src="images/qv-1.webp" alt="">
         <img src="images/qv-2.webp" alt="">
         <img src="images/qv-3.webp" alt="">
      </div>
      <div class="flex">
         <div class="price"><span></span><?= number_format( $fetch_products['price'], 0, '', '.'); ?>đ</div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
      </div>
      <button type="submit" name="add_to_cart" class="cart-btn">add to cart</button>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

</section>


<section class="q-view">
   <h1 class="title">Thông số kĩ thuật </h1>
   <div class="row">
      <p class="box"><span style="font-weight: 700;">Màn hình:</span> LTPO Super Retina XDR OLED, 120Hz, 6.7 inches, 1290 x 2796 pixels, tỷ lệ 19.5:9</p>
      <p class="box"><span style="font-weight: 700;">Hệ điều hành:</span> IOS 17</p>
      <p class="box"><span style="font-weight: 700;">Camera sau:</span> 48 MP, f/1.8, 24mm - 12 MP, f/2.8, 120mm - 12 MP, f/2.2, 13mm </p>
      <p class="box"><span style="font-weight: 700;">Camera trước:</span> 12 MP, f/1.9, 23mm</p>
      <p class="box"><span style="font-weight: 700;">CPU:</span> Apple A17 Pro (3 nm)</p>
      <p class="box"><span style="font-weight: 700;">RAM:</span> 8GB</p>
      <p class="box"><span style="font-weight: 700;">Bộ nhớ trong:</span> 256-512GB, 1TB, NVMe</p>
      <p class="box"><span style="font-weight: 700;">Thẻ SIM:</span> Nano SIM và eSIM</p>
      <p class="box"><span style="font-weight: 700;">Dung lượng pin:</span> Li-Ion 5000 mAh</p>
      <p class="box"><span style="font-weight: 700;">Kích thước:</span> 159.9 x 76.7 x 8.3 mm</p>
   </div>

</section>


<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>




</body>
</html>