<?
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];

$sql = "SELECT * FROM `serviceslist`";
$result;
$services_arr = array();
$i = 1;
if($result = $conn->query($sql)) {
  foreach($result as $row) {
    $user_id_bd = $row['user_id'];
    if($user_id_bd == $user_id) {
      $status_mod = $row['status_mod'];
      if($status_mod == '0') {
        $status = "На модерации";
        $bg_color = 'background: yellow';
      } else if( $status_mod == '1') {
        $status = "Одобрено";
        $bg_color = 'background: green';
      } else if($status_mod == '2') {
        $status = "Отклонено";
        $bg_color = 'background: red';
      }
      $product_name = $row['product_name'];
      $product_price = $row['product_price'];
      $product_desc = $row['product_desc'];
      $product_category = $row['product_category'];
      $services_arr[] = '
      <div class="services_item" id="services_item" data-itemid="'.$i.'">
        <h4 class="services_item_title">'.$product_name.'</h4>
        <p class="services_item_price">Стоимость '.$product_price.' бонусов</p>
        <p class="services_item_category">Категория: '.$product_category.'</p>
        <p class="status_mod" style="'.$bg_color.';">'.$status.'</p>
        <div class="btn_services_modal">Подробнее</div>
        <div class="services_item_modal" data-itemid="'.$i.'">
          <h4 class="services_item_modal_title">'.$product_name.'</h4>
          <p class="services_item_modal_category">Категория: '.$product_category.'</p>
          <p class="services_item_modal_desc">'.$product_desc.'</p>
          <p class="services_item_modal_price">Стоимость '.$product_price.' бонусов</p>
          <div class="btn_services_modal_close">
            <i class="fa fa-times" aria-hidden="true"></i>
          </div>
        </div>
      </div>';
      $i++;
    }
  }
}

$services_str = implode($services_arr);
echo $services_str;

