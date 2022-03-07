const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "pwdnotmatch") {
	Toast.fire({
		icon: 'warning',
		title: ' Passwords Dont Match.'
	})
}

if (flashdata == "registerdone") {
	Toast.fire({
		icon: 'success',
		title: 'Registration Success.'
	})
}

if (flashdata == "emailavail") {
	Toast.fire({
		icon: 'error',
		title: 'Email is Available.'
	})
}

if (flashdata == "phoneavail") {
	Toast.fire({
		icon: 'error',
		title: 'Phonenumber is Available.'
	})
}
