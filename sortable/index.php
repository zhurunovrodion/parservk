<?php header("Content-Type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


 <link rel="stylesheet" href="css/jquery.ui.theme.css">
 <link rel="stylesheet" href="css/demos.css">

 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
  <script type="text/javascript" src="sortable.js"></script>
 <style>
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 300px; }
	#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px;  padding-bottom: 10px;   }
	#sortable li span { position: absolute; margin-left: -1.3em; }
 </style>


</head>
<body>

<div class="demo">
    <form id="itemslist">

        <ul id="sortable">

        <?php
        include("db.php");
                $query  = "SELECT listorder FROM sortable";
                $result = mysql_query($query) or die ($error . 'Ошибка - '.mysql_error());
                $row = mysql_fetch_array($result) ;
                $items = unserialize($row['listorder']);

        foreach ($items as $key => $value)  { ?>
                <li class="ui-state-default">
                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                <input type="text" value="<?php echo $value; ?>" name="items[<?php echo $i; ?>]" />
                </li>
                <?php } ?>
        </ul>

    </form>

    <div id="response"></div>

</div><!-- End demo -->

</body>
</html>