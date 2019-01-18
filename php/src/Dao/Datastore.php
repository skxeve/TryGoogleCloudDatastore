<?php
namespace App\Dao;

use Google\Cloud\Datastore\DatastoreClient;

class Datastore
{
    protected $ds;

    protected static $SERVER_KEY_PROJECT_ID     = 'APP_DATASTORE_PROJECT_ID';
    protected static $SERVER_KEY_NAMESPACE_ID   = 'APP_DATASTORE_NAMESPACE_ID';

    public function __construct()
    {
        $key = self::$SERVER_KEY_PROJECT_ID;
        $projectId = isset($_SERVER[$key]) ? $_SERVER[$key] : 'default_project_id';
        $parameter = [
            'projectId' => $projectId,
        ];

        $key = self::$SERVER_KEY_NAMESPACE_ID;
        if (isset($_SERVER[$key])) {
            $parameter['namespaceId'] = $_SERVER[$key];
        }

        $this->ds = new DatastoreClient($parameter);
    }

    public function createEntityObject($kind)
    {
        $entity = $this->ds->entity($kind);
        return $entity;
    }

    public function insert($entity)
    {
        return $this->ds->insert($entity);
    }

    public function update($entity)
    {
        return $this->ds->update($entity);
    }

    public function get($kind, $id)
    {
        $key = $this->ds->key($kind, $id);
        $entity = $this->ds->lookup($key);
        return $entity;
    }
}
