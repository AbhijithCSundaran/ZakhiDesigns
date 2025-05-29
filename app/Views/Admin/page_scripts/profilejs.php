<script>
$(document).ready(function () {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Profile Update Validation
    $('form[action$="update"]').submit(function (e) {
        const name = $('input[name="name"]').val().trim();
        const email = $('input[name="us_Email"]').val().trim();
        const Password = $('input[Password="us_Password"]').val().trim();
        let valid = true;

        if (!name) {
            alert('Name is required.');
            valid = false;
        }

        if (!email || !emailPattern.test(email)) {
            alert('Valid email is required.');
            valid = false;
        }

        if (!valid) e.preventDefault();
    });

    // Password Change Validation
    $('form[action$="change_password"]').submit(function (e) {
        const current = $('#current_password').val().trim();
        const newPwd = $('#new_password').val().trim();
        const confirmPwd = $('#confirm_password').val().trim();
        let valid = true;

        if (!current || !newPwd || !confirmPwd) {
            alert('All password fields are required.');
            valid = false;
        }

        if (newPwd.length < 4 || newPwd.length > 10) {
            alert('New password must be between 4 to 10 characters.');
            valid = false;
        }

        if (newPwd !== confirmPwd) {
            alert('New password and confirm password do not match.');
            valid = false;
        }

        if (!valid) e.preventDefault();
    });
});

    setTimeout(function () {
        let alertEl = document.querySelector('.alert');
        if (alertEl) {
            alertEl.classList.remove('show');
            alertEl.classList.add('fade');
            setTimeout(() => alertEl.remove(),
			500); 
        }
    }, 2000); 

</script>
