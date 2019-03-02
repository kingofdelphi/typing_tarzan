var user = new User();

function list() {
    user.getGameList();
    setTimeout(list, 1000);
}

$(document).ready(function() {
    setTimeout(list, 1000);

    $("body").on('click', "#gamelist li", function() {
        var id = this.id;
        user.send({'type':'joinGame', "gameid":id});
    });

    function sendmsg() {
        var id = this.id;
        user.send({'type':'broadcast', 'message':$('#umsg').val()});
        $('#umsg').val('');
    }

    $("body").on('click', '#message_send', function() {
        sendmsg();
    });

    function createGame() {
        $("#graph").html(""); //clear progress list
        user.send({'type':'createNewGame', 'title':$('#gtitle').val()});
        $("#gtitle").val("");
    }

    $("body").on('click', '#new_g', function() {
        createGame();
    });

    $(document).on('keydown', '#tcont', function (e) {
        if (user.tman.started && e.keyCode == 8) {
            user.tman.back();
            e.preventDefault();
        }
    }
    );

    $(document).on('keydown', '#umsg', function (e) {
        if (e.keyCode == 13) sendmsg();
    }
    );

    $(document).on('keydown', '#gtitle', function (e) {
        if (e.keyCode == 13) createGame();
    }
    );


    $(document).on('keypress', '#tcont', function (e) {
        if (!user.tman.started) return ;
        var ps = user.tman.finished;
        user.tman.check(e.which);
        if (!ps && user.tman.finished) {
            user.send({'type' : 'finish_game'});
        }
    }

    );

    function renderer() {
        $("#tcont").html(user.tman.render());
    }

    setInterval(renderer, 10);
    setInterval(
            function() {
                var status = (user.tman.finished ? "finished" : user.tman.started ? "started" : "ready");
                $("#peerstat").text('Online Status: ' + user.status);
                if (user.tman.loaded) {
                    $('.progress').css('visibility', 'visible');
                    $('#tcont').css('visibility', 'visible');
                    $("#you").html('You=> Speed: ' + Math.floor(user.tman.getSpeed()));
                    $("#progress").css('width', user.tman.getProgress() + '%');
                    user.sendProgress();
                    user.getUserProgress();
                }

                if ($("#gtitle").val() == "") {
                    $("#new_g").attr('disabled', 'disabled');
                } else {
                    $("#new_g").removeAttr('disabled');
                }
            }
            , 200);
}
);

