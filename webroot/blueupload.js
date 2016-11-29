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
		var $blueupload = $(this).closest('.blueupload');
		var $thumb = $(this).closest('.thumb');
		var id = $thumb.find('[data-file-id]').data('file-id');

		$thumb.animate({opacity:0}, 400, function() {
			$(this).animate({width:'toggle'}, 400, function () {
				$(this).find('.img-thumbnail').remove();
				$(this).show();
			});
		});

		if ($blueupload.hasClass('immediate-delete')) {
			// do http delete
			var deleteUrl  = $(this).data('delete-url');
			var deleteType = $(this).data('delete-type');
			$.ajax({
				url: deleteUrl,
				type: deleteType,
				success: function (data) {}
			});
		} else {
			// render the form input signaling what to delete upon form submission
			$thumb.append(App.render['BlueUpload/item-delete']({id:id}));
		}
	});
});
