const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "already") {
	Toast.fire({
		icon: 'error',
		title: 'Extension Already.'
	})
}

if (flashdata == "okay") {
	Toast.fire({
		icon: 'success',
		title: 'Added Extension Success.'
	})
}
