<?php namespace EC\Api;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class CResult extends CResult_Base
{

    static public function Success($message = '')
    {
        return new CResult(self::SUCCESS, $message);
    }

    static public function Failure($message = '')
    {
        return new CResult(self::FAILURE, $message);
    }

    static public function Error($message = '')
    {
        return new CResult(self::ERROR, $message);
    }


    private $data = [];

    public function __construct(int $result, string $message)
    {
        parent::__construct($result, $message);
    }

    public function add($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function get($name)
    {
        if (!isset($this->data[$name]))
            return null;

        return $this->data[$name];
    }

    public function getJSON()
    {
        $this->data['result'] = $this->getResult();
        $this->data['message'] = $this->getMessage();
        $this->data['EDEBUG'] = $this->getDebug();

        if (EDEBUG)
            $json_string = json_encode($this->data, JSON_PRETTY_PRINT);
        else
            $json_string = json_encode($this->data);

        if ($json_string == null) {
            throw new \Exception('Cannot parse Api\CResult `outputs`: ' .
                    json_last_error_msg());
        }

        return $json_string;
    }

}
