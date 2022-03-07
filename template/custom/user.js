const flashdata = $('.flash-data').data('flashdata');

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

if (flashdata == "deactivelogin") {
	Toast.fire({
		icon: 'success',
		title: 'Disable Login Successfull.'
	})
}

if (flashdata == "emailavail") {
	Toast.fire({
		icon: 'error',
		title: 'Email is Available.'
	})
}

if (flashdata == "kurangbalance") {
	Toast.fire({
		icon: 'error',
		title: 'Insufficient Balance.'
	})
}

if (flashdata == "phoneavail") {
	Toast.fire({
		icon: 'error',
		title: 'Phonenumber is Available.'
	})
}

if (flashdata == "addsuccess") {
	Toast.fire({
		icon: 'success',
		title: 'Add Users Successfull.'
	})
}

if (flashdata == "activelogin") {
	Toast.fire({
		icon: 'success',
		title: 'Enable Login Successfull.'
	})
}

if (flashdata == "activegateway") {
	Toast.fire({
		icon: 'success',
		title: 'Enable Gateway Successfull.'
	})
}
if (flashdata == "deactivegateway") {
	Toast.fire({
		icon: 'success',
		title: 'Disable Gateway Successfull.'
	})
}
if (flashdata == "newpassword") {
	Toast.fire({
		icon: 'success',
		title: 'Password Has Been Reset.'
	})
}
if (flashdata == "addcredit") {
	Toast.fire({
		icon: 'success',
		title: 'Credit Added.'
	})
}

if (flashdata == "reducecredit") {
	Toast.fire({
		icon: 'success',
		title: 'Credit Reduce.'
	})
}
if (flashdata == "userdelete") {
	Toast.fire({
		icon: 'success',
		title: 'Deleted Users Successfull.'
	})
}