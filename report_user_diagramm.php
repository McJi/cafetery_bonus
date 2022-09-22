<?
require_once (__DIR__.'/crest.php');
require_once (__DIR__.'/db_conn.php');
$user_id = $_POST['user_id'];
$period = $_POST['period'];
$sql_section_get = 'SELECT * FROM `administration`';

if($result = $conn->query($sql)) {
  foreach($result as $row) {
    $section_id_main = $row['section_main_id'];
  }
};

$product_section = CRest::call(
  'crm.productsection.list',
  [
    'filter' => [
      'SECTION_ID' => $section_id_main
    ]
  ]
);

$total_product = 0;
$sql_total = "SELECT * FROM `serviceslist`";
if($result_total = $conn->query($sql_total)) {
  foreach($result_total as $row) {
    $status_mod = $row['status_mod'];
    $date = explode('-', $row['date']);
    if($status_mod == '1' && $user_id == $row['user_id']) {
      if($period == 'year') {
        $year = (int)$_POST['year'];
        if((int)$date[0] == $year) {
          $total_product++;
        }
      } else if($period == 'month') {
        $year = (int)$_POST['year'];
        $month = (int)$_POST['month'];
         if((int)$date[0] == $year && (int)$date[1] == $month) {
           $total_product++;
        }
      }
      
    }
  }
}
$arr_result = Array();
foreach($product_section['result'] as $product) {
  if($product['NAME'] == 'Бонусы') {

  } else {
    $sql = "SELECT * FROM `serviceslist`";
   
    $i = 0;
    if($result = $conn->query($sql)) {
      foreach($result as $row) {
        $product_category = $row['product_category'];
        $status_mod = $row['status_mod'];
        $date = explode('-', $row['date']);
        if($product_category == $product['NAME'] && $status_mod == '1' && $user_id == $row['user_id']) {
          if($period == 'year') {
            $year = (int)$_POST['year'];
            if((int)$date[0] == $year) {
              $i++;
            }
          } else if($period == 'month') {
            $year = (int)$_POST['year'];
            $month = (int)$_POST['month'];
            if((int)$date[0] == $year && (int)$date[1] == $month) {
              $i++;
            }
          }
          
        }
      }
      
      $percent_category = round(100/(int)$total_product*(int)$i); 
      $prod_name = $product['NAME'];
      $arr_item = [label => $prod_name , y => $percent_category];
      $arr_result[] = $arr_item;
    }
  }
}
$json_arr = json_encode($arr_result);
echo $json_arr;




