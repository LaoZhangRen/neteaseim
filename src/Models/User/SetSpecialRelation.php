<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/8
 * Time: 上午7:49
 */

namespace Ailuoy\NeteaseIm\Models\User;


use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Translate;
use Illuminate\Validation\Rule;

class SetSpecialRelation extends Model
{
    /**
     * 设置黑名单/静音
     *
     * @param string $accId
     * @param string $targetAcc
     * @param int    $relationType
     * @param int    $value
     *
     * @return mixed
     */
    public function go(string $accId, string $targetAcc, int $relationType, int $value)
    {
        $parameters = [
            'accid'        => $accId,
            'targetAcc'    => $targetAcc,
            'relationType' => $relationType,
            'value'        => $value
        ];
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/user/setSpecialRelation.action', $parameters);
    }

    /**
     * @return array
     */
    private function rules()
    {
        return [
            'accid'        => 'required|string|max:32',
            'targetAcc'    => 'required|string|max:32',
            'relationType' => [
                'required',
                'integer',
                Rule::in([1, 2])
            ],
            'value'        => [
                'required',
                'integer',
                Rule::in([0, 1])
            ]
        ];
    }

    /**
     * @return array
     */
    private function messages()
    {
        return [
            'accid.required'        => '加好友发起者accid : ' . Translate::VALIDATE_REQUIRED,
            'accid.string'          => '加好友发起者accid : ' . Translate::VALIDATE_STRING,
            'accid.max'             => '加好友发起者accid : ' . Translate::VALIDATE_MAX_32,
            'targetAcc.required'    => '被加黑或加静音的帐号 : ' . Translate::VALIDATE_REQUIRED,
            'targetAcc.string'      => '被加黑或加静音的帐号 : ' . Translate::VALIDATE_STRING,
            'targetAcc.max'         => '被加黑或加静音的帐号 : ' . Translate::VALIDATE_MAX_32,
            'relationType.required' => '本次操作的关系类型 : ' . Translate::VALIDATE_REQUIRED,
            'relationType.integer'  => '本次操作的关系类型 : ' . Translate::VALIDATE_INT,
            'relationType.integer'  => '本次操作的关系类型 : ' . '值必须是 1|2',
            'value.required'        => '操作值 : ' . Translate::VALIDATE_REQUIRED,
            'value.integer'         => '操作值 : ' . Translate::VALIDATE_INT,
            'value.integer'         => '操作值 : ' . '值必须是 0|1',
        ];
    }
}