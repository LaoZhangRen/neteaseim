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

class Update extends Model
{
    /**
     * 更新好友相关信息
     *
     * @param string $accid
     * @param string $faccid
     *
     * @return mixed
     */
    public function go(string $accid, string $faccid)
    {
        $parameters = $this->mergeArgs(['accid' => $accid, 'faccid' => $faccid]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/friend/update.action', $parameters);
    }

    /**
     * 给好友增加备注名，限制长度128，可设置为空字符串
     *
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias(string $alias)
    {
        $this->args['alias'] = $alias;

        return $this;
    }

    /**
     * 修改ex字段，限制长度256，可设置为空字符串
     *
     * @param string $ex
     *
     * @return $this
     */
    public function setEx(string $ex)
    {
        $this->args['ex'] = $ex;

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
            'alias'    => 'sometimes|string|max:128',
            'ex'       => 'sometimes|string|max:256',
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
            'alias.string'    => '给好友增加备注名 : ' . Translate::VALIDATE_STRING,
            'alias.max'       => '给好友增加备注名 : ' . Translate::VALIDATE_MAX_128,
            'serverex.string' => '修改ex字段 : ' . Translate::VALIDATE_STRING,
            'serverex.max'    => '修改ex字段 : ' . Translate::VALIDATE_MAX_256,
            'serverex.string' => '服务器端扩展字段 : ' . Translate::VALIDATE_STRING,
            'serverex.max'    => '服务器端扩展字段 : ' . Translate::VALIDATE_MAX_256,
        ];
    }
}