$(function () {
	'use strict';
	// MODULE: blueimp/jQuery-File-Upload
	$('input[data-provide=fileupload]').fileupload({
		dataType: 'json',
		done: function (e, data) {
			$.each(data.result.files, function (index, file) {
				if (file.type.match(/^image/)) {
					$('.blueupload .thumbs').append(App.render['BlueUpload/image'](file));
				} else {
					$('.blueupload .thumbs').append(App.render['BlueUpload/file'](file));
				}
				console.log(file);
			});
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#progress .progress-bar').css(
				'width',
				progress + '%'
			);
		}
	}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');
});
