<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/5
 * Time: 下午2:58
 */

namespace Ailuoy\NeteaseIm;

use Ailuoy\NeteaseIm\Exceptions\ResultReturnException;
use Ailuoy\NeteaseIm\Factory\FriendModelFactory;
use Ailuoy\NeteaseIm\Factory\UserModelFactory;

/**
 * @property UserModelFactory   user
 * @property FriendModelFactory friend
 *
 * Class NeteaseIm
 * @package Ailuoy\NeteaseIm
 */
class NeteaseIm
{
    static public $appKey;
    static public $appSecret;

    public function __construct($appKey, $appSecret)
    {
        self::$appKey = $appKey;
        self::$appSecret = $appSecret;
    }

    private function modelList()
    {
        $modelList = [
            'user'   => UserModelFactory::class,
            'friend' => FriendModelFactory::class,
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