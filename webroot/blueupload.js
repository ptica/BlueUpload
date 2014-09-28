$(function () {
	'use strict';
	// MODULE: blueimp/jQuery-File-Upload
	$('input[data-provide=fileupload]').fileupload({
		dataType: 'json',
		done: function (e, data) {
			$.each(data.result.files, function (index, file) {
				if (file.type.match(/^image/)) {
					$('.blueupload .thumbnails').append(App.render['BlueUpload/image-edit'](file));
				} else {
					$('.blueupload .thumbnails').append(App.render['BlueUpload/file-edit'](file));
				}
				console.log(file);
			});
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#progress .progress-bar').css(
				'width', progress + '%'
			);
		}
	}).prop('disabled', !$.support.fileInput)
	.parent().addClass($.support.fileInput ? undefined : 'disabled');

	$('.blueupload .thumbnails').on('click', '[data-delete]', function() {
		// delete icon handler
		var deleteUrl  = this.getAttribute('data-delete-url');
		var deleteType = this.getAttribute('data-delete-type');
		if (deleteUrl) {
			$.ajax(deleteUrl, {type:deleteType}).done(function (data) {
				console.log(data);
			})
			.fail(function () {

			});
		}
	});
});
