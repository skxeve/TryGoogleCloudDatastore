<?php
namespace App\Controller;

use App\Dao\Datastore as Dao;

class Datastore
{
    public function listAction()
    {
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

    protected function getOne(array $array)
    {
        shuffle($array);
        return array_shift($array);
    }

    protected function printEntity($entity)
    {
        echo '<pre style="background-color: #ccffcc;">';
        var_dump($entity);
        echo '</pre>';
    }
}
