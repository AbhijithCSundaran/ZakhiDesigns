<div class="row">
    <div style="padding:10px; ">
        <div class="alert p-2" id="messageBox" style="display:none;">message</div>
    </div>
    <div class="text-center logo ">
         <a href="">
        <img class="img-align" src="<?php echo base_url() . ASSET_PATH; ?>assets/images/logo.jpg" />
        </a>
    </div>
    <h5 class="text-center">Forgot Password</h5>
</div>

<form id="forgotEmailForm" method="post">
    <p style="text-align:center;">Enter your email address and we'll send you a link to reset your password.</p>  
    <div class="floating-label-group">
        <input type="email" class="form-control" id="forgotCustEmail" name="forgotCustEmail" placeholder=" " required />
        <label for="email">Email</label>
    </div>
    <div class="d-flex mt-2 justify-content-center" >
        <button type= "button" class="btn btn-primary" id="forgotEmailSending">Reset Password </button>
    </div>
    <div class="text-end"> 
        <a href="" class="ms-2" id="showLoginFromFrgt" style="text-decoration:none">Back to Login</a>
    </div>
</form>
<script>
    function forgotEmailSend(){
        $('#forgotEmailSending').on('click',function(){
            var link = "<?= base_url('weblogin/webForgotEmailSend'); ?>";
             $.post(link, $('#forgotEmailForm').serialize(), function(response){
                 if(response.status == 1){
                    $('#messageBox')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text(response.msg)
                        .show();
                        setTimeout(()=>{
                            $('#messageBox').fadeOut();
                            //$('#mainModal').modal('hide');
                             $('#modalBody').load("<?= base_url('weblogin'); ?>");   
                        },3000);
                 }
                 else if(response.status == 0){
                    $('#messageBox')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .text(response.msg)
                        .show();
                     setTimeout(()=>{
                            $('#messageBox').fadeOut();
                        },3000);    
                 }
                 else{
                     $('#messageBox')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text("Invalid Email Format.")
                        .show();
                     setTimeout(()=>{
                            $('#messageBox').fadeOut();
                        },3000);    
                 }
             },'json');
        });
    }

     $(document).ready(function(){
        forgotEmailSend();
    });

</script>

