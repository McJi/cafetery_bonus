<?
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];
$type_bonus = $_POST['type_bonus'];
$filter_category = $_POST['filter_category'];
$history_arr = array();
if($type_bonus == 'Все' && $filter_category == 'Все') {
  $sql = "SELECT * FROM `historyuser`";
  $result;
  $add_bonus = 0;
  $get_bonus = 0;
  if($result = $conn->query($sql)) {
    $history_arr[] = '<table style="width:100%; border-bottom: 1px solid #000; margin-bottom: 20px;">
                        <thead class="history_container_title">
                          <tr>
                            <td>
                              Название услуги
                            </td>
                            <td>
                              Стоимость услуги
                            </td>
                            <td>
                              Дата получения
                            </td>
                            <td>
                              Тип
                            </td>
                            <td>
                              Категория товара
                            </td>
                          </tr>
                        </thead>
                        <tbody>';
    foreach($result as $row) {
      $user_id_bd = $row['user_id'];
      if($user_id_bd == $user_id) {
        $service_title = $row['service_title'];
        $service_price = $row['service_price'];
        $service_desc = $row['service_desc'];
        $service_date = $row['date'];
        $service_type = $row['type_history'];
        $product_category = $row['product_category'];
        if($service_type == "Списание") {
          $get_bonus += $service_price;
        } else if($service_type == "Начисление") {
          $add_bonus += $service_price;
        }
        
        $history_arr[] = '<tr class="history_item" data-category="'.$product_category.'" data-date="'.$service_date.'">
                            <td>'.$service_title.'</td>
                            <td>'.$service_price.'</td>
                            <td>'.$service_date.'</td>
                            <td>'.$service_type.'</td>
                            <td>'.$product_category.'</td>
                          </tr>';
      }
    }
    $history_arr[] = '</tbody></table><div class="info_bonus_get"><p><b> Всего начислений:</b> '.$add_bonus.'</p><p><b>Всего списаний:</b> '.$get_bonus.'</p></div>';
  }
} else if($type_bonus == 'Списание') {
  $sql = "SELECT * FROM `historyuser`";
  $result;
  
  $get_bonus = 0;
  if($result = $conn->query($sql)) {
    $history_arr[] = '<table style="width:100%; border-bottom: 1px solid #000; margin-bottom: 20px;">
                        <thead class="history_container_title">
                          <tr>
                            <td>
                              Название услуги
                            </td>
                            <td>
                              Стоимость услуги
                            </td>
                            <td>
                              Дата получения
                            </td>
                            <td>
                              Тип
                            </td>
                            <td>
                              Категория товара
                            </td>
                          </tr>
                        </thead>
                        <tbody>';
    foreach($result as $row) {
      $user_id_bd = $row['user_id'];
      if($user_id_bd == $user_id) {
        $service_title = $row['service_title'];
        $service_price = $row['service_price'];
        $service_desc = $row['service_desc'];
        $service_date = $row['date'];
        $service_type = $row['type_history'];
        $product_category = $row['product_category'];
        
        if($service_type == $type_bonus) {
          if($filter_category == 'Все') {
            $get_bonus += $service_price;
            $history_arr[] = '<tr class="history_item" data-category="'.$product_category.'" data-date="'.$service_date.'">
                              <td>'.$service_title.'</td>
                              <td>'.$service_price.'</td>
                              <td>'.$service_date.'</td>
                              <td>'.$service_type.'</td>
                              <td>'.$product_category.'</td>
                            </tr>';
          } else if($filter_category == $product_category) {
            $get_bonus += $service_price;
            $history_arr[] = '<tr class="history_item" data-category="'.$product_category.'" data-date="'.$service_date.'">
                              <td>'.$service_title.'</td>
                              <td>'.$service_price.'</td>
                              <td>'.$service_date.'</td>
                              <td>'.$service_type.'</td>
                              <td>'.$product_category.'</td>
                            </tr>';
          }
        }
      }
    }
    $history_arr[] = '</tbody></table><div class="info_bonus_get"><p><b>Всего списаний:</b> '.$get_bonus.'</p></div>';
  }
} else if($type_bonus == 'Начисление') {
  $sql = "SELECT * FROM `historyuser`";
  $result;
  
  $add_bonus = 0;
  if($result = $conn->query($sql)) {
    $history_arr[] = '<table style="width:100%; border-bottom: 1px solid #000; margin-bottom: 20px;">
                        <thead class="history_container_title">
                          <tr>
                            <td>
                              Название услуги
                            </td>
                            <td>
                              Стоимость услуги
                            </td>
                            <td>
                              Дата получения
                            </td>
                            <td>
                              Тип
                            </td>
                            <td>
                              Категория товара
                            </td>
                          </tr>
                        </thead>
                        <tbody>';
    foreach($result as $row) {
      $user_id_bd = $row['user_id'];
      if($user_id_bd == $user_id) {
        $service_title = $row['service_title'];
        $service_price = $row['service_price'];
        $service_desc = $row['service_desc'];
        $service_date = $row['date'];
        $service_type = $row['type_history'];
        $product_category = $row['product_category'];
        
        if($service_type == $type_bonus) {
          if($filter_category == 'Все') {
            $add_bonus += $service_price;
            $history_arr[] = '<tr class="history_item" data-category="'.$product_category.'" data-date="'.$service_date.'">
                              <td>'.$service_title.'</td>
                              <td>'.$service_price.'</td>
                              <td>'.$service_date.'</td>
                              <td>'.$service_type.'</td>
                              <td>'.$product_category.'</td>
                            </tr>';
          } else if($filter_category == $product_category) {
            $add_bonus += $service_price;
            $history_arr[] = '<tr class="history_item" data-category="'.$product_category.'" data-date="'.$service_date.'">
                              <td>'.$service_title.'</td>
                              <td>'.$service_price.'</td>
                              <td>'.$service_date.'</td>
                              <td>'.$service_type.'</td>
                              <td>'.$product_category.'</td>
                            </tr>';
          }
        }
      }
    }
    $history_arr[] = '</tbody></table><div class="info_bonus_get"><p><b> Всего начислений:</b> '.$add_bonus.'</p></div>';
  }
} else {
  $sql = "SELECT * FROM `historyuser`";
  $result;
  $add_bonus = 0;
  $get_bonus = 0;
  if($result = $conn->query($sql)) {
    $history_arr[] = '<table style="width:100%; border-bottom: 1px solid #000; margin-bottom: 20px;">
                        <thead class="history_container_title">
                          <tr>
                            <td>
                              Название услуги
                            </td>
                            <td>
                              Стоимость услуги
                            </td>
                            <td>
                              Дата получения
                            </td>
                            <td>
                              Тип
                            </td>
                            <td>
                              Категория товара
                            </td>
                          </tr>
                        </thead>
                        <tbody>';
    foreach($result as $row) {
      $user_id_bd = $row['user_id'];
      if($user_id_bd == $user_id) {
        $service_title = $row['service_title'];
        $service_price = $row['service_price'];
        $service_desc = $row['service_desc'];
        $service_date = $row['date'];
        $service_type = $row['type_history'];
        $product_category = $row['product_category'];
        
        if($product_category == $filter_category) {
          if($service_type == "Списание") {
            $get_bonus += $service_price;
          } else if($service_type == "Начисление") {
            $add_bonus += $service_price;
          }
          $history_arr[] = '<tr class="history_item" data-category="'.$product_category.'" data-date="'.$service_date.'">
                            <td>'.$service_title.'</td>
                            <td>'.$service_price.'</td>
                            <td>'.$service_date.'</td>
                            <td>'.$service_type.'</td>
                            <td>'.$product_category.'</td>
                          </tr>';
        }
        
      }
    }
    $history_arr[] = '</tbody></table><div class="info_bonus_get"><p><b> Всего начислений:</b> '.$add_bonus.'</p><p><b>Всего списаний:</b> '.$get_bonus.'</p></div>';
  }
}



$services_str = implode($history_arr);
echo $services_str;