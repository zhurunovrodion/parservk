$(function() {
	$("#editpost_form").validate({
		 rules: {
		 	post_number: {
		 		required: true,
		 		digits: true

		 	},
		 	post_name: {
		 		required: true
		 	},
		 	post_address: {
		 		required: true
		 	}
		 },
		 messages: {
		 	post_number: {
		 		required: "Обязательно для заполнения",
		 		digits: "Должно содержать только цифры"
		 	}
		 }
	});

});