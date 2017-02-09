<?php
// notes.php 20161111 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);
error_log(__FILE__);

class files
{
    private $g  = null;
    private $t  = null;
    private $b  = '';
    private $in = [
        'do'    => '',
        'to'    => '',
        'file'  => '.',
        'name'  => '',
        'xsrf'  => '',
    ];
    private $allow_delete = true;
    private $allow_rename = true;

    public function __construct(View $t, $g)
    {
error_log(__METHOD__);

        $this->t  = $t;
        $this->g  = $g;
        $this->in = util::esc($this->in);
        $this->b .= $this->{$g->in['m']}();
    }

    public function __toString() : string
    {
error_log(__METHOD__);

        return $this->b;
    }

    public function mkdir()
    {
error_log(__METHOD__);

        $dir = $this->in['name'];
        $file = SYS.$this->in['file'];
        $dir = str_replace('/', '', $dir);
        if (substr($dir, 0, 2) === '..')
            return;
        chdir($file);
        mkdir($dir);
        return;
        //exit;
    }

    public function read()
    {
error_log(__METHOD__);

        $auth_ok = empty($_SESSION['adm']) ? '' : '
      <div id="top" class="row">
        <div class="col-lg-6 col-xs-12">
          <form class="form" action="?" method="post" id="mkdir">
            <label for="dirname" class="sr-only">Create New Folder</label>
            <div class="input-group">
              <input type="text" id="dirname" class="form-control" name="name" value="" placeholder="Create New Folder">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="Go">
              </span>
            </div>
          </form>
        </div>
        <div id="file_drop_target" class="col-lg-6 col-xs-12">
          <div class="upload">
            Drag n Drop <b>or</b> &nbsp; <input type="file" multiple>
          </div>
        </div>
      </div>
      <div class="row">
        <div id="breadcrumb" class="col-lg-6 col-xs-12"></div>
        <div id="upload_progress" class="col-lg-6 col-xs-12"></div>
      </div>';

        return $auth_ok . '
      <div class="table-responsive">
        <table id="table" class="table table-hover table-sm">
          <thead class="thead-default">
            <tr>
              <th>Name</th>
              <th class=\'text-right\'>Size</th>
              <th class=\'text-right\'>Modified</th>
            </tr>
          </thead>
          <tbody id="list">
          </tbody>
         </table>
      </div>'.$this->jscript();
    }

    public function list()
    {
error_log(__METHOD__);

        $file = $this->in['file'];
error_log("file=$file");

        if (is_dir(SYS.$file)) {
            $directory = $file;
            $result = $dirs = $files = [];
            $filelist = array_diff(scandir(SYS.$directory), ['.', '..']);
            natsort($filelist);
            foreach($filelist as $f) {
                if (is_dir(SYS.$directory . DS . $f)) {
                    $dirs[] = $f;
                } else {
                    $files[] = $f;
                }
            }
            foreach(array_merge($dirs, $files) as $entry) {
                if ($entry === basename(__FILE__) or $entry[0] === '.') continue;
                $i = $directory . $entry;
                $stat = stat(SYS.$i);
                $result[] = [
                    'mtime'         => $stat['mtime'],
                    'size'          => is_dir(SYS.$i) ? '-' : $stat['size'],
                    'name'          => basename($i),
                    'path'          => preg_replace('@^\./@', '', $i),
                    'is_dir'        => is_dir(SYS.$i),
                    'is_deleteable' => $this->allow_delete
                        && ((!is_dir(SYS.$i) && is_writable(SYS.$directory))
                            || (is_dir(SYS.$i)
                                && is_writable(SYS.$directory)
                                && $this->is_recursively_deleteable(SYS.$i))),
                    'is_readable'   => is_readable(SYS.$i),
                    'is_writable'   => is_writable(SYS.$i),
                    'is_executable' => is_executable(SYS.$i),
                ];
            }
error_log(var_export($result,true));
            return json_encode([
                'success' => true,
                'is_writable' => is_writable(SYS.$file),
                'results' => $result
            ]);
        } else { //return $this->err(412, 'Not a Directory');
            return json_encode([
                'error' => ['code' => intval($code), 'msg' => $msg]
            ]);
        }
    }

