<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>Генератор почтовых подписей</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="./css/style.css" />
		<script src="/js/jquery-1.6.2.js" type="text/javascript"></script>
		
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					
				</div>
				
			</div>
			<div id="page">
				<div id="content">
					<div class="box">
						
						<div class="header-title">
							<h1>Генератор почтовой подписи</h1>
							
							<form id="login" name="input" action="mail_generator.php" method="get">
						    <h1>Введите свои данные</h1>
						    <fieldset id="inputs">
						        <input id="username" type="text" name="surname" placeholder="Фамилия" autofocus required >   
						        <input id="username" type="text" name="name" placeholder="Имя"  required>
						        <input id="username" type="text" name="lastname" placeholder="Отчество"  required> 
						        <input id="username" type="text" name="job" placeholder="Должность"  required> 
						        <input id="username" type="text" name="department" placeholder="Отдел (если необходимо)"  >
						        <input id="username" type="text" name="telephone" placeholder="Телефон"  required> 
						        <input id="username" type="text" name="email" placeholder="Email"  required>
						        <label id="imagelabel" for="check1">Нужна ли картинка?: </label>
						        <input id="checkbox" type="checkbox" name="image" value="1">
							          
						    </fieldset>
						    <fieldset id="actions">
						        <input type="submit" id="submit" value="Выдать подпись">
						       
						    </fieldset>
							</form>
							</div>	
						
					</div>
					<br class="clearfix" />
				</div>
				<br class="clearfix" />
			</div>
			
		</div>
		<div id="footer">
			<a href="/">Областное государственное казенное учреждение Челябинской области "Центр обработки вызовов системы 112-Безопасный регион"</a> &copy; 2017</a>
		</div>
	</body>
</html>