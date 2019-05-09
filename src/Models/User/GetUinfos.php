<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/6
 * Time: 下午12:05
 */

namespace Ailuoy\NeteaseIm\Models\User;

use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Translate;

class GetUinfos extends Model
{
    public function go(array $accids)
    {
        $parameters = $this->mergeArgs(['accids' => json_encode($accids)]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/user/getUinfos.action', $parameters);
    }

    private function rules()
    {
        return [
            'accids' => 'required',
        ];
    }

    private function messages()
    {
        return [
            'accids.required' => Translate::FIELD_USER_ACCIDS . Translate::VALIDATE_REQUIRED
        ];
    }
}