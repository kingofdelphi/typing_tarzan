<?php $this->assign('title', 'Typing Tarzan'); ?>
<!-- File: src/Template/Articles/index.ctp -->
<link rel='stylesheet' type='text/css' href='css/typing/style.css'>
<div class='form-group'>
    <div class='panel panel-primary'>
        <div class='panel-heading bg-success'>Games Available</div>
        <div class='panel-body bg-success'>
            <ul class='list-group' id='gamelist'></ul>
        </div>
    </div>
</div>
<div class='form-inline'>
    <div class='form-group'>
        <label>Game Title</label>
        <input id='gtitle' type='text' class='form-control'>
        <button id='new_g' class='form-control'>Create New Game</button>
    </div>
    <br>
    <br>
</div>
<div style='font-size:18px' class='label label-info' id='timer'></div>
<br>
<br>
<div class='form-group' id='graph'></div>
<div>
    <pre style='visibility:hidden;text-align:left;text-justify:none;word-break:normal;word-wrap:normal;' id='tcont' tabindex='0'></pre>
</div>
<script src='js/typing/typing.js'></script>
<script>SERVER_HOSTNAME='<?echo getenv('SERVER_HOSTNAME')?>'</script>
<script>WEBSOCKET_PORT='<?echo getenv('WEBSOCKET_PORT')?>'</script>
<script src='js/typing/sockman.js'> </script>
<script src='js/typing/events.js'></script>
