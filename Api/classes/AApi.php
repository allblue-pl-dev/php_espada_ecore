<?php namespace EC\Api;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;


class AApi
{

    private $site = null;
    private $actions = [];

    public function __construct(EC\SApi $site)
    {
        $this->site = $site;
    }

    public function getAction($action_name)
    {
        if (!array_key_exists($action_name, $this->actions))
            return null;

        return $this->actions[$action_name];
    }

    public function getResult($action_name, $args)
    {
        if (!isset($this->actions[$action_name])) {
            return EC\Api\CResult::Failure("Action `{$action_name}`" .
                    ' does not exist.');
        }

        $action = $this->actions[$action_name];

        if (EDEBUG)
            $action['argInfos']['_test'] = false;

        $api_args = new CArgs($action['argInfos']);

        foreach ($action['argInfos'] as $arg_name => $required) {
            if (array_key_exists($arg_name, $args))
                $api_args->$arg_name = $args[$arg_name];
            else if ($required) {
                if ($action['type'] === 'json')
                    return CResult::Failure("`{$arg_name}` not set.");
                else if ($action['type'] === 'bytes') {
                    return new CResult_Bytes(CResult_Base::FAILURE, 
                            "`{$arg_name}` not set.");
                }
            }
        }

        try {
            $result = call_user_func([ $this, $action['fn'] ], $api_args);

            if ($result === null)
                return CResult_Base::Error_Base($action['type'], 'Result cannot be null.');

            // if ($action['type'] === 'json') {
            //     if (!($result instanceof CResult))
            //         return CResult::Error("Result must be an instance of 'CResult'.");
            // } else if ($action['type'] === 'bytes') {
            //     if (!($result instanceof CResult_Bytes))
            //         return CResult_Bytes::Error("Result must be an instance of 'CResult_Bytes'.");
            // }

            return $result;
        } catch (\Exception $e) {
            if (!EDEBUG) {
                E\Exception::NotifyListeners($e);
                if ($action['type'] === 'json')
                    return CResult::Error(INTERNAL_ERROR_MESSAGE);
                else if ($action['type'] === 'bytes') {
                    return new CResult_Bytes(CResult_Base::ERROR, 
                            INTERNAL_ERROR_MESSAGE);
                }
            }

            throw $e;
        }
    }

    protected function action($name, $fn, $arg_infos = [])
    {
        if (!method_exists($this, $fn))
            throw new \Exception("Action method `$fn` does not exist.");

        $this->actions[$name] = [
            'type' => 'json',
            'argInfos' => $arg_infos,
            'fn' => $fn
        ];
    }

    protected function action_Bytes($name, $fn, $arg_infos = [])
    {
        if (!method_exists($this, $fn))
            throw new \Exception("Action method `$fn` does not exist.");

        $this->actions[$name] = [
            'type' => 'bytes',
            'argInfos' => $arg_infos,
            'fn' => $fn
        ];
    }

    protected function getSite()
    {
        return $this->site;
    }

}
