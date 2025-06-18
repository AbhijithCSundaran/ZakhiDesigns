<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100dvh;
            padding: 20px; 
            flex-direction: column;
             margin-top:-50px;
        }
        .logo {
            width: 70px;
            height: 67px;
            margin-bottom: -1px;
        }
        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            padding:48px 58px;
            
        }
        .form-class{
            padding: 2px;
            margin-left: -20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
            margin-left:8px ;
            margin-right: 8px;
        }
        .form-group label {
            display: block;
            color: #333;
            font-weight: 550;
            margin-bottom: 8px;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        .form-group input:focus {
            border-color: rgb(89, 50, 244);
            box-shadow: 0 0 8px rgba(22, 19, 21, 0.3);
        }
        .toggle-password{
            position: absolute;
            margin-left: 396px;
            margin-top: -30px; 
            cursor: pointer;
        } 
        

        .submit-btn {
            width: 102%;
            background-color: rgb(89, 50, 244);
            border: none;
            color: #fff;
            padding: 14px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-left:7px;
            transition: background 0.3s ease;
        }
        .submit-btn:hover {
            background-color: black;
        }
    </style>
</head>
<body>

    <?php $logoUrl = base_url(ASSET_PATH . 'assets/images/logo.jpg'); ?>
    
    <div class="container">
    <img src="<?= $logoUrl ?>" class="logo">

        <h2>Reset Password</h2>
        <p id="resetPasswordContent" style="font-weight: normal; font-size: 15px;  color:	#868686;">Please enter your new password below. Make sure it’s strong and easy for you to remember.</p>
        <form  class="form-class" id="forgotResetForm">
           <input type="hidden" name="email" id = "email" value="<?= esc($email) ?>">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_reset_password" id="new_reset_password" maxlength="15" minlength="7"required>
                 <i class="fa-solid fa-eye-slash toggle-password" toggle="#new_reset_password"></i>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_reset_password" id="confirm_reset_password" maxlength="15" minlength="7" required>
                <i class="fa-solid fa-eye-slash toggle-password" toggle="#confirm_reset_password"></i>
            </div>

            <button type="button" id="forgotSaveButton" class="submit-btn">Save</button>
        </form>
    </div>

</body>
</html>
<script>
    var baseUrl = "<?= base_url() ?>";
    document.querySelectorAll('.toggle-password').forEach(function (eyeIcon) {
        eyeIcon.addEventListener('click', function () {
            let input = document.querySelector(this.getAttribute('toggle'));
            if (input.type === "password") {
                input.type = "text";
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            } else {
                input.type = "password";
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            }
        });
    });
   function resetPassword(){
     var url = baseUrl + 'resetPassword';
        $.post(url,$('#forgotResetForm').serialize(), function(response){

         $('#resetPasswordContent').text('');
            var originalContent = "Please enter your new password below. Make sure it’s strong and easy for you to remember.";

        if(response.status == 1){
            $('#resetPasswordContent').text(response.msg).css('color', 'green');
        }else if(response.status == 0){
             $('#resetPasswordContent').text(response.msg).css('color', 'red');
        }
        else{
             $('#resetPasswordContent').text('Something went wrong. Please try again.').css('color', 'red');
        }
        setTimeout(function() {
            $('#resetPasswordContent').text(originalContent).css('color', '#868686');
        }, 3000);
     },'json');
   }

    $(document).ready(function() {
        $('#forgotSaveButton').click(function(){
            resetPassword();
        });
    
    });

</script>
