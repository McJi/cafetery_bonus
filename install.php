<?php
require_once (__DIR__.'/crest.php');
require_once (__DIR__.'/db_conn.php');
$result = CRest::installApp();

if($result['rest_only'] === false):?>
	<head>
		
		<?php if($result['install'] == true):?>
			<script src="//api.bitrix24.com/api/v1/"></script>
			<script>
				BX24.init(function(){
					BX24.installFinish();
				});
			</script>
		<?php endif;?>
	</head>
	<body>
		<?php if($result['install'] == true):?>
			<?
				$section_product_add = CRest::call(
					'crm.productsection.add',
					[
						'NAME' => 'Бонусы',
						'SECTION_ID' => 0,
					]
				);
				$section_id = $section_product_add['result'];
				$sql = "INSERT INTO `administration`(`section_main_id`) VALUES ('$section_id')";
			?>
			installation has been finished
		<?php else:?>
			installation error
		<?php endif;?>
	</body>
<?php endif;







