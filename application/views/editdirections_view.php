<script type="text/javascript" src="js/jquery.stickytableheaders.js"></script>
<script type="text/javascript">
	
	$(function () {
    $("table").stickyTableHeaders();
});
</script>
<?php

$locations_count=$count[0];
$posts_count=$count[1];
$directions_count=$count[2];
$device_list_count=$count[3];


?>

<div class="tabs">
							<ul class="nav nav-tabs">
								<li ><a href="/editlocations">Внесение данных городов<span class="badge"><?php echo $locations_count; ?></span></a></li>
								<li ><a href="/editposts">Внесение данных постов<span class="badge"><?php echo $posts_count; ?></span></a></li>
								<li class="active"><a>Внесение данных направлений<span class="badge"><?php echo $directions_count; ?></span></a></li>
								<li><a>Внесение данных Приборов<span class="badge"><?php echo $device_list_count; ?></span></a></li>
							</ul>
						</div>

<div id="edit_form_editdirections" class="clearfix">
    <form id="editdirections_form"  action="/editdirections/getselectdata" method="post">
    	<h2 align="center">Введите данные направления для добавления</h2>
    	<div id="edit_form_editdirections_inputblock" >
    		<div class="edit_form_editdirections_block_text_input">
    		<div class="select">
		    	<select  name="location_id" id="locations">
		    	<option value="0">Выберите город из списка</option>
		    	<?php
		    		foreach ($data[0] as $locations){
		    			echo '<option value="'.$locations['location_id'].'">'.$locations['location_name'].'</option>';
		    		}
		    	?>
		    	</select>
	    	</div>
	    	<div class="select">
		    	<select  name="location_id" id="posts" disabled>
		    	<option>Выберите пост из списка</option>
		    	
		    	</select>
	    	</div>

	    	</div>
	    	<div class="edit_form_editdirections_block_text_input">
	    		<input class="edit_form_editdirections_inputs" type="text" name="post_number" class="flowerValidation" placeholder="Введите название направления"  >
	    	</div>
	    	
		    <div class="edit_form_editdirections_block_text_input">
		    	<input class="edit_form_editdirections_inputs" type="text" name="post_address" placeholder="Введите количество полос направления"  >  
		    </div> 
		    <input type="submit" id="edit_form_editdirections_submit"  value="Добавить направление">
        </div>      
    </form>

</div>

<div class="panel panel-warning">
  <div class="panel-heading">
    <h3 align="center" class="panel-title">Вывод направлений:</h3>
  </div>
  <div class="panel-body">
   		 <?php
global $i;
$i=1;
foreach ($data[0] as $locations) {
	
	
	
	
	echo '<div class="table-responsive">';
	echo '<table class="tableposts table col-lg-12 col-md-12 col-xs-12">';
	
	echo '<thead>';
	echo '<tr class="do-yellow" align="center" ><th colspan=\'5\'><h4>'.$locations['location_name'].'</h4></th></tr>';
	echo '<tr class="do-red "  ><th class="col-lg-1 col-md-1 col-xs-1 col-sm-1">Запись</th><th class="col-lg-1 col-md-1 col-xs-1 col-sm-1">Номер поста</th><th class="col-lg-4 col-md-4 col-xs-4 col-sm-4">Наименование</th><th class="col-lg-4 col-md-4 col-xs-4 col-sm-4">Адрес поста</th></tr>';
	echo '</thead>';	
		foreach($data[1] as $posts){

			foreach($data[2] as $location_post_consistency){

				if(($location_post_consistency['location_post_consistency_location_id']==$locations['location_id']) and ($location_post_consistency['location_post_consistency_post_id']==$posts['post_id'])){
					echo '<tr class="do-blue" data-id="'.$posts['post_id'].'" align="center"><td>'.$i++.'</td><td data-post-number="'.$posts['post_number'].'">'.$posts['post_number'].'</td><td data-post-name="'.$posts['post_name'].'">'.$posts['post_name'].'</td><td data-post-address="'.$posts['post_address'].'">'.$posts['post_address'].'</td></tr>';
					echo '<tr><td colspan=\'4\'>';
					echo '<p id="direction">Направления:<p>';
					echo '<table>';
					foreach($data[3] as $directions){
						if($directions['direction_owner_post_id']==$posts['post_id']){

							
							echo '<input class="hide" id="hd-'.$directions['direction_id'].'" type="checkbox"><label for="hd-'.$directions['direction_id'].'">';
							echo $directions['direction_name'].' |<span class="bold">Количество полос: '.$directions['direction_stripe_count'].'</span><br>';
					}
					
					echo '</table>';
					echo '</td></tr>';		
		}
	}
	}
	 
	echo '</table>';
	echo '</div>';
	
    
}}?>
  </div>
</div> 
<script type="text/javascript" src="js/editdirections_select.js"></script>
