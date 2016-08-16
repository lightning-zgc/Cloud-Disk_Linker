var long = 50000;
var down = 0;
var temp_file_list = new Array();

var xcode = new Array();
var inputElement = document.getElementById("file-input");
inputElement.addEventListener("change", showname, false);
var reader = new FileReader();
reader.onloadend = function(e) {
    console.log(e);
    upload();
};
var fileList;

// var fileSelect = document.getElementById("fileSelect"),
//     fileElem = inputElement;

// fileSelect.addEventListener("click", function(e) {
//     if (fileElem) {
//         startingByte = 0;
//         xcode = 1;
//         endindByte = long;
//         fileElem.click();
//     }
//     e.preventDefault(); // 阻止重定向
// }, false);

function login() {
    lpost("login.php", "", 'plain', function() {});
}

function filelistget() {
    lpost("fileinfo.php", "", "plain", function(e) {
        var html = '';
        e = JSON.parse(e);
        if (e.code != 0 && e.code != 1) {
            for (var n in e) {
                if (e.hasOwnProperty(n)) {
                    var sizet = e[n].size;
                    if (sizet < 1024) {
                        size = sizet.toFixed(2) + "B";
                    } else if (sizet < 1000000) {
                        size = (sizet / 1000).toFixed(2) + "KB";
                    } else if (sizet < 1000000000) {
                        size = (sizet / 1000000).toFixed(2) + "MB";
                    } else {
                        size = (sizet / 1000000000).toFixed(2) + "GB";
                    }
                    html += '<li><div class="download-table-left"><span class="download-file-name">' + e[n].name + '</span><span class="download-file-size">' + size + '</span></div><div class="download-table-right"><span class="download-file-date">' + e[n].uptime + '</span><span class="download-file-link"><button type="button" id="download-file-button" onclick="download(' + "'" + e[n].fileid + "'" + ');">点击预览</button><button type="button" id="download-file-button" onclick="downloadfl(' + "'" + e[n].fileid + "'" + ');">点击下载</button></span><span class="download-file-link"><button type="button" id="delete-file-button" onclick="deletefile(' + "'" + e[n].fileid + "'" + ');">删除</button></span></div><div class="download-list-line"></div></li>';
                }
            }
            document.getElementById("download_list").innerHTML = html;
        } else if (e.code == 1) {
            document.getElementById("download_list").innerHTML = '';
        }
    });
}
filelistget();
setInterval("filelistget()", 3000);

var dropbox = document.getElementById("content");
dropbox.addEventListener("dragenter", dragenter, false);
dropbox.addEventListener("dragover", dragover, false);
dropbox.addEventListener("drop", drop, false);

function dragenter(e) {
    e.stopPropagation();
    e.preventDefault();
}

function dragover(e) {
    e.stopPropagation();
    e.preventDefault();
}

function drop(e) {
    e.stopPropagation();
    e.preventDefault();

    var dt = e.dataTransfer;
    var files = dt.files;

    document.getElementById("upload-list").innerHTML = shownamehtml(files[0], 'drop');
    var file = files[0];
    lpost("requireupload.php", "filename=" + file.name + "&filesize=" + file.size + "&lastModified=" + file.lastModified + "&long=" + long, 'plain', function(e) {
        e = JSON.parse(e);
        if (e.code == 2) {
            temp_file_list['drop'][2] = e.msg;
            dropup(file, 0, long);
        } else {
            alert(e.msg);
        }
    });
}

function showname(e) {
    var name = '';
    temp_file_list = new Array();
    fileList = inputElement.files;
    for (var n in fileList) {
        if (fileList.hasOwnProperty(n)) {
            temp_file_list[n] = 'true';
            name += shownamehtml(fileList[n], n);
        }
    }
    document.getElementById("upload-list").innerHTML = name;
    // console.log(name);
}

