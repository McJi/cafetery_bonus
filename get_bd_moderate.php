<?
require_once (__DIR__.'/db_conn.php');

$domain = $_POST['domain'];

$data_modarate = $_POST['data_modarate'];
if($data_modarate == 'current_requests') {
  $sql = "SELECT * FROM `moderate_service`";
  $result;
  $services_arr = array();
  $i = 1;
  if($result = $conn->query($sql)) {
    foreach($result as $row) {
      $status = $row['status_mod'];
      if($status == '0'){
        $status = "На модерации";
        $bg_color = 'background: yellow';
        $user_name = $row['user_name'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_desc = $row['product_desc'];
        $product_category = $row['product_category'];
        $bd_id = $row['id'];
        $user_id = $row['user_id'];
        $random_numb = $row['random_id_product'];
        $today = date('Y-m-d');
        $services_arr[] = '
        <div class="moderate_item" id="moderate_item"  data-itemid="'.$i.'">
          <h4 class="moderate_item_title">'.$product_name.'</h4>
          <p class="moderate_item_price">Стоимость '.$product_price.' бонусов</p>
          <p class="moderate_item_category">Категория: '.$product_category.'</p>
          <p class="status_mod" style="'.$bg_color.';">'.$status.'</p>
          <p class="moderate_user_name">Пользователь:<a href="https://'.$domain.'/company/personal/user/'.$user_id.'/" target="_blank"> '.$user_name.'</a></p>
          <div class="btn_moderate_modal">Подробнее</div>
          <div class="accept_moderate" data-random="'.$random_numb.'" data-nameuser="'.$user_name.'" data-servtitle="'.$product_name.'" data-servprice="'.$product_price.'" data-servdesc="'.$product_desc.'" data-status="1" data-bdid="'.$bd_id.'" data-userid="'.$user_id.'" data-servcategory="'.$product_category.'" data-date="'.$today.'">Одобрить</div>
          <div class="cancel_moder" data-random="'.$random_numb.'">Отклонить</div>
          <div class="moderate_item_modal" data-itemid="'.$i.'">
            <h4 class="moderate_item_modal_title">'.$product_name.'</h4>
            <p class="moderate_item_modal_category">Категория: '.$product_category.'</p>
            <p class="moderate_item_modal_desc">'.$product_desc.'</p>
            <p class="moderate_item_modal_price">Стоимость '.$product_price.' бонусов</p>

            <div class="accept_moderate_modal" data-nameuser="'.$user_name.'" data-random="'.$random_numb.'" data-servtitle="'.$product_name.'" data-servprice="'.$product_price.'" data-random="'.$random_numb.'" data-servdesc="'.$product_desc.'" data-bdid="'.$bd_id.'" data-status="1" data-userid="'.$user_id.'" data-servcategory="'.$product_category.'" data-date="'.$today.'">Одобрить</div>
            <div class="cancel_moder_modal" data-random="'.$random_numb.'">Отклонить</div>
            <div class="btn_moderate_modal_close">
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
} else if($data_modarate == 'accept_requests') {
  $sql = "SELECT * FROM `moderate_service`";
  $result;
  $services_arr = array();
  $i = 1;
  if($result = $conn->query($sql)) {
    foreach($result as $row) {
      $status = $row['status_mod'];
      if($status == '1'){
        $status = "Одобрено";
        $bg_color = 'background: green';
        $user_name = $row['user_name'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_desc = $row['product_desc'];
        $product_category = $row['product_category'];
        $bd_id = $row['id'];
        $user_id = $row['user_id'];
        $random_numb = $row['random_id_product'];
        $date_moderate = date($row['date_moder']);
        $var_date= new DateTime($date_moderate);
        $date_moderate = $var_date->format('d.m.Y');
        $moderator_name = $row['moderator_name'];
        $today = date('Y-m-d');
        $services_arr[] = '
        <div class="moderate_item" id="moderate_item"  data-itemid="'.$i.'">
          <h4 class="moderate_item_title">'.$product_name.'</h4>
          <p class="moderate_item_price">Стоимость '.$product_price.' бонусов</p>
          <p class="moderate_item_category">Категория: '.$product_category.'</p>
          <p class="status_mod" style="'.$bg_color.';">'.$status.'</p>
          <p class="date_moderate">Дата модерации: '.$date_moderate.'</p>
          <p class="moderator_name">Имя модератора: '.$moderator_name.'</p>
          
          <p class="moderate_user_name">Пользователь:<a href="https://'.$domain.'/company/personal/user/'.$user_id.'/" target="_blank"> '.$user_name.'</a></p>
          <div class="btn_moderate_modal">Подробнее</div>
          <div class="moderate_item_modal" data-itemid="'.$i.'">
            <h4 class="moderate_item_modal_title">'.$product_name.'</h4>
            <p class="moderate_item_modal_category">Категория: '.$product_category.'</p>
            <p class="moderate_item_modal_desc">'.$product_desc.'</p>
            <p class="moderate_item_modal_price">Стоимость '.$product_price.' бонусов</p>

            <div class="btn_moderate_modal_close">
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
} else if($data_modarate == 'rejected_requests') {
  $sql = "SELECT * FROM `moderate_service`";
  $result;
  $services_arr = array();
  $i = 1;
  if($result = $conn->query($sql)) {
    foreach($result as $row) {
      $status = $row['status_mod'];
      if($status == '2'){
        $status = "Отклонено";
        $bg_color = 'background: red';
        $user_name = $row['user_name'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_desc = $row['product_desc'];
        $product_category = $row['product_category'];
        $bd_id = $row['id'];
        $user_id = $row['user_id'];
        $random_numb = $row['random_id_product'];
        $date_moderate = date($row['date_moder']);
        $var_date= new DateTime($date_moderate);
        $date_moderate = $var_date->format('d.m.Y');

        $moderator_name = $row['moderator_name'];
        $today = date('Y-m-d');
        $services_arr[] = '
        <div class="moderate_item" id="moderate_item"  data-itemid="'.$i.'">
          <h4 class="moderate_item_title">'.$product_name.'</h4>
          <p class="moderate_item_price">Стоимость '.$product_price.' бонусов</p>
          <p class="moderate_item_category">Категория: '.$product_category.'</p>
          <p class="status_mod" style="'.$bg_color.';">'.$status.'</p>
          <p class="date_moderate">Дата модерации: '.$date_moderate.'</p>
          <p class="moderator_name">Имя модератора: '.$moderator_name.'</p>
          <p class="moderate_user_name">Пользователь:<a href="https://'.$domain.'/company/personal/user/'.$user_id.'/" target="_blank"> '.$user_name.'</a></p>
          <div class="btn_moderate_modal">Подробнее</div>
         
          <div class="moderate_item_modal" data-itemid="'.$i.'">
            <h4 class="moderate_item_modal_title">'.$product_name.'</h4>
            <p class="moderate_item_modal_category">Категория: '.$product_category.'</p>
            <p class="moderate_item_modal_desc">'.$product_desc.'</p>
            <p class="moderate_item_modal_price">Стоимость '.$product_price.' бонусов</p>

            
            <div class="btn_moderate_modal_close">
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
}


