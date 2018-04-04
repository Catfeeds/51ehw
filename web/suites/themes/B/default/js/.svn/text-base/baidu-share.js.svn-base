lastScrollY = 0;
var graySrc = false;
var InterTime = 1;
var maxWidth = -1;
var minWidth = -198;
var numInter = 3;
var BigInter;
var SmallInter;
var o = null;
var i = 0;
online = function(id, _top, _left) {
    var me = id.charAt ? document.getElementById(id) : id, d1 = document.body, d2 = document.documentElement;
    d1.style.height = d2.style.height = '100%'; me.style.top = _top ? _top + 'px' : 0; me.style.left = _left + "px"; 
    me.style.position = 'absolute';
    me.style.display = 'block';
    setInterval(function() { me.style.top = parseInt(me.style.top) + (Math.max(d1.scrollTop, d2.scrollTop) + _top - parseInt(me.style.top)) * 0.1 + 'px'; }, 10 + parseInt(Math.random() * 20));
    return arguments.callee;
};
$(document).ready(function() {
    var html = '';
	html += ' <div class="ui-online-share" id="ui-share" onmouseover="toBig()" onmouseout="toSmall()">';
    html += '    <div class="ui-online-left">';
    html += '        <div class="ui-info-bot">';
    html += '            <div class="ui-share-title">';
    html += '                分享到：';
    html += '            </div>';
    html += '            <ul class="ui-share-info fn-clear bdsharebuttonbox">';
    html += '                <li>';
    html += '                    <a href="#" class="bds_mshare" data-cmd="mshare" title="分享到一键分享">一键分享</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                    <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                    <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                    <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                    <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                    <a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网">豆瓣网</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                     <a href="#" class="bds_kaixin001" data-cmd="kaixin001" title="分享到开心网">开心网</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                    <a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧">百度贴吧</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                    <a href="#" class="bds_tsohu" data-cmd="tsohu" title="分享到搜狐微博">搜狐微博</a>';
    html += '                </li>';
    html += '                <li>';
    html += '                    <a href="#" onclick="return false;" class="popup_more" data-cmd="more" target="_blank;">更多...</a>';
    html += '                </li>';
    html += '             </ul>';
    html += '            <div class="ui-share-title">';
    html += '                我要推广：';
    html += '            </div>';
    html += '            <div class="ui-share-spread">';
    html += '                <input type="text" class="text6" value="" />';
    html += '                <button type="submit" class="btn-login">获取</button>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '    <div class="ui-online-btn">';
    html += '    </div>';
    html += '    </div>';

    $(document.body).append(html);
    o = document.getElementById("ui-share");
    i = parseInt(o.style.left);

    online('ui-share', 100, -198);
});

function Big() {
    if (parseInt(o.style.left) < maxWidth) {
        i = parseInt(o.style.left);
        i += numInter;
        o.style.left = i + "px";
        if (i == maxWidth)
            clearInterval(BigInter);
    }
    if (!graySrc) {
        $(o).find("img").each(function() {
            $(this).attr("src", $(this).attr("Original"));
        });
        graySrc = true;
    }
}
function toBig() {
    clearInterval(SmallInter);
    clearInterval(BigInter);
    BigInter = setInterval(Big, InterTime);
}
function Small() {
    if (parseInt(o.style.left) > minWidth) {
        i = parseInt(o.style.left);
        i -= numInter;
        o.style.left = i + "px";

        if (i == minWidth)
            clearInterval(SmallInter);
    }
}
function toSmall() {
    clearInterval(SmallInter);
    clearInterval(BigInter);
    SmallInter = setInterval(Small, InterTime);

}