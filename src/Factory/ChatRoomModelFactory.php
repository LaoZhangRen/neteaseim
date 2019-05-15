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
use Ailuoy\NeteaseIm\Models\ChatRoom\RequestAddr;
use Ailuoy\NeteaseIm\Models\ChatRoom\SetMemberRole;
use Ailuoy\NeteaseIm\Models\ChatRoom\ToggleCloseStat;
use Ailuoy\NeteaseIm\Models\ChatRoom\Update;
use Ailuoy\NeteaseIm\ResultReturn;
use Ailuoy\NeteaseIm\Exceptions\ResultReturnException;

/**
 * @property Create          create
 * @property Get             get
 * @property GetBatch        getBatch
 * @property Update          update
 * @property ToggleCloseStat toggleCloseStat
 * @property SetMemberRole   setMemberRole
 * @property RequestAddr     requestAddr
 *
 *
 * Class ModuleFactory
 * @package Ailuoy\NeteaseIm\Factory
 */
class ChatRoomModelFactory
{
    /**
     * 模型列表
     *
     * @return \Ailuoy\NeteaseIm\ResultReturnStructure
     */
    private function modelList()
    {
        $modelList = [
            'create'          => Create::class,
            'get'             => Get::class,
            'getBatch'        => GetBatch::class,
            'update'          => Update::class,
            'toggleCloseStat' => ToggleCloseStat::class,
            'setMemberRole'   => SetMemberRole::class,
            'requestAddr'     => RequestAddr::class,
        ];

        return ResultReturn::success($modelList);
    }


    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * @param $name
     *
     * @return mixed
     * @throws ResultReturnException
     */
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