/*
**************************************
* Restrict Class v1.0                *
* Autor: Carlos R. L. Rodrigues      *
**************************************
*/

//========================================================
// REQUIRES http://www.jsfromhell.com/geral/event-listener
//========================================================

Restrict = function(form){
    this.form = form, this.field = {}, this.mask = {};
}
Restrict.field = Restrict.inst = Restrict.c = null;
Restrict.prototype.start = function(){
    var $, __ = document.forms[this.form], s, x, j, c, sp, o = this, l;
    var p = {".":/./, w:/\w/, W:/\W/, d:/\d/, D:/\D/, s:/\s/, a:/[\xc0-\xff]/, A:/[^\xc0-\xff]/};
    for(var _ in $ = this.field)
        if(/text|textarea|password/i.test(__[_].type)){
            x = $[_].split(""), c = j = 0, sp, s = [[],[]];
            for(var i = 0, l = x.length; i < l; i++)
                if(x[i] == "\\" || sp){
                    if(sp = !sp) continue;
                    s[j][c++] = p[x[i]] || x[i];
                }
                else if(x[i] == "^") c = (j = 1) - 1;
                else s[j][c++] = x[i];
            o.mask[__[_].name] && (__[_].maxLength = o.mask[__[_].name].length);
            __[_].pt = s, addEvent(__[_], "keydown", function(e){
                var r = Restrict.field = e.target;
                if(!o.mask[r.name]) return;
                r.l = r.value.length, Restrict.inst = o; Restrict.c = e.key;
                setTimeout(o.onchanged, r.e = 1);
            });
            addEvent(__[_], "keyup", function(e){
                (Restrict.field = e.target).e = 0;
            });
            addEvent(__[_], "keypress", function(e){
                o.restrict(e) || e.preventDefault();
                var r = Restrict.field = e.target;
                if(!o.mask[r.name]) return;
                if(!r.e){
                    r.l = r.value.length, Restrict.inst = o, Restrict.c = e.key || 0;
                    setTimeout(o.onchanged, 1);
                }
            });
        }
}
Restrict.prototype.restrict = function(e){
    var o, c = e.key, n = (o = e.target).name, r;
    var has = function(c, r){
        for(var i = r.length; i--;)
            if((r[i] instanceof RegExp && r[i].test(c)) || r[i] == c) return true;
        return false;
    }
    var inRange = function(c){
        return has(c, o.pt[0]) && !has(c, o.pt[1]);
    }
    return (c < 30 || inRange(String.fromCharCode(c))) ?
        (this.onKeyAccept && this.onKeyAccept(o, c), !0) :
        (this.onKeyRefuse && this.onKeyRefuse(o, c),  !1);
}
Restrict.prototype.onchanged = function(){
    var ob = Restrict, si, moz = false, o = ob.field, t, lt = (t = o.value).length, m = ob.inst.mask[o.name];
    if(o.l == o.value.length) return;
    if(si = o.selectionStart) moz = true;
    else if(o.createTextRange){
        var obj = document.selection.createRange(), r = o.createTextRange();
        if(!r.setEndPoint) return false;
        r.setEndPoint("EndToStart", obj); si = r.text.length;
    }
    else return false;
    for(var i in m = m.split(""))
        if(m[i] != "#")
            t = t.replace(m[i] == "\\" ? m[++i] : m[i], "");
    var j = 0, h = "", l = m.length, ini = si == 1, t = t.split("");
    for(i = 0; i < l; i++)
        if(m[i] != "#"){
            if(m[i] == "\\" && (h += m[++i])) continue;
            h += m[i], i + 1 == l && (t[j - 1] += h, h = "");
        }
        else{
            if(!t[j] && !(h = "")) break;
            (t[j] = h + t[j++]) && (h = "");
        }
    o.value = o.maxLength > -1 && o.maxLength < (t = t.join("")).length ? t.slice(0, o.maxLength) : t;
    if(ob.c && ob.c != 46 && ob.c != 8){
        if(si != lt){
            while(m[si] != "#" && m[si]) si++;
            ini && m[0] != "#" && si++;
        }
        else si = o.value.length;
    }
    !moz ? (obj.move("character", si), obj.select()) : o.setSelectionRange(si, si);
}