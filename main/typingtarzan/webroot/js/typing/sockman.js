function User() {
    //this.conn = new WebSocket('ws:ttar.duckdns.org:8080');
    this.conn = new WebSocket('ws:localhost:8081');
    this.displayname = null;
    this.email = null;
    this.tman = new TypingManager();
    this.d_gameid = null;
    this.status = "waiting";
    var obj = this;
    this.counter = 0;
    this.bar_container = [];
    this.plen = 0;
    this.start_time = null;

    this.loadInfo = function() {
        $.ajax({
        url: '/loadInfo',
            cache: false,
            type: 'POST',
            dataType: 'HTML',
            success: function (data) {
                data = JSON.parse(data);
                var email = data[0];
                var name = data[1];
                obj.email = email;
                obj.displayname = name;
                obj.send({'type' : 'login', 'name' : name, 'email' : email});
                obj.loaded = true;
            }
        }); 
    }

    this.conn.onopen = function(e) {
        obj.loadInfo();
    }

    this.timerStart = function() {
        if (this.status == "waiting") {
            $("#timer").text("waiting");
            return ;
        }
        if (this.counter == 0) {
            obj.tman.start(obj.start_time);
            $("#timer").text("go!");
            window.location.hash = '#tcont';
            $('#tcont').focus();
        } else {
            $("#timer").text("Starting in " + this.counter);
            setTimeout(this.timerStart.bind(this), 1000);
            this.counter--;
        }
    }

    this.conn.onmessage = function(e) {
        var m = JSON.parse(e.data); 
        if (m[0] == 'timerStart') {
            obj.status = "starting";
            obj.counter = m[1];
            obj.timerStart();
            obj.tman.start_time = m[2];
            obj.start_time = m[2];
        } else if (m[0] == 'joinGame') {
            $("#timer").text("waiting");
            $("#graph").html("");
            obj.status = "waiting";
            obj.plen = 0;
            obj.d_gameid = m[1];
            obj.tman.setText(m[2]);
            $('#tcont').html(obj.tman.render());
        } else if (m[0] == 'getGameList') {
            var u = m[1];
            $("#gamelist").html("");
            for (var i = 0; i < u.length; ++i) {
                u[i][1] = 'Game : ' + u[i][1];
                var s = "<li id='" + u[i][0] + "'class='list-group-item'>" + u[i][1] + "</li>";
                $("#gamelist").append(s);
            }
            $("body").on('click', "#" + obj.conn.id, function() { });
        } else if (m[0] == 'getstatus') {
            var s = m[1];
        } else if (m[0] == 'getUserProgress') {
            var info = m[1];
            var str = "";
            var totplayers = info.length;
            while (totplayers > obj.plen) {
                $("#graph").append(obj.getProgressBar(obj.plen));
                obj.plen++;
            }

            while (totplayers < obj.plen) {
                obj.plen--;
                $("#prgbar" + obj.plen).remove();
            }

            for (var i = 0; i < info.length; ++i) {
                var p = info[i].progress * 100.0 / obj.tman.text.length;
                var dur = info[i].duration;
                if (info[i].status != 'finished') {
                    dur = Date.now() / 1000.0 - obj.start_time;
                }
                var avg = 5;
                var speed = Math.floor(60.0 * info[i].progress / dur / avg);
                $("#pbar_label" + i).html(info[i].name + " > " + speed + " WPM");
                $("#pbar_bar" + i).css('width', p + '%');
            }
        } else if (m[0] == 'broadcast') {
            $('#msghistory').append(m[1] + '>' + m[2] + "\r\n");
            $('#msghistory').scrollTop($('#msghistory')[0].scrollHeight);
        }
    }

    this.getProgressBar = function(id) {
        var lbl = 'pbar_label' + id;
        var pbar = 'pbar_bar' + id;
        var bid = 'prgbar' + id;
        var str = "";
        str += "<div class='row' id='" + bid + "'>";
        str +=      '<div class="col-md-4">';
        str +=           '<div class="col-md-12 label label-primary" style="font-size:14px;" id="' + lbl + '"></div>';
        str +=      '</div>';
        str +=      '<div class="col-md-8">';
        str +=           '<div class="progress">';
        str +=                '<div id="' + pbar + '" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">';
        str +=                    '<span class="sr-only">ok</span>';
        str +=                '</div>';
        str +=           '</div>';
        str +=      '</div>';
        str += '</div>';
        return str;
    }

    this.send = function(o) {
        this.conn.send(JSON.stringify(o));
    }

    this.sendProgress = function() {
        this.send({'type' : 'progress', 'progress' : obj.tman.corpos});
    }

    this.getUserProgress = function() {
        this.send({'type' : 'getUserProgress'});
    }

    this.getGameList = function() {
        var arr = {'type':'getGameList'};
        this.send(arr);
    }
}
