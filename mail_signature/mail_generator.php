
<?php
$name=$_GET['name'];
$surname=$_GET['surname'];
$lastname=$_GET['lastname'];
$department=$_GET['department'];
$job=$_GET['job'];
$telephone=$_GET['telephone'];
$email=$_GET['email'];
$image=$_GET['image'];



echo '<p>С уважением,<p>';
echo '<table cellpadding="0" cellspacing="0" border="0" style="background: none; border-width: 0px; border: 0px; margin: 0; padding: 0; width:677px">';
if ($image==1)
echo '<tr><td colspan="2" style="padding-bottom: 5px;"><img src="http://www.imageup.ru/img178/2747058/logotip-cov-112.gif"></td></tr>';
echo '<tr><td colspan="2" style="padding-bottom: 5px; color: #F7751F; font-size: 18px; font-family: Arial, Helvetica, sans-serif;">'.$surname.' '.$name.' '.$lastname.'</td></tr>';
if(!empty($job))
echo '<tr><td colspan="2" style="color: #333333; font-size: 14px; font-family: Arial, Helvetica, sans-serif;"><i>'.$job.'</i></td></tr>';
if(!empty($department))
echo '<tr><td colspan="2" style="color: #333333; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">'.$department.'</td></tr>';
echo '<tr><td colspan="2" style="color: #333333; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">Областное государственное казенное учреждение Челябинской области</td></tr>';
echo '<tr><td colspan="2" style="color: #333333; font-size: 14px; font-family: Arial, Helvetica, sans-serif;"><strong>«Центр обработки вызовов Системы 112 – Безопасный регион»</strong></td></tr>';
echo '<tr><td  width="20" valign="top" style="vertical-align: top; width: 20px; color: #F7751F; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">телефон:<span valign="top" style="vertical-align: top; color: #333333; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">'.$telephone.'&nbsp;&nbsp;</span><span style="color: #F7751F;">email:&nbsp;</span><a href="mailto:'.$email.'" style="color: #1da1db; text-decoration: none; font-weight: normal; font-size: 14px;">'.$email.'</a></td></tr>';
echo '</table>';

?>