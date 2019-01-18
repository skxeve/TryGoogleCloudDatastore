<?php
namespace App\Controller;

class Index
{
    public function action()
    {
        $server = print_r($_SERVER, true);
        $html = <<<EOM
<html>
<head>
<meta charset="utf-8">
<title>Try GAE.</title>
</head>
<body>
Hello GAE!
</body>
</html>
<!--
$server
-->
EOM;
        echo $html;
    }
}
