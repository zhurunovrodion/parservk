function update(){
var order = 'update=update&' + $('#itemslist').serialize();
$.post("update.php", order, function(data){
        $('#response').html(data).fadeIn(1000);
		setTimeout(function(){
		        $('#response').fadeOut(1000);}, 1000);
        });
                }

$(function(){
$('#response').hide();
$('#sortable').sortable({ opacity: 0.8, cursor: 'move', update: function(){update();}});
$('#sortable input').change( function(){update();});
});