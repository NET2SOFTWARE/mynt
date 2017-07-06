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
});