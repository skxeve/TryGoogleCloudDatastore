<?php
namespace App\Controller;

use App\Dao\Datastore as Dao;

class Datastore
{
    public function listAction()
    {
        $dao = new Dao;
        $result = $dao->execQuery('SELECT * FROM Person');
        $this->printDump($result, '#ccccff');
        $i = 0;
        foreach ($result as $item) {
            echo $i++;
            echo '<br/>' . PHP_EOL;
            $this->printDump($item, '#ccffff');
        }
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
