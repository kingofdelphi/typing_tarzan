<?php if ($mstat) { ?>
<div class="alert alert-success">
<strong><span class="glyphicon glyphicon-ok"></span> Your account has been created! 
We have sent you a verification code at the email address. Please check your inbox and complete the verification process.
</strong>
</div>
<?php } else { ?>
<div class="alert alert-danger">
<strong><span class="glyphicon glyphicon-ok"></span> 
Sorry, we couldn't send you a verification code. Please try again later.
</strong>
</div>
<?php } ?>
