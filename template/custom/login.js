const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "invalid") {
	Toast.fire({
		icon: 'error',
		title: 'Authentication Invalid Please Check Your Email or Password.'
	})
}

if (flashdata == "notactive") {
	Toast.fire({
		icon: 'error',
		title: 'Your Account Not Verified, Please Activations Before Login or Contact Administrator.'
	})
}
