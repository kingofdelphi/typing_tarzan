function TypingManager() {
    this.loaded = false;
    this.setText = function(s) {
        this.loaded = true;
        this.finished = false;
        this.start_time = null;
        this.finish_time = null;
        this.started = false;
        this.pos = 0; //current position
        this.corpos = 0; //correct position
        this.text = s;
    }

    this.getRenderText = function(pos) {
        if (typeof(pos) == 'undefined') pos = -1;
        if (!this.loaded) return "";
        var left = this.text.substring(0, this.corpos);
        var wrong = this.text.substring(this.corpos, this.pos);
        var cur = this.text.charAt(this.pos);
        var right = this.text.substring(this.pos + 1);
        var ch = [left, wrong, cur, right];
        var classes = ['left', 'wrong', 'cur', 'right'];
        var r = "";
        var tot = 0;
        for (var i = 0; i < 4; ++i) {
            var p = tot;
            tot += ch[i].length;
            if (pos < tot && pos >= p) {
                var s1 = ch[i].substring(0, pos - p);
                var opp = ch[i].charAt(pos - p);
                var s2 = ch[i].substring(pos - p + 1);
                s1 = "<span class='" + classes[i] + "'>" + s1 + "</span>";
                opp = "<span class='peer'>" + opp + "</span>";
                s2 = "<span class='" + classes[i] + "'>" + s2 + "</span>";
                r += s1 + opp + s2;
            } else
                r += "<span class='" + classes[i] + "'>" + ch[i] + "</span>";
        }
        return r;
    }

    this.getProgress = function() {
        return this.corpos * 100.0 / this.text.length;
    }

    this.back = function() {
        if (this.finished) return ;
        this.pos = Math.max(this.pos - 1, 0);
        this.corpos = Math.min(this.pos, this.corpos);
    }

    //returns html rendered
    this.render = function(p) {
        var r = "";
        r += "<div class='typing'>";
        r += this.getRenderText(p);
        r += "</div>";
        return r;
    }

    this.start = function(time) {
        this.started = true;
        this.start_time = time;
    }

    this.check = function(key) {
        if (!this.started || this.finished) return ;
        if (this.corpos == this.pos) {
            if (this.text.charCodeAt(this.pos) == key) {
                this.corpos++;
                if (this.corpos == this.text.length) {
                    this.finished = true;
                    this.finish_time = Date.now() / 1000.0;
                }
            }
        }
        this.pos = Math.min(this.pos + 1, this.text.length);
    }

    this.getSpeed = function() {
        var avg = 5.0;
        return 60.0 * this.corpos / this.getDuration() / avg;
    }
    
    this.getDuration = function() {
        if (this.finished) {
            return (this.finish_time - this.start_time) / 1000.0;
        }
        return Date.now() / 1000.0 - this.start_time;
    }
}
