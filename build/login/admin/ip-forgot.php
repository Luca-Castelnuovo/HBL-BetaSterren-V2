<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/functions.php");
login_admin();
$file = '../ip-forgot.txt';
$orig = file_get_contents($file);
$a = htmlentities($orig);
?>
<!DOCTYPE html>
<html lang="nl">

<?php head('Admin - IP-Forgot'); ?>

<body>
<div id="Menu">
    <ul>
        <li><a href="index" class="hoverable"><span class="normal">Admin - IP-Forgot</span><span class="hover">Terug naar admin panel</span></a>
        </li>
    </ul>
</div>
<img id="logo" src="/images/beta-sterren-logo.png">
<code>
    <pre><?= $a; ?></pre>
</code>
</body>

</html>
