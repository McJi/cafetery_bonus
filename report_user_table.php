<?
require_once (__DIR__.'/crest.php');
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];
$period = $_POST['period'];


$result_arr = Array();
$result_arr[] = '<table class="report_bonus" style="
    width: 100%; border-bottom: 1px solid #000;">
          <thead style="border-bottom: 1px solid #000;text-align: center;">
            <tr>
              <td>Услуга</td>
              <td>Стоимость</td>
              <td>Дата получения</td>
              <td>Категория</td>
            </tr>
          </thead>
          <tbody class="table_category_user">';

$total_price = 0;

$sql = "SELECT * FROM `historyuser`";

if($result = $conn->query($sql)) {
  foreach($result as $row) {
    if($row['type_history'] == 'Списание' && $user_id == $row['user_id']) {
      $date = explode('-', $row['date']);
      if($period == 'year') {
        $year = (int)$_POST['year'];
        if((int)$date[0] == $year) {
          $total_price += $row['service_price'];
          $info_stat_product = '<tr style="text-align:center;"><td>'.$row['service_title'].'</td><td>'.$row['service_price'].'</td><td>'.$row['date'].'</td><td>'.$row['product_category'].'</td></tr>';
          $result_arr[] = $info_stat_product;
        }
      } else if($period == 'month') {
        $year = (int)$_POST['year'];
        $month = (int)$_POST['month'];
         if((int)$date[0] == $year && (int)$date[1] == $month) {
          $total_price += $row['service_price'];
          $info_stat_product = '<tr style="text-align:center;"><td>'.$row['service_title'].'</td><td>'.$row['service_price'].'</td><td>'.$row['date'].'</td><td>'.$row['product_category'].'</td></tr>';
          $result_arr[] = $info_stat_product;
        }
      }
    }
  }
}
$result_arr[] = '</tbody>
        </table>
        <div> Всего потрачено: '.$total_price.'</div>';
$str_arr = implode($result_arr);
echo $str_arr;




