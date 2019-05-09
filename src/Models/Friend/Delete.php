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

class Delete extends Model
{
    /**
     * 删除好友
     *
     * @param string $accid
     * @param string $faccid
     *
     * @return mixed
     */
    public function go(string $accid, string $faccid)
    {
        $parameters = $this->mergeArgs(['accid' => $accid, 'faccid' => $faccid]);
        var_dump($parameters);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/friend/delete.action', $parameters);
    }

    /**
     * 是否需要删除备注信息默认false:不需要，true:需要
     *
     * @param bool $isDeleteAlias
     *
     * @return $this
     */
    public function setIsDeleteAlias(bool $isDeleteAlias)
    {
        $this->args['isDeleteAlias'] = $isDeleteAlias;

        return $this;
    }

    private function rules()
    {
        return [
            'accid'         => 'required|string|max:32',
            'faccid'        => 'required|string|max:32',
            'isDeleteAlias' => [
                'sometimes',
                'boolean'
            ]
        ];
    }

    private function messages()
    {
        return [
            'accid.required'        => '发起者accid : ' . Translate::VALIDATE_REQUIRED,
            'accid.string'          => '发起者accid : ' . Translate::VALIDATE_STRING,
            'accid.max'             => '发起者accid : ' . Translate::VALIDATE_MAX_32,
            'faccid.required'       => '要删除朋友的accid : ' . Translate::VALIDATE_REQUIRED,
            'faccid.string'         => '要删除朋友的accid : ' . Translate::VALIDATE_STRING,
            'faccid.max'            => '要删除朋友的accid : ' . Translate::VALIDATE_MAX_32,
            'isDeleteAlias.boolean' => '是否需要删除备注信息 : ' . Translate::VALIDATE_BOOLEAN
        ];
    }
}