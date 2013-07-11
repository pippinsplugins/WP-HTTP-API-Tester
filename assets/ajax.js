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
					//var body = JSON.stringify( response.body, undefined, 4);
					$('#wp-http-api-tester-response-wrapper').slideDown();
					$('#response-message').html( response.message );
					$('#response-code').html( response.code );
					$('#response-body').html( '<pre>' + wp_http_api_highlight_syntax( response.body ) + '</pre>' );
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

function wp_http_api_highlight_syntax(json) {
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        var cls = 'number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'key';
            } else {
                cls = 'string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'boolean';
        } else if (/null/.test(match)) {
            cls = 'null';
        }
        return '<span class="' + cls + '">' + match + '</span>';
    });
}