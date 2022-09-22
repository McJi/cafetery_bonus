<?
require_once (__DIR__.'/db_conn.php');

$json_product = $_POST['arr'];
$user_name = $_POST['user_name'];
$user_id = $_POST['user_id'];
$summ_price = 0;
$moderator = $_POST['moderator'];

foreach($json_product as $product) {
  
  if((empty($product)) == true) {

  } else {
    $variable_product_str = explode('|', $product);
    $title_product = $variable_product_str[0];
    $price_product = $variable_product_str[1];
    $desc_product = $variable_product_str[2];
    $product_category = $variable_product_str[3];
    $var_price = $summ_price + (int)$price_product;
    $summ_price = $var_price;
    $today = date("Y-m-d");
    $random_numb = rand();

    $sql = "INSERT INTO `serviceslist` (`user_id`, `product_name`, `product_price`, `product_desc`, `product_category`, `status_mod`, `random_id_product`, `date`) VALUES ('$user_id','$title_product','$price_product','$desc_product', '$product_category', '0', '$random_numb', '$today')";
    if (mysqli_query($conn, $sql)) {
      echo "Новая запись добавлена";
    } else {
          echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    $sql_moder = "INSERT INTO `moderate_service` (`user_id`, `product_name`, `product_price`, `product_desc`, `date_moder`, `status_mod`, `user_name`, `product_category`, `random_id_product`, `moderator_name`) VALUES ('$user_id','$title_product','$price_product','$desc_product', '$today', '0', '$user_name', '$product_category', '$random_numb', '$moderator')";
    if (mysqli_query($conn, $sql_moder)) {
      echo "Новая запись добавлена";
    } else {
          echo "Ошибка: " . $sql_moder . "<br>" . mysqli_error($conn);
    }
  }
}

mysqli_close($conn);
