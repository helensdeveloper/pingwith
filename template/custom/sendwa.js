const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "sended") {
	Toast.fire({
		icon: 'success',
		title: 'Send Message Successfull.'
	})
}
if (flashdata == "makedone") {
	Toast.fire({
		icon: 'success',
		title: 'Make Link Successfull, See Your Whatsapp For That Link.'
	})
}
if (flashdata == "lowcredit") {
	Toast.fire({
		icon: 'error',
		title: 'Your Credit Low.'
	})
}
if (flashdata == "errorupload") {
	Toast.fire({
		icon: 'error',
		title: 'Your Credit Low.'
	})
}