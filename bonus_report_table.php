<?
require_once (__DIR__.'/crest.php');
require_once (__DIR__.'/db_conn.php');

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
$result_arr = Array();
$total_product = 0;
$sql_total = "SELECT * FROM `serviceslist`";
if($result_total = $conn->query($sql_total)) {
  foreach($result_total as $row) {
    $status_mod = $row['status_mod'];
    if($status_mod == '1') {
      $total_product_price += $row['product_price'];
    }
  }
}
foreach($product_section['result'] as $product) {
  if($product['NAME'] == 'Бонусы') {

  } else {
    $sql = "SELECT * FROM `serviceslist`";
   
    $i = 0;
    if($result = $conn->query($sql)) {
      foreach($result as $row) {
        $product_category = $row['product_category'];
        $status_mod = $row['status_mod'];
        if($product_category == $product['NAME'] && $status_mod == '1') {
          $i += $row['product_price'];
        }
      }
      
      $percent_category = round(100/(int)$total_product_price*(int)$i); 
      $prod_name = $product['NAME'];
      $info_stat_product = '<tr><td>'.$product['NAME'].'</td><td>'.$i.'</td><td>'.$percent_category.'%</td></tr>';
      $result_arr[] = $info_stat_product;
    }
  }
}
$str_arr = implode($result_arr);
echo $str_arr;




