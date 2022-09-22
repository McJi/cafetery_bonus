<?
require_once (__DIR__.'/crest.php');

$product_id = $_POST['product_id'];
$section_service = $_POST['section_service'];
$name_service = $_POST['name_service'];
$price_service = $_POST['price_service'];
$description_service = $_POST['description_service'];

$edit_product = CRest::call(
  'crm.product.update',
  [
    'ID' => $product_id,
    'fields' => [
      'PRICE' => $price_service,
      'NAME' => $name_service,
      'DESCRIPTION' => $description_service,
      'SECTION_ID' => $section_service 
    ]
  ]
);

echo $edit_product['error_description'];