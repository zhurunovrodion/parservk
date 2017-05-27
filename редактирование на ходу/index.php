<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Встроенное редактирование средствами jQuery и PHP</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript">

$(document).ready(function () {

    function slideout() {
        setTimeout(function () {
            $("#response").slideUp("slow", function () {});
        },
        2000);
    }

    $(".inlineEdit").bind("click", updateText);

    var OrigText, NewText;

    $(".save").live("click", function () {

        $("#loading").fadeIn('slow');

        NewText = $(this).siblings("form").children(".edit").val();
        var id = $(this).parent().attr("id");
        var data = '?id=' + id + '&text=' + NewText;

        $.post("update.php", data, function (response) {
            $("#response").html(response);
            $("#response").slideDown('slow');
            slideout();
            $("#loading").fadeOut('slow');

        });

        $(this).parent().html(NewText).removeClass("selected").bind("click", updateText);

    });

    $(".revert").live("click", function () {
        $(this).parent().html(OrigText).removeClass("selected").bind("click", updateText);
    });



    function updateText() {

        $('li').removeClass("inlineEdit");
        OrigText = $(this).html();
        $(this).addClass("selected").html('<form ><textarea class="edit">' + OrigText + '" </textarea> </form><a href="#" class="save"><img src="images/save.png" border="0" width="48" height="15"/></a> <a href="#" class="revert"><img src="images/cancel.png" border="0" width="58" height="15"/></a>').unbind('click', updateText);

    }
});
</script>
<style>
a {
	color: #000;
}
a:hover {
	color: #333;
}
a:hover {
	text-decoration: none;
}
.edit {
	width: 326px;
	height: 140px;
	padding: 8px;
	line-height:20px;
	background-color: #fff;
	border: 2px solid #FFFF33;
	margin:2px;
}
ul {
	list-style: none;
}
li {
	width: 360px;
	min-height: 20px;
	padding: 10px 30px 10px 10px;
	margin: 5px;
}
li:hover {
	background-image:url(images/edit.png);
	background-repeat:no-repeat;
	background-position:right;
	cursor:pointer;
}
li.selected:hover {
	background-image:none;
}
li.selected {
	padding: 10px;
	width: 360px;
	background-color: #FFFF99;
	border:1px #FFFF33 solid;
}
form {
	width: 100%;
}
.save, .btnCancel {
	margin:0px 0px 0 5px;
}
#response {
	display:none;
	padding:10px;
	background-color:#9F9;
	border:2px solid #396;
	margin-bottom:20px;
}
#loading {
	display:none;
}
</style>
</head>
<body>

<h2>Встроенное редактирование средствами jQuery и PHP<img id="loading" src="images/loading.gif"/></h2>
Нажмите на контейнер.
<div id="response"></div>
<ul>
  <li class="inlineEdit" id="1"><img src='http://papermashup.com/wp-content/themes/arthemia/images/me.png' width='113' height='113' style='float:left; margin:0px 10px 10px 0px'/>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</li>
</ul>

</body>
</html>