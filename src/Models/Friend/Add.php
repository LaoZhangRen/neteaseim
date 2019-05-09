<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/8
 * Time: 上午7:49
 */

namespace Ailuoy\NeteaseIm\Models\Friend;


use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Translate;
use Illuminate\Validation\Rule;

class Add extends Model
{
    public function go(string $accid, string $faccid, int $type)
    {
        $parameters = $this->mergeArgs(['accid' => $accid, 'faccid' => $faccid, 'type' => $type]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/friend/add.action', $parameters);
    }

    /**
     * 加好友对应的请求消息，第三方组装，最长256字符
     *
     * @param string $msg
     *
     * @return $this
     */
    public function setMsg(string $msg)
    {
        $this->args['msg'] = $msg;

        return $this;
    }

    /**
     * 服务器端扩展字段，限制长度256此字段client端只读，server端读写
     *
     * @param string $serverEx
     *
     * @return $this
     */
    public function setServerEx(string $serverEx)
    {
        $this->args['serverex'] = $serverEx;

        return $this;
    }

    private function rules()
    {
        return [
            'accid'    => 'required|string|max:32',
            'faccid'   => 'required|string|max:32',
            'type'     => [
                'required',
                'integer',
                Rule::in([1, 2, 3, 4])
            ],
            'msg'      => 'sometimes|string|max:256',
            'serverex' => 'sometimes|string|max:256',
        ];
    }

    private function messages()
    {
        return [
            'accid.required'  => '加好友发起者accid : ' . Translate::VALIDATE_REQUIRED,
            'accid.string'    => '加好友发起者accid : ' . Translate::VALIDATE_STRING,
            'accid.max'       => '加好友发起者accid : ' . Translate::VALIDATE_MAX_32,
            'faccid.required' => '加好友接收者accid : ' . Translate::VALIDATE_REQUIRED,
            'faccid.string'   => '加好友接收者accid : ' . Translate::VALIDATE_STRING,
            'faccid.max'      => '加好友接收者accid : ' . Translate::VALIDATE_MAX_32,
            'type.required'   => '加好友类型 : ' . Translate::VALIDATE_REQUIRED,
            'type.integer'    => '加好友类型 : ' . Translate::VALIDATE_INT,
            'type.integer'    => '加好友类型 : ' . '值必须是 1|2|3|4',
            'msg.string'      => '加好友对应的请求消息 : ' . Translate::VALIDATE_STRING,
            'msg.max'         => '加好友对应的请求消息 : ' . Translate::VALIDATE_MAX_256,
            'serverex.string' => '服务器端扩展字段 : ' . Translate::VALIDATE_STRING,
            'serverex.max'    => '服务器端扩展字段 : ' . Translate::VALIDATE_MAX_256,
        ];
    }
}