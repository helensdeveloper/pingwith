const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "wasave") {
	Toast.fire({
		icon: 'success',
		title: 'Your Setting Updated.'
	})
}

if (flashdata == "emailsave") {
	Toast.fire({
		icon: 'success',
		title: 'Your Setting Updated.'
	})
}

if (flashdata == "cancelwasave") {
	Toast.fire({
		icon: 'error',
		title: 'Apikey Not Valid.'
	})
}