    private function rmrf($dir)
    {
error_log(__METHOD__);

        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) $this->rmrf("$dir/$file");
            rmdir($dir);
        } else {
            unlink($dir);
        }
    }

    private function is_recursively_deleteable($d)
    {
error_log(__METHOD__);

        $stack = array($d);
        while($dir = array_pop($stack)) {
            if (!is_readable($dir) || !is_writable($dir))
                return false;
            $files = array_diff(scandir($dir), array('.','..'));
            foreach($files as $file) if (is_dir($file)) {
                $stack[] = "$dir/$file";
            }
        }
        return true;
    }

    private function err($code, $msg)
    {
error_log(__METHOD__);

        return json_encode(['error' => ['code' => intval($code), 'msg' => $msg]]);
    }

    private function asBytes($ini_v)
    {
error_log(__METHOD__);

        $ini_v = trim($ini_v);
        $s = ['g'=> 1 << 30, 'm' => 1 << 20, 'k' => 1 << 10];
        return intval($ini_v) * ($s[strtolower(substr($ini_v, -1))] ?: 1);
    }

    private function jscript() : string
    {
error_log(__METHOD__);

        $MAX_UPLOAD_SIZE = min($this->asBytes(ini_get('post_max_size')), $this->asBytes(ini_get('upload_max_filesize')));
        $auth_ok = empty($_SESSION['adm']) ? '' : '
                .append(data.is_deleteable ? $delete_link : "")
                .append($rename_link)';

        return '
    <script>
(function($){

    $.fn.tablesorter = function() {
        var $table = this;
        this.find("th").click(function() {
            var idx = $(this).index();
            var direction = $(this).hasClass("sort_asc");
            $table.tablesortby(idx,direction);
        });
        return this;
    };

    $.fn.tablesortby = function(idx,direction) {
        var $rows = this.find("tbody tr");
        function elementToVal(a) {
            var $a_elem = $(a).find("td:nth-child("+(idx+1)+")");
            var a_val = $a_elem.attr("data-sort") || $a_elem.text();
            return (a_val == parseInt(a_val) ? parseInt(a_val) : a_val);
        }
        $rows.sort(function(a,b){
            var a_val = elementToVal(a), b_val = elementToVal(b);
            return (a_val > b_val ? 1 : (a_val == b_val ? 0 : -1)) * (direction ? 1 : -1);
        })
        this.find("th").removeClass("sort_asc sort_desc");
        $(this).find("thead th:nth-child("+(idx+1)+")").addClass(direction ? "sort_desc" : "sort_asc");
        for(var i =0;i<$rows.length;i++)
            this.append($rows[i]);
        this.settablesortmarkers();
        return this;
    }

    $.fn.retablesort = function() {
        var $e = this.find("thead th.sort_asc, thead th.sort_desc");
        if ($e.length)
            this.tablesortby($e.index(), $e.hasClass("sort_desc") );

        return this;
    }

    $.fn.settablesortmarkers = function() {
        this.find("thead th span.indicator").remove();
        this.find("thead th.sort_asc").append("<span class=\'indicator\'>&darr;<span>");
        this.find("thead th.sort_desc").append("<span class=\'indicator\'>&uarr;<span>");
        return this;
    }

})(jQuery);

$(function(){
    var XSRF = (document.cookie.match("(^|; )_sfm_xsrf=([^;]*)")||0)[2];
    var MAX_UPLOAD_SIZE = '.$MAX_UPLOAD_SIZE.';
    var $tbody = $("#list");
    $(window).on("hashchange", list).trigger("hashchange");
    $("#table").tablesorter();

    $(document).on("click", ".delete", function(data) {
        $.post("", {"o":"fileman", "do":"delete", "file":$(this).attr("data-file"), "xsrf":XSRF}, "json").done(list);
        return false;
    });

    $(document).on("click", ".rename", function(data) {
        var name = prompt("Please enter a new name for: " + $(this).attr("data-file"), "");
        if (name)
            $.post("", {"o":"fileman", "do":"rename", "file":$(this).attr("data-file"), "to":name, "xsrf":XSRF}, "json").done(list);
        else alert("Empty file name, please try again")
        return false;
    });

    $("#mkdir").submit(function(e) {
        var hashval = window.location.hash.substr(1), $dir = $(this).find("[name=name]");
        e.preventDefault();
//        $dir.val().length && $.post("?",{"o":"fileman", "do":"mkdir", "name":$dir.val(), "xsrf":XSRF, "file":hashval}, "json").done(list);
        $dir.val().length && $.post("?",{"x":"main","o":"fileman", "m":"mkdir", "name":$dir.val(), "xsrf":XSRF, "file":hashval}, "json").done(list);
        $dir.val("");
        return false;
    });

    $(document).on("dragover", "#file_drop_target", function(){
        $(this).addClass("drag_over");
        return false;
    }).on("dragend", "#file_drop_target", function(){
        $(this).removeClass("drag_over");
        return false;
    }).on("drop", "#file_drop_target", function(e){
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        $.each(files,function(k,file) {
            uploadFile(file);
        });
        $(this).removeClass("drag_over");
    });
    $("input[type=file]").change(function(e) {
        e.preventDefault();
        $.each(this.files, function(k, file) {
            uploadFile(file);
        });
    });

    function uploadFile(file) {
        var folder = window.location.hash.substr(1);
        if (file.size > MAX_UPLOAD_SIZE) {
            var $error_row = renderFileSizeErrorRow(file,folder);
            $("#upload_progress").append($error_row);
            window.setTimeout(function(){$error_row.fadeOut();},5000);
            return false;
        }

        var $row = renderFileUploadRow(file, folder);
        $("#upload_progress").append($row);
        var fd = new FormData();
        fd.append("file_data", file);
        fd.append("file", folder);
        fd.append("xsrf", XSRF);
        fd.append("do", "upload");
        fd.append("o", "fileman");
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "?");
        xhr.onload = function() {
            $row.remove();
            list();
        };
        xhr.upload.onprogress = function(e){
            if (e.lengthComputable) {
                $row.find(".progress").css("width", (e.loaded / e.total * 100 | 0) + "%" );
            }
        };
        xhr.send(fd);
    }

    function renderFileUploadRow(file,folder) {
        return $row = $("<div/>")
            .append($("<span class=\'fileuploadname\' />")
                .text((folder ? folder + "/" : "") + file.name))
            .append($("<div class=\'progress_track\'><div class=\'progress\'></div></div>"))
            .append($("<span class=\'size\' />")
                .text(formatFileSize(file.size)))
    };

    function renderFileSizeErrorRow(file,folder) {
        return $row = $("<div class=\'error\' />")
            .append($("<span class=\'fileuploadname\' />")
                .text("Error: " + (folder ? folder + "/" : "") + file.name))
            .append($("<span/>")
                .html(" file size - <b>"
                    + formatFileSize(file.size)
                    + "</b>"
                    + " exceeds max upload size of <b>"
                    + formatFileSize(MAX_UPLOAD_SIZE)
                    + "</b>"
                )
            );
    }

    function list() {
        var hashval = window.location.hash.substr(1);
        $.get("?", {"o":"files", "m":"list", "x":"main", "file":hashval}, function(data) {
            $tbody.empty();
            $("#breadcrumb").empty().html(renderBreadcrumbs(hashval));
            if (data.success) {
                $.each(data.results, function(k, v) {
                    $tbody.append(renderFileRow(v));
                });
                !data.results.length && $tbody.append("<tr><td class=\'empty\' colspan=4>This folder is empty</td></tr>")
                data.is_writable ? $("body").removeClass("no_write") : $("body").addClass("no_write");
            } else {
                console.warn(data.error.msg);
            }
            $("#table").retablesort();
        }, "json");
    }

    function renderFileRow(data) {
        var imgs  = ["jpeg", "jpg", "png", "gif", "bmp"];
        var docs  = ["doc", "txt", "md"];
        var code  = ["php", "pl", "html", "cgi", "py"];
        var video = ["mp4", "avi", "mkv", "mov", "dash", "webm", "vob", "wmv", "ogv", "3gp", "m4v"];
        var audio = ["mp3", "flac", "mp4a", "wav", "aac", "wma", "pcm", "ogg", "aiff", "ac3", "stem"];
        var pdf   = ["pdf"];
        var arc   = ["zip", "tgz", "gz", "xz", "iso"];
        var ext = data.name.substr((~-data.name.lastIndexOf(".") >>> 0) + 2).toLowerCase();

        if (!ext) {
            filetype = data.is_dir ? "folder" : "file-o";
        } else if ($.inArray(ext, imgs) > -1) {
            filetype = "picture-o";
        } else if ($.inArray(ext, docs) > -1) {
            filetype = "file-text-o";
        } else if ($.inArray(ext, code) > -1) {
            filetype = "file-code-o";
        } else if ($.inArray(ext, video) > -1) {
            filetype = "file-video-o";
        } else if ($.inArray(ext, audio) > -1) {
            filetype = "file-audio-o";
        } else if ($.inArray(ext, pdf) > -1) {
            filetype = "file-pdf-o";
        } else if ($.inArray(ext, arc) > -1) {
            filetype = "file-archive-o";
        } else filetype = "file-o";

        var $link = $("<a class=\'name\' />")
            .attr("href", data.is_dir ? "#" + data.path : "./" + data.path)
            .text(" " + data.name)
            .prepend($("<i class=\'fa fa-" + filetype + " fa-fw fa-lg\'/>"));

        var $dl_link = $("<a/>")
            .attr("href", "?o=fileman&do=download&file=" + encodeURIComponent(data.path))
            .attr("title", "Download")
            .addClass("download")
            .append($("<i class=\'fa fa-download fa-fw fa-lg\'/>"));

        var $delete_link = $("<a href=\'#\' />")
            .attr("data-file", data.path)
            .attr("title", "Delete")
            .addClass("delete")
            .append($("<i class=\'fa fa-times fa-fw fa-lg\'/>"));

        var $rename_link = $("<a href=\'#\' />")
            .attr("data-file", data.path)
            .attr("title", "Rename")
            .addClass("rename")
            .append($("<i class=\'fa fa-plus-square fa-fw fa-lg\'/>"));

        var perms = [];
        if (data.is_readable) perms.push("r");
        if (data.is_writable) perms.push("w");
        if (data.is_executable) perms.push("x");

        var $html = $("<tr />")
            .addClass(data.is_dir ? "is_dir" : "")
            .append($("<td class=\'first\' />")' . $auth_ok . '
                .append($dl_link)
                .append($link))
            .append($("<td class=\'text-right\'/>")
                .attr("data-sort",data.is_dir ? -1 : data.size)
                .html($("<span class=\'size\' />")
                .text(formatFileSize(data.size))))
            .append($("<td class=\'text-right\'/>")
                .attr("data-sort",data.mtime)
                .text(formatTimestamp(data.mtime)))
        return $html;
    }

    function renderBreadcrumbs(path) {
        var base = "",
            $html = $("<ol/>").attr("class","breadcrumb").append($("<li><a href=#>Home</a></li>"));

//            $html = $("<div/>").append($("<a href=#>Home</a></div>"));
                    //.append($("<span/>")
                    //.text(" ▸ "))

        $.each(path.split("/"), function(k, v) {
            if (v) {
                $html
                    .append($("<li/>"))
                    .append($("<a/>")
                    .attr("href", "#" + base + v)
                    .text(v));
                base += v + "/";
            }
        });
        return $html;
    }

    function formatTimestamp(unix_timestamp) {
        var m = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var d = new Date(unix_timestamp * 1000);

        return [m[d.getMonth()], " ", d.getDate(), ", ", d.getFullYear()," ",
            (d.getHours() % 12 || 12), ":", (d.getMinutes() < 10 ? "0" : "") + d.getMinutes(),
            " ", d.getHours() >= 12 ? "PM" : "AM"].join("");
    }

    function formatFileSize(bytes) {
        var s = ["bytes", "KB", "MB", "GB", "TB", "PB", "EB"];
        for(var pos = 0; bytes >= 1000; pos++, bytes /= 1024);
        var d = Math.round(bytes * 10);
        return pos ? [parseInt(d / 10), ".", d%10, " ", s[pos]].join("") : bytes + (bytes == "-" ? "" : " bytes");
    }
});
    </script>';
    }
}
