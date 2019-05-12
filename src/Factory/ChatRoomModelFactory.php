<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/6
 * Time: 下午4:53
 */

namespace Ailuoy\NeteaseIm\Factory;

use Ailuoy\NeteaseIm\Models\ChatRoom\Create;
use Ailuoy\NeteaseIm\Models\ChatRoom\Get;
use Ailuoy\NeteaseIm\Models\ChatRoom\GetBatch;
use Ailuoy\NeteaseIm\ResultReturn;
use Ailuoy\NeteaseIm\Exceptions\ResultReturnException;

/**
 * @property Create   create
 * @property Get      get
 * @property GetBatch getBatch
 *
 *
 * Class ModuleFactory
 * @package Ailuoy\NeteaseIm\Factory
 */
class ChatRoomModelFactory
{

    private function modelList()
    {
        $modelList = [
            'create'   => Create::class,
            'get'      => Get::class,
            'getBatch' => GetBatch::class
        ];

        return ResultReturn::success($modelList);
    }


    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function __get($name)
    {
        $modelList = $this->modelList()->data;
        if (!isset($modelList[$name])) {
            throw new ResultReturnException($name . ' model 不存在');
        }
        $model = new $modelList[$name];

        return $model;
    }
}