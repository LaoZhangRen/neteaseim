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

class Block extends Model
{
    public function go(string $accid)
    {
        $parameters = $this->mergeArgs(['accid' => $accid]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/user/block.action', $parameters);
    }

    /**
     * 是否踢掉被禁用户，true或false，默认false
     *
     * @param bool $needKick
     *
     * @return $this
     */
    public function setNeedkick(bool $needKick)
    {
        $strNeedKick = $needKick ? 'true' : 'false';
        $this->args['needkick'] = $strNeedKick;

        return $this;
    }

    private function rules()
    {
        return [
            'accid'    => 'required|string|max:32',
            'needkick' => [
                'sometimes',
                'string',
                Rule::in(['true', 'false'])
            ],
        ];
    }

    private function messages()
    {
        return [
            'accid.required'  => Translate::FIELD_USER_ACCID . Translate::VALIDATE_REQUIRED,
            'accid.string'    => Translate::FIELD_USER_ACCID . Translate::VALIDATE_STRING,
            'accid.max'       => Translate::FIELD_USER_ACCID . Translate::VALIDATE_MAX_32,
            'needkick.string' => '是否踢掉被禁用户 : ' . Translate::VALIDATE_STRING,
            'needkick.in'     => '是否踢掉被禁用户 : ' . Translate::VALIDATE_IN_STRING_TRUE_FALSE
        ];
    }
}