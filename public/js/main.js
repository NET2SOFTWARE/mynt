$( document ).ready(function() {
	$('section.main form button[type="submit"]').on('click', function (e) {
		if ($(this).text().toLowerCase() == 'find') return;

		e.preventDefault();
		$form = $(this).parent().closest('form');
		$modal = $form.find('input[type="hidden"][name="_method"]').length > 0 ? $('#myntModalConfirmUpdate') : $('#myntModalConfirmCreate');
		$btnSubmit = $modal.find('button.btn-primary');

		$modal.modal('toggle');

		$btnSubmit.on('click', function (e) {
			e.preventDefault();
			$form.submit();
		});
	});

	$('table tbody a[onclick]')
	.prop('onclick', null)
	.on('click', function (e) {
		e.preventDefault();
		$form = $(this).parent().find('form');
		$modal = $('#myntModalConfirmDelete');
		$btnSubmit = $modal.find('button.btn-primary');

		$modal.modal('toggle');

		$btnSubmit.on('click', function (e) {
			e.preventDefault();
			$form.submit();
		});
	});

	$('input.custom-file-input')
	.on('change', function (e) {
		$input = $(this);
		$control = $input.next('span.custom-file-control');
		file = $input[0].files[0];

		if (file)
		{
			$control.attr('data-file-name', file.name).addClass('changed');
		} else {
			$control.attr('data-file-name', null).removeClass('changed');
		}
	});
});