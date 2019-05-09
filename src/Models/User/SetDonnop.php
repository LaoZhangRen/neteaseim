<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/8
 * Time: 上午8:17
 */

namespace Ailuoy\NeteaseIm\Models\User;


use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Translate;
use Illuminate\Validation\Rule;

class SetDonnop extends Model
{
    public function go(string $accid, string $donnopOpen)
    {
        $parameters = ['accid' => $accid, 'donnopOpen' => $donnopOpen];
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/user/setDonnop.action', $parameters);
    }

    private function rules()
    {
        return [
            'accid'      => 'required|string|max:32',
            'donnopOpen' => [
                'required',
                'string',
                Rule::in(['true', 'false'])
            ],
        ];
    }

    private function messages()
    {
        return [
            'accid.required'      => Translate::FIELD_USER_ACCID . Translate::VALIDATE_REQUIRED,
            'accid.string'        => Translate::FIELD_USER_ACCID . Translate::VALIDATE_STRING,
            'accid.max'           => Translate::FIELD_USER_ACCID . Translate::VALIDATE_MAX_32,
            'donnopOpen.required' => '桌面端在线时，移动端是否不推送 : ' . Translate::VALIDATE_REQUIRED,
            'donnopOpen.string'   => '桌面端在线时，移动端是否不推送 : ' . Translate::VALIDATE_STRING,
            'donnopOpen.in'       => '桌面端在线时，移动端是否不推送 : ' . Translate::VALIDATE_IN_STRING_TRUE_FALSE
        ];
    }
}