<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/8
 * Time: 上午7:49
 */

namespace Ailuoy\NeteaseIm\Models\Friend;

use Ailuoy\NeteaseIm\Translate;
use Ailuoy\NeteaseIm\Models\Model;
class Get extends Model
{
    /**
     * 获取好友关系
     *
     * @param string $accId
     * @param int    $updateTime
     *
     * @return mixed
     */
    public function go(string $accId, int $updateTime)
    {
        $parameters = $this->mergeArgs(['accid' => $accId, 'updatetime' => $updateTime]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/friend/get.action', $parameters);
    }

    /**
     *【Deprecated】定义同updatetime
     *
     * @param int $createTime
     *
     * @return $this
     */
    public function setCreateTime(int $createTime)
    {
        $this->args['createtime'] = $createTime;

        return $this;
    }

    private function rules()
    {
        return [
            'accid'      => 'required|string|max:32',
            'updatetime' => 'required|integer',
            'createtime' => 'sometimes|integer'
        ];
    }

    private function messages()
    {
        return [
            'accid.required'      => '发起者accid : ' . Translate::VALIDATE_REQUIRED,
            'accid.string'        => '发起者accid : ' . Translate::VALIDATE_STRING,
            'accid.max'           => '发起者accid : ' . Translate::VALIDATE_MAX_32,
            'updatetime.required' => '更新时间戳 : ' . Translate::VALIDATE_REQUIRED,
            'updatetime.integer'  => '更新时间戳 : ' . Translate::VALIDATE_INT,
            'createtime.integer'  => 'createtime : ' . Translate::VALIDATE_INT
        ];
    }
}