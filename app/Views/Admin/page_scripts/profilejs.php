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
            $('#passAlert').hide();
        } else if (data.status == 0) {
            $("#passAlert").html(data.msg).show();
            setTimeout(function() {
                $("#passAlert").fadeOut();
            }, 1000); 
        }
    }, 'json');
});



    // Show/Hide Password Toggle
	
	

document.querySelectorAll(".toggle-password").forEach(function(icon) {
    icon.addEventListener("click", function() {
        const targetId = this.getAttribute("data-target");
        const input = document.getElementById(targetId);
        const isPassword = input.getAttribute("type") === "password";
        input.setAttribute("type", isPassword ? "text" : "password");
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});




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
  
  
  $(document).ready(function () {
    $('#passUpdate').on('click', function () {
        var formData = $('#changePasswordForm').serialize();

        $.ajax({
            url: "<?= base_url('admin/profile/change_password'); ?>",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                var messageBox = $('#messageBox');
                messageBox.removeClass('alert-success alert-danger');

                if (response.status == 1) {
                    messageBox.addClass('alert alert-success').text(response.msg).fadeIn();
                    $('#changePasswordForm')[0].reset(); 
                } else {
                    messageBox.addClass('alert alert-danger').text(response.msg).fadeIn();
                }

                setTimeout(function () {
                    messageBox.fadeOut();
                }, 3000);
            }
        }); 
    }); 
}); 
 
</script>
