const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "changesuccess") {
	Toast.fire({
		icon: 'success',
		title: 'Change Password Successfull.'
	})
}

if (flashdata == "oldpasswordfail") {
	Toast.fire({
		icon: 'error',
		title: 'Old Password Cant Verified.'
	})
}

if (flashdata == "newpasswordfail") {
	Toast.fire({
		icon: 'error',
		title: 'Confirm Password Cant Verified.'
	})
}