function shownamehtml(file, n) {
    var sizet = file.size;
    temp_file_list[n] = [0, long];
    xcode[n] = 1;
    if (sizet < 1024) {
        size = sizet.toFixed(2) + "B";
    } else if (sizet < 1000000) {
        size = (sizet / 1000).toFixed(2) + "KB";
    } else if (sizet < 1000000000) {
        size = (sizet / 1000000).toFixed(2) + "MB";
    } else {
        size = (sizet / 1000000000).toFixed(2) + "GB";
    }
    // name += "<span id=\"" + n + "\">" + fileList[n].name + "</span><br />";
    return '<li id="cal' + n + '"><div id="' + n + '" class="upload-percent" style="background-size: 0%,50px;"><div class="upload-table-left"><span class="upload-file-name">' + file.name.substring(0, 40) + '</span><span class="upload-file-size"> 文件大小：' + size + ' | </span><span id="com' + n + '"></span></div><div class="upload-table-right"><button type="button" id="upload-file-button" onclick="cancellist(' + "'cal" + n + "'" + ')">取消</button></div></div><div class="upload-list-line"></div></li>';
}

function cancellist(n) {
    var del = document.getElementById(n);
    del.setAttribute("style", "display:none;");
    temp_file_list[n] = 'flase';
}

function dropup(file, startingByte, endindByte) {
    var blob;
    if (file.slice) {
        blob = file.slice(startingByte, endindByte);
    } else if (file.mozSlice) {
        blob = file.mozSlice(startingByte, endindByte);
    }
    var dropreader = new FileReader();
    dropreader.onloadend = function(e) {
        console.log(e);
        upload(dropreader, blob, file, startingByte, 'drop');
        if (endindByte >= file.size) {

        } else if (endindByte + long >= file.size) {
            startingByte += long;
            endindByte = file.size;
            dropup(file, startingByte, endindByte);
        } else {
            startingByte += long;
            endindByte += long;
            dropup(file, startingByte, endindByte);
        }
    };
    dropreader.readAsBinaryString(blob);
}

function upfile(n) {
    console.log(n);
    var blob;
    var startingByte = temp_file_list[n][0];
    var endindByte = temp_file_list[n][1];
    var file = fileList[n];
    if (file.slice) {
        blob = file.slice(startingByte, endindByte);
    } else if (file.mozSlice) {
        blob = file.mozSlice(startingByte, endindByte);
    }
    var dropreader = new FileReader();
    dropreader.onloadend = function(e) {
        console.log(e);
        upload(dropreader, blob, file, startingByte, n);
        if (endindByte >= file.size) {

        } else if (endindByte + long >= file.size) {
            temp_file_list[n][0] += long;
            temp_file_list[n][1] = file.size;
            upfile(n);
        } else {
            temp_file_list[n][0] += long;
            temp_file_list[n][1] += long;
            upfile(n);
        }
    };
    console.log(blob);
    console.log(n);
    dropreader.readAsBinaryString(blob);
}

function requireupload() {
    fileList = inputElement.files;
    // console.log(fileList);
    for (n in fileList) {
        if (fileList.hasOwnProperty(n)) {
            (function(n) {
                var tempn = n;
                var file = fileList[tempn];
                lpost("requireupload.php", "filename=" + file.name + "&filesize=" + file.size + "&lastModified=" + file.lastModified + "&long=" + long, 'plain', function(e) {
                    e = JSON.parse(e);
                    if (e.code == 2) {
                        temp_file_list[tempn][2] = e.msg;
                        handleFiles(tempn);
                    } else {
                        alert(e.msg);
                    }
                });
            })(n);
        }
    }
}

