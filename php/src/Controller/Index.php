<?php
namespace App\Controller;

class Index
{
    public function action()
    {
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
EOM;
        echo $html;
    }
}
