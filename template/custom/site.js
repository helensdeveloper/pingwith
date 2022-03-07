const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "doneweb") {
	Toast.fire({
		icon: 'success',
		title: 'Website Name Has Been Change.'
	})
}
if (flashdata == "doneicon") {
	Toast.fire({
		icon: 'success',
		title: 'Icon Has Been Change.'
	})
}
if (flashdata == "doneurl") {
	Toast.fire({
		icon: 'success',
		title: 'Url Has Been Change.'
	})
}