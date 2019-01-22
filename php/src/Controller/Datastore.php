<?php
namespace App\Controller;

use App\Dao\Datastore as Dao;

class Datastore
{
    public function listAction()
    {
        $dao = new Dao;
        $result = $dao->execQuery('SELECT * FROM Person');
        echo <<<EOM
<html>
<head>
<meta charset="utf-8">
<title>List Person</title>
<style>
table {
    border: solid 2px #222222;
    border-collapse: collapse;
}
th, td {
    border: solid 1px #ff2222;
}
</style>
</head>
<body>
<table style="">
<thead>
<tr>
<th>key</th>
<th>name</th>
<th>sex</th>
<th>age</th>
<th>height</th>
<th>marriaged</th>
<th>(option)</th>
</tr>
</thead>
<tbody>
EOM;
        foreach ($result as $item) {
            echo '<tr>';
            $keyObj = $item->key();
            $path = $keyObj->path();
            $propertyMap = $item->get();
            echo '<td>' . json_encode($path) . '</td>';
            foreach (['name', 'sex', 'age', 'height', 'marriaged'] as $key) {
                echo '<td>' . json_encode($propertyMap[$key]) . '</td>';
            }
            echo '<td>' . json_encode($item->meanings()) . '</td>';
            echo '</tr>' . PHP_EOL;
        }
        echo <<<EOM
</tbody>
</table>
<hr>
EOM;
        $this->printDump($result, '#ccccff');
        $i = 0;
        foreach ($result as $item) {
            echo $i++;
            echo '<br/>' . PHP_EOL;
            $this->printDump($item, '#ccffff');
        }
        echo <<<EOM
</body>
</html>
EOM;
    }

    public function readAction()
    {
    }

    public function writeAction()
    {
        $dao = new Dao;

        $entity = $dao->createEntityObject('Person');

        mt_srand(time());
        $entity->set([
            'name' => '田中',
            'sex' => $this->getOne(['male', 'female']),
            'age' => mt_rand(1, 100),
            'height' => (mt_rand(1400, 1900) / 10),
            'marriaged' => $this->getOne([true, false]),
        ]);

        $dao->insert($entity);

        $this->printEntity($entity);
    }

    protected function printEntity($entity)
    {
        $this->printDump($entity, '#ccffcc');
    }

    protected function getOne(array $array) {
        $key = array_rand($array);
        return $array[$key];
    }

    protected function printDump($var, $bgColor = '')
    {
        echo PHP_EOL . PHP_EOL . '<pre style="background-color: ' . $bgColor . ';">';
        var_dump($var);
        echo '</pre>' . PHP_EOL . PHP_EOL;
    }
}
