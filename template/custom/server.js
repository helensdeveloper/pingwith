const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "donechange") {
	Toast.fire({
		icon: 'success',
		title: 'Server Detail Has Been Change.'
	})
}