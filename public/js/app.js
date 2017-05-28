var download_image;

function get_url(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			download_image = e.target.result;
		}
		reader.readAsDataURL(input.files[0]);
	}
}

$('input#image').on('change', function() {
	get_url($('input#image')[0]);
});

$('#preview').on('click', function() {
	$('#preview_modal .preview_name').text($('input[name="name"]').val());
	$('#preview_modal .preview_email').text($('input[name="email"]').val());
	$('#preview_modal .preview_text').text($('textarea[name="text"]').val());
	$('#preview_modal img').attr('src', download_image);
	$('#preview_modal').modal('show');
});