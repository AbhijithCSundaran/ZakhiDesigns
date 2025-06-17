<div class="row">
    <div style="padding:10px; ">
        <div class="alert p-2" id="messageBox" style="display:none;">message</div>
    </div>
    <div class="text-center logo ">
        <img class="img-align" src="<?php echo base_url() . ASSET_PATH; ?>assets/images/logo.jpg" />
    </div>
    <h5 class="text-center">Forgot Password</h5>
</div>

<form id="forgotEmailForm" method="post">
    <p style="text-align:center;">Enter your email we'll send you a link to get back into your account.</p>  
    <div class="floating-label-group">
        <input type="email" class="form-control" id="forgotCustEmail" name="forgotCustEmail" placeholder=" " required />
        <label for="email">Email</label>
    </div>
    <div class="d-flex mt-2 justify-content-center" >
        <button type= "button" class="btn btn-primary" id="forgotEmailSending">Send</button>
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
                 }
                 else if(response.status == 0){
                    $('#messageBox')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .text(response.msg)
                        .show();
                 }
                 else{
                     $('#messageBox')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text("Invalid Email Format.")
                        .show();
                 }
                 setTimeout(()=>{
                    $('#messageBox').fadeOut();
                 },3000);
             },'json');
        });
    }

     $(document).ready(function(){
        forgotEmailSend();
    });

</script>