function handleFiles(n) {
    console.log(n);
    // // if (e.__proto__.constructor.name == "FileList") {
    // //     fileList = e;
    // // } else {
    // //     fileList = inputElement.files;
    // // }
    // fileList = inputElement.files;
    // // console.log(fileList);
    // for (n in fileList) {
    //     if (fileList.hasOwnProperty(n)) {
    var blob;
    if (fileList[n].slice) {
        blob = fileList[n].slice(temp_file_list[n][0], temp_file_list[n][1]);
    } else if (fileList[n].mozSlice) {
        blob = fileList[n].mozSlice(temp_file_list[n][0], temp_file_list[n][1]);
    }
    var dropreader = new FileReader();
    (function(n) {
        var tempn = n;
        dropreader.onloadend = function(e) {
            console.log(tempn);
            upload(dropreader, blob, fileList[tempn], temp_file_list[tempn][0], tempn);
            if (temp_file_list[tempn][1] >= fileList[tempn].size) {

            } else if (temp_file_list[n][1] + long >= fileList[tempn].size) {
                temp_file_list[tempn][0] += long;
                temp_file_list[tempn][1] = fileList[tempn].size;
                upfile(n);
            } else {
                temp_file_list[tempn][0] += long;
                temp_file_list[tempn][1] += long;
                upfile(n);
            }
        };
    })(n);
    dropreader.readAsBinaryString(blob);
    //     }
    // }
}

function upload(reader, blob, file, startingByte, id) {
    // var updata = btoa(escape(reader.result));
    var percent = Math.ceil(file.size / long);
    var updata = blob;
    var md5r = md5(reader.result);
    var formData = new FormData();
    formData.append("md5", md5r);
    formData.append("fileid", temp_file_list[id][2]);
    formData.append("file", updata, "file");
    var start = startingByte / long;
    lpost("upload.php?start=" + start, "md5=" + md5r + "&fileid=" + temp_file_list[id][2], 'plain', function(e) {
        e = JSON.parse(e);
        if (e.code == 2) {
            // console.log("已经添加");
            document.getElementById(id).setAttribute("style", 'background-size: ' + ((xcode[id]++) * 100) / percent + '%,50px;');
            document.getElementById('com' + id).innerHTML = ((xcode[id]++) * 100) / percent + '%';
            if ((xcode[id] - 1) / percent >= 1) {
                document.getElementById('com' + id).innerHTML = ' 完成';
                console.log("com");
            }
        } else {
            lpost("upload.php?start=" + start, formData, 'mix', function() {
                document.getElementById(id).setAttribute("style", 'background-size: ' + ((xcode[id]++) * 100) / percent + '%,50px;');
                document.getElementById('com' + id).innerHTML = ((xcode[id]++) * 100) / percent + '%';
                if ((xcode[id] - 1) / percent >= 1) {
                    document.getElementById('com' + id).innerHTML = ' 完成';
                    console.log("com");
                }
            });
        }
    });
    // console.log(startingByte);
    // console.log(endindByte);
}

// function download() {
//     lpost("download.php", null, 'plain', function(e) {
//         if (e < 1) {
//             if (e >= down) down = e;
//             document.getElementById("name").innerHTML = down;
//             download();
//         } else {
//             if (e >= down) down = e;
//             document.getElementById("name").innerHTML = down;
//             // alert("com");
//             window.open("./newfile.png");
//         }
//     });
//     // if (down < 1) {
//     //     download();
//     // } else {
//     //     window.open("./newfile.png");
//     // }
// }
//

function download(fileid) {
    window.open("download.php?fileid=" + fileid);
}

function downloadfl(fileid) {
    window.open("downloadfl.php?fileid=" + fileid);
}

function deletefile(fileid) {
    lpost("delete.php", "fileid=" + fileid, "plain", function(e) {
        var html = '';
        e = JSON.parse(e);
        if (e.code != 0) {
            filelistget();
        } else {
            alert(e.msg);
        }
    });
}

function login() {
    var userid = document.getElementById('id').value;
    var pass = document.getElementById('check').value;
    var text = document.getElementsByClassName('login-text')[0];
    lpost("login.php", "userid=" + userid + "&pass=" + pass, "plain", function(e) {
        e = JSON.parse(e);
        if (e.code != 0) {
            text.innerHTML = userid;
        } else {
            alert(e.msg);
        }
    });
}

function lpost(url, send, type, success) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", url, true);
    switch (type) {
        case "plain":
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            break;
        case "mix":
            // xmlhttp.setRequestHeader("Content-type", "multipart/form-data");
            break;
        default:
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    }
    xmlhttp.send(send);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            // console.log(xmlhttp.responseText);
            success(xmlhttp.responseText);
        }
    }
    return 0;
}
