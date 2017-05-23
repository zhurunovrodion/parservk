<script type="text/javascript" src="js/jquery.stickytableheaders.js"></script>
<script type="text/javascript">
	
	$(function () {
    $("table").stickyTableHeaders();
});
</script>

<?php
function doda($data){
	if ($data=1){
		return 'в наличии';
	}else {
		return 'отсутствует';
	}
}

function dodate($date, $yes){
    if ($yes==1){
    	$date=date("d.m.Y", $date);
    	return $date;
    }
	if(($date-time())<=7776000){
		$date=date("d.m.Y", $date);
		return '<b>'.$date.'<br></b><font color="red"><b>   Скоро поверка!</b></font>';
	}
	else{
		$date=date("d.m.Y", $date);
		return $date.'<br><font color="green;">   До поверки еще долго</font>'; 
	}
	}

//print_r($data[4]);
foreach ($data[1] as $locations) {
	echo '<h1 align="center">'.$locations['location_name'].'</h1>';
	echo '<table class="col-lg-12 col-md-12 col-xs-12">';
	echo '<thead>';
	echo '<tr class="do-red"><th class="col-lg-1">Запись</th><th class="col-lg-1" >Номер поста</th><th class="col-lg-5">Наименование</th><th class="col-lg-5">Адрес поста</th></tr>';
	echo '</thead>';
		foreach($data[0] as $posts){
			foreach($data[2] as $location_post_consistency){
				
				if(($location_post_consistency['location_post_consistency_location_id']==$locations['location_id']) and ($location_post_consistency['location_post_consistency_post_id']==$posts['post_id']))
				{
				
				echo '<tr class="do-blue" align="center"><td>'.$posts['post_id'].'</td><td>'.$posts['post_number'].'</td><td>'.$posts['post_name'].'</td><td>'.$posts['post_address'].'</td></tr>';
					
					echo '<tr><td colspan=\'4\'>';
					echo '<p id="direction">Направления:<p>';
					echo '<table>';
					
					foreach($data[3] as $directions){
						if($directions['direction_owner_post_id']==$posts['post_id']){

							echo '<tr><td class="privet">';
							echo '<input class="hide" id="hd-'.$directions['direction_id'].'" type="checkbox"><label for="hd-'.$directions['direction_id'].'">';
							echo $directions['direction_name'].' |<span class="bold">Количество полос: '.$directions['direction_stripe_count'].'</span><br>';
							echo '</label>';
							echo '<div class="table-responsive">';
							echo '<table class="cool table-bordered table" >';
							echo '<tr><th>Полоса</th><th>Наименование, тип СИ</th><th>Серийный номер</th><th>паспорт</th><th>Сертификат поверки</th><th>Идентификатор камеры для столбца "Серия и номер прибора" ПО "Ангел"</th><th>Идентификационный номер СИ</th><th>Номер по Государственному реестру СИ</th><th>Год выпуска СИ</th><th>класс точности, погрешность</th><th>предел (диапазон) измерений</th><th>Периодичность поверки, месяцев</th><th>Дата последней поверки</th><th>Сроки проведения поверки</th></tr>'; 
							foreach ($data[4] as $pribors) {
								if($pribors['stripe_owner_direction_id']==$directions['direction_id']){
								echo '<tr>';	
								echo '<td>'.$pribors['stripe_number'].' '.'полоса'.'</td><td>'.$pribors['device_list_name'].'</td><td>'.$pribors['device_serial_number'].'</td><td>'.doda($pribors['device_passport_availability']).'</td><td>'.$pribors['device_certificate_verification_number'].'</td><td>'.$pribors['device_camera_id'].'</td><td>'.$pribors['device_identification_mi_number'].'</td><td>'.$pribors['device_list_state_registry_number'].'</td><td>'.$pribors['device_release_year'].'</td><td>'.$pribors['device_list_accuracy_class'].'</td><td>'.$pribors['device_list_measurement_range'].' км/ч</td><td>'.$pribors['device_list_periodicity_verification'].'</td><td>'.dodate($pribors['device_date_last_calibration'], 1).'</td><td>'.dodate($pribors['device_date_next_calibration'], 0).'</td>';
								echo '<tr>';	
								}
							}
							echo '</table>';
							echo '</div>'; 
							echo '</td><tr>';
							
							
						}
					}
					
					echo '</table>';
					echo '</td></tr>';
				}
			}
		}
	echo '</table>';
}
?>
</div>
</p>