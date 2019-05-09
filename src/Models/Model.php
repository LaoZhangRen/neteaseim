<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/7
 * Time: 下午9:51
 */

namespace Ailuoy\NeteaseIm\Models;


use Ailuoy\NeteaseIm\Contracts\ModelInterface;
use Ailuoy\NeteaseIm\Factory\HttpClient;
use Ailuoy\NeteaseIm\Factory\ValidationFactory;

abstract class Model implements ModelInterface
{
    protected $args = [];

    protected function mergeArgs(array $arr)
    {
        return array_merge($arr, $this->args);
    }

    protected function validation(array $rules, array $messages, array $parameters)
    {
        ValidationFactory::check($rules, $messages, $parameters);
    }

    protected function sendRequest($method, $api, $parameters)
    {
        return HttpClient::send($method, $api, $parameters)->data;
    }
}