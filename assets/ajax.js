jQuery(document).ready(function ($) {
	$('#wp-http-api-tester-form').submit(function( e ) {

		e.preventDefault();

		$('#wp-http-api-tester-response-wrapper').hide();
		$('#wp-http-test-loader').show();

		var $this = $(this),
			data = {
				action: 'http_api_test',
				data: $this.serialize()
			};

		$.ajax({
			type: "POST",
			data: data,
			dataType: "json",
			url: ajaxurl,
            success: function (response) {
				$('#wp-http-test-loader').hide();
				if( response ) {
					$('#wp-http-api-tester-response-wrapper').slideDown();
					$('#response-message').html( response.message );
					$('#response-code').html( response.code );
					$('#response-body').html( response.body );
					$('#response-errors').html('');
					$("#response-headers").html('');
					$.each(response.headers, function(k, v){
						$("#response-headers").append('<strong>'+k+'</strong>: '+v+'<br/>');
					});
					$.each(response.errors, function(k, v){
						$("#response-errors").append('<strong>'+k+'</strong>: '+v+'<br/>');
					});
				}
			}
        }).fail(function (response) {
            console.log(response);
        });

	});
});