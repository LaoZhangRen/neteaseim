<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/8
 * Time: 上午8:23
 */

namespace Ailuoy\NeteaseIm\Models\User;


use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Translate;

class Mute extends Model
{
    public function go(string $accid, bool $mute)
    {
        $parameters = ['accid' => $accid, 'mute' => $mute];
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/user/mute.action', $parameters);
    }

    private function rules()
    {
        return [
            'accid' => 'required|string|max:32',
            'mute'  => 'required|boolean'
        ];
    }

    private function messages()
    {
        return [
            'accid.required' => Translate::FIELD_USER_ACCID . Translate::VALIDATE_REQUIRED,
            'accid.string'   => Translate::FIELD_USER_ACCID . Translate::VALIDATE_STRING,
            'accid.max'      => Translate::FIELD_USER_ACCID . Translate::VALIDATE_MAX_32,
            'mute.required'  => '是否全局禁言 : ' . Translate::VALIDATE_REQUIRED,
            'mute.boolean'   => '是否全局禁言 : ' . Translate::VALIDATE_BOOLEAN,
        ];
    }
}