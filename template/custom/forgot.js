const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "notfound") {
	Toast.fire({
		icon: 'error',
		title: 'Email or Phonenumber not found.'
	})
}

if (flashdata == "success") {
	Toast.fire({
		icon: 'success',
		title: 'New Password Successfull Send to Whatsapp.'
	})
}
