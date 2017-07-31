<div class="container-fluid">
    <div class="row">
        <h2 class='col-xs-4 col-xs-offset-4'>Login</h2>
        <div class='col-xs-4 col-xs-offset-4'>
            <form role="form" method='post' action='/login/verify'>
                <div class="form-group">
                    <label for="email">Enter Email</label>
                    <div class="input-group col-xs-12">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="pwd1">Password:</label>
                    <div class="input-group col-xs-12">
                        <input type="password" class="form-control" name='pwd1' id="pwd1" placeholder="Enter password">
                    </div>
                </div>
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left">
            </form>
        </div>
        <div class="col-xs-4">
            <div id='invalid' class="alert alert-danger" style='visibility:<?php if (!isset($invalid)) echo 'hidden'; else echo 'visible';?>'>
                <span class="glyphicon glyphicon-remove"></span><strong> Sorry! Invalid email or password</strong>
            </div>
        </div>
    </div>
</div>
