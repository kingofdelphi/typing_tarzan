<?php $this->assign('title', 'View Active Users'); ?>
<!-- File: src/Template/Articles/index.ctp -->
<h1>Typing Passages</h1>
<div class='form-group'>
<label>guest username </label><input id='name'> 
<button id='login'>Login</button>
<button id='ulist'>GetList</button>
</div>
<?php foreach ($texts as $text): ?>
<div class='container'>
</div>
<?php endforeach; ?>

<?php 
$v = [];
foreach ($texts as $t) {
    $v[$t->id] = $t->title;
}
?>

<form method='post' class="form-inline" role="form">
  <div class="form-group">
    <select class='form-control' name='choice'>
        <?php $s=""; ?> 
        <?php foreach ($texts as $t) { 
            if ($load) {
                $s = "";
                if ($t->id == $sel) $s = 'selected="selected"';
            }
        ?>
        <option <?php echo $s; ?> value="<?php echo $t->id;?>"><?php echo $t->title;?></option>
        <?php } ?>
    </select>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

<?php if ($load) { ?>
<link rel='stylesheet' type='text/css' href='css/typing/style.css'>
<script src='js/typing/typing.js'></script>
<div class='panel panel-primary'>
<div class='panel-body bg-success'>
<label style='padding:0 80px 0 0' id="speed"></label> 
<label id="status"></label>
</div>
</div>
<pre id='tcont'></pre>
<script>
    var tman = new TypingManager();
    tman.setText(<?php echo '"'. $txt->text . '"'; ?>);
    $('#tcont').html(tman.render());

    $(document).ready(function() {
        $(document).keydown(function (e) {
            if (e.keyCode == 8) {
                tman.back();
                e.preventDefault();
                $('#tcont').html(tman.render());
            }
        }
    );
        $(document).keypress(function (e) {
            tman.check(e.which);
            $('#tcont').html(tman.render());
        }
    );

        setInterval(
            function() {
                $("#speed").html('Speed: ' + Math.floor(tman.getSpeed()));
                var status = (tman.finished ? "finished" : tman.started ? "started" : "ready");
                $("#status").html('Status: ' + status);
            }
        , 500);
    }
);
    </script>
<?php } ?>
<script src='js/typing/sockman.js'> </script>
