<?php
namespace App\Http;

/**
 * 即興ルータークラス
 * 色々ガバい気がする
 */
class SimpleRouter
{
    protected $path;
    protected $queryString;
    protected $method;

    protected $pathList;
    protected $queryMap;

    protected $actionExecuted = false;

    public function __construct()
    {
        $this->path = $_SERVER['REQUEST_URI'];
        $this->queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->pathList = $this->parsePath($this->path);
        parse_str($this->queryString, $this->queryMap);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new Exception('Undefined property '.$name);
    }

    protected function parsePath($path)
    {
        $pathList = explode('/', $path);
        if (count($pathList) >= 1 && $pathList[0] === '') {
            array_shift($pathList);
        }
        if (count($pathList) >= 1 && $pathList[count($pathList) - 1] === '') {
            array_pop($pathList);
        }
        return $pathList;
    }

    public function get($path, $class = null, $method = 'getAction')
    {
        return $this->request('GET', $path, $class, $method);
    }

    public function request($method = null, $path = '', $class = null, $func = 'action')
    {
        if ($method !== null && $this->method !== $method) {
            return false;
        }
        $pl = $this->parsePath($path);
        if (count($this->pathList) < count($pl)) {
            return false;
        }
        foreach ($pl as $i => $str) {
            if ($str !== $this->pathList[$i]) {
                return false;
            }
        }
        // action
        if ($class !== null) {
            if ($this->isFirstAction()) {
                try {
                    $c = new $class($this->queryMap);
                    $c->$func($this->queryMap);
                } catch (\Exception $e) {
                    echo '<pre style="background-color: #ffcccc">' . $e->__toString() . '</pre>';
                }
            } else {
                // error log
            }
        }
        return true;
    }

    public function all($class, $method = 'action')
    {
        return $this->request(null, '', $class, $method);
    }

    protected function isFirstAction()
    {
        $r = !$this->actionExecuted;
        $this->actionExecuted = true;
        return $r;
    }
}
