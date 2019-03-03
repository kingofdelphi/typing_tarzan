<div class="container-fluid">
    <div class="row">
        <h2 class='col-md-4 col-md-offset-4'>Create a New Account</h2>
        <div class='col-md-4 col-md-offset-4'>
            <form role="form" method='post' action='/signup/newaccount'>
                <div class="form-group">
                    <label for="username">Display name</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter display name">
                </div>
                <div class="form-group">
                    <label for="email">Enter Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="pwd1">Password:</label>
                    <input type="password" class="form-control" name='pwd1' id="pwd1" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="pwd2">Confirm Password:</label>
                    <input type="password" class="form-control" id="pwd2" placeholder="Enter password">
                </div>
				<div style='display:flex'>
					<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left">
				</div>
            </form>
        </div>
        <div class="col-md-4">
            <div style='visibility:hidden'>Dummy field just for alignment </div>
            <div id='empt' class="alert alert-danger" style='visibility:hidden'>
                <span class="glyphicon glyphicon-remove"></span><strong> Empty fields</strong>
            </div>
            <div id='taken' class="alert alert-danger" style='visibility:hidden'>
                <span class="glyphicon glyphicon-remove"></span><strong> Email already taken</strong>
            </div>
            <div id='pmatch' class="alert alert-danger" style='visibility:hidden'>
                <span class="glyphicon glyphicon-remove"></span><strong> Passwords don't match</strong>
            </div>
        </div>
    </div>
</div>
<script>
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

var vem = false;

function val() {
    var a = $("#pwd1").val();
    var b = $("#pwd2").val();
    var email = $("#email").val();
    var usr = $("#username").val();
    var ok = true;
    if (a == "" || b == "" || email == "" || usr == "") {
        ok = false;
        $("#empt").css('visibility', 'visible');
    } else {
        $("#empt").css('visibility', 'hidden');
    }

    if (validateEmail(email)) {
        //send ajax request
        $.ajax({
            url: '/checkemail/' + email,
            cache: false,
            type: 'POST',
            dataType: 'HTML',
            success: function (data) {
                data = JSON.parse(data);
                if (!data) {
                    vem = true;
                    $("#taken").css('visibility', 'hidden');
                } else {
                    $("#taken").css('visibility', 'visible');
                    vem = false;
                }
            }
        }); 
    }

    if (a == b) {
        $("#pmatch").css('visibility', 'hidden');
    } else {
        ok = false;
        $("#pmatch").css('visibility', 'visible');
    }
    if (!ok || !vem) {
        $("#submit").attr('disabled', 'disabled');
    } else {
        $("#submit").removeAttr('disabled');
    }
}

$(document).ready(function() {
    setInterval(val, 200);
}
);
</script>
