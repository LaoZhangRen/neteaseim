<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/8
 * Time: 上午8:08
 */

namespace Ailuoy\NeteaseIm\Models\User;


use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Translate;

class UnBlock extends Model
{
    public function go(string $accid)
    {
        $parameters = $this->mergeArgs(['accid' => $accid]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/user/unblock.action', $parameters);
    }

    private function rules()
    {
        return [
            'accid' => 'required',
        ];
    }

    private function messages()
    {
        return [
            'accid.required' => Translate::FIELD_USER_ACCID . Translate::VALIDATE_REQUIRED
        ];
    }
}