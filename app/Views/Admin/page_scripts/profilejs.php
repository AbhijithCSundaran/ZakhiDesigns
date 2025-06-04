<script>
  $(document).ready(function () {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Profile Update Validation
    $('form[action$="update"]').submit(function (e) {
      const name = $('input[name="us_Name"]').val().trim();
      const email = $('input[name="us_Email"]').val().trim();
     
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
	
   $('#passUpdate').click(function(e) {
    e.preventDefault();
    var url = "<?= base_url('admin/profile/change_password') ?>";
    $.post(url, $('#changePasswordForm').serialize(), function(data) {
     if (data.status == 1) {
		//$('#passAlert').hide();
		} else if (data.status == 0) {
			$("#passAlert").html(data.msg);
			$("#passAlert").show();
		}
    }, 'json');
  });


    // Show/Hide Password Toggle
	
	

 function togglePassword(inputId, toggleId) {
  const input = document.getElementById(inputId);
  const toggle = document.getElementById(toggleId);

  if (!input || !toggle) return;

  toggle.addEventListener('click', function () {
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    toggle.classList.toggle('fa-eye');
    toggle.classList.toggle('fa-eye-slash');
  });
}

togglePassword('current_password', 'toggleCurrentPassword');
togglePassword('new_password', 'toggleNewPassword');
togglePassword('confirm_password', 'toggleConfirmPassword');




    // Auto-hide alert messages after 7 seconds
    setTimeout(function () {
      let alertEl = document.querySelector('#tog-alert');
      if (alertEl) {
        alertEl.classList.remove('show');
        alertEl.classList.add('fade');
        setTimeout(() => alertEl.remove(), 500);
      }
    }, 3000);
  });
 
</script>
