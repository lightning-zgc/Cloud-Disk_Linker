/*背景图片轮换*/
function ChangeImg(i) {
    var n = i;
		var mybg=document.getElementById("mybg");
    if (n > 3) n = 1;
    mybg.src = "img/background" + n + ".jpg";
    n++;
    setTimeout("ChangeImg(" + n + ")", 20000);
}
setTimeout(function() {
    ChangeImg(1)
}, 10);
/*登录框动画*/
function showbox() {
    var loginbox = document.getElementById('login-box');
    loginbox.style.display = "block";
}

function closebox() {
    var loginbox = document.getElementById('login-box');
    loginbox.style.display = "none";
}
/*背景滤镜动画*/
function bluron() {
    document.getElementById('content').className = 'bluron';
    document.getElementById('background').className = 'bluron';
    document.getElementById('toplable').className = 'bluron';
}

function bluroff() {
    document.getElementById('content').className = 'bluroff';
    document.getElementById('background').className = 'bluroff';
    document.getElementById('toplable').className = 'bluroff';
}

function bgbluron() {
    document.getElementById('background').className = 'bluron';
}
/*上传下载切换*/
function toupload() {
    var downloadbox = document.getElementById('download');
    var uploadbox = document.getElementById('upload');
    downloadbox.style.display = "none";
    uploadbox.style.display = "block";
}

function todownload() {
    var downloadbox = document.getElementById('download');
    var uploadbox = document.getElementById('upload');
    downloadbox.style.display = "block";
    uploadbox.style.display = "none";
}
