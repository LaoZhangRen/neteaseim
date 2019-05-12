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

class ListBlackAndMuteList extends Model
{
    /**
     * 查看指定用户的黑名单和静音列表
     *
     * @param string $accId
     *
     * @return mixed
     */
    public function go(string $accId)
    {
        $parameters = ['accid' => $accId];
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/user/listBlackAndMuteList.action', $parameters);
    }

    /**
     * @return array
     */
    private function rules()
    {
        return [
            'accid' => 'required|string|max:32'
        ];
    }

    /**
     * @return array
     */
    private function messages()
    {
        return [
            'accid.required' => Translate::FIELD_USER_ACCID . Translate::VALIDATE_REQUIRED,
            'accid.string'   => Translate::FIELD_USER_ACCID . Translate::VALIDATE_STRING,
            'accid.max'      => Translate::FIELD_USER_ACCID . Translate::VALIDATE_MAX_32
        ];
    }
}