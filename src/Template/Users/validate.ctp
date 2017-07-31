<?php use Cake\Routing\Router; ?>
<div class='col-lg-offset-4'>
<label id='test'></label>
    <div class="container-fluid">
        <h2>Login</h2>
        <div class="row">
        <form role="form" method='post' action='<?php echo Router::url(["action"=>"validateAccount", $email]);?>'>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="vcode">Enter validation code</label>
                        <div class="input-group col-sm-10">
                            <input type="vcode" class="form-control" id="vcode" name="vcode" placeholder="Enter Validation Code">
                        </div>
                    </div>
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left">
                </div>
            </form>
            <div class="col-md-4 col-md-push-1">
                <div id='invalid' class="alert alert-danger" style='visibility:<?php if (!isset($invalid)) echo 'hidden'; else echo 'visible';?>'>
                    <span class="glyphicon glyphicon-remove"></span><strong> Sorry! Wrong validation code</strong>
                </div>
            </div>
        </div>
    </div>
</div>
