<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/11
 * Time: 上午9:26
 */

namespace Ailuoy\NeteaseIm\Models\Msg;


use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Translate;
use Illuminate\Validation\Rule;

class SendAttachMsg extends Model
{
    /**
     * 发送自定义系统通知
     *
     * @param string $from
     * @param int    $msgType
     * @param string $to
     * @param string $attach
     *
     * @return mixed
     */
    public function go(string $from, int $msgType, string $to, string $attach)
    {
        $parameters = $this->mergeArgs([
            'from'    => $from,
            'msgtype' => $msgType,
            'to'      => $to,
            'attach'  => $attach
        ]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/msg/sendAttachMsg.action', $parameters);
    }

    /**
     * 推送文案，android以此为推送显示文案；ios若未填写payload，显示文案以pushcontent为准。超过500字符后，会对文本进行截断。
     *
     * @param string $pushContent
     *
     * @return $this
     */
    public function setPushContent(string $pushContent)
    {
        $this->args['pushcontent'] = $pushContent;

        return $this;
    }

    /**
     * ios 推送对应的payload,必须是JSON,不能超过2k字符
     *
     * @param array $payload
     *
     * @return $this
     */
    public function setPayload(array $payload)
    {
        $this->args['payload'] = json_encode($payload);

        return $this;
    }

    /**
     * 如果有指定推送，此属性指定为客户端本地的声音文件名，长度不要超过30个字符，如果不指定，会使用默认声音
     *
     * @param string $sound
     *
     * @return $this
     */
    public function setSound(string $sound)
    {
        $this->args['sound'] = $sound;

        return $this;
    }

    /**
     * 1表示只发在线，2表示会存离线，其他会报414错误。默认会存离线
     *
     * @param int $save
     *
     * @return $this
     */
    public function setSave(int $save)
    {
        $this->args['save'] = $save;

        return $this;
    }

    /**
     * 发消息时特殊指定的行为选项,Json格式，可用于指定消息计数等特殊行为;option中字段不填时表示默认值。
     * option示例：
     * {"badge":false,"needPushNick":false,"route":false}
     * 字段说明：
     * 1. badge:该消息是否需要计入到未读计数中，默认true;
     * 2. needPushNick: 推送文案是否需要带上昵称，不设置该参数时默认false(ps:注意与sendMsg.action接口有别);
     * 3. route: 该消息是否需要抄送第三方；默认true (需要app开通消息抄送功能)
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOption(array $options)
    {
        $this->args['option'] = json_encode($options);

        return $this;
    }

    private function rules()
    {
        return [
            'from'        => 'required|string|max:32',
            'msgtype'     => [
                'required',
                'integer',
                Rule::in([0, 1])
            ],
            'to'          => 'required|string',
            'attach'      => 'required|string|max:4096',
            'pushcontent' => 'sometimes|string|max:500',
            'payload'     => 'sometimes|json',
            'sound'       => 'sometimes|string|max:30',
            'save'        => [
                'sometimes',
                'integer',
                Rule::in([1, 2])
            ],
            'option'      => 'sometimes|json',
        ];
    }

    private function messages()
    {
        return [
            'from.required'      => '发送者accid : ' . Translate::VALIDATE_REQUIRED,
            'from.string'        => '发送者accid : ' . Translate::VALIDATE_STRING,
            'from.max'           => '发送者accid : ' . Translate::VALIDATE_MAX_32,
            'msgtype.required'   => '消息消息type : ' . Translate::VALIDATE_REQUIRED,
            'msgtype.integer'    => '消息消息type : ' . Translate::VALIDATE_INT,
            'msgtype.in'         => '消息消息type : 必须是 0|1',
            'to.required'        => '接受者id : ' . Translate::VALIDATE_REQUIRED,
            'to.string'          => '接受者id : ' . Translate::VALIDATE_STRING,
            'attach.required'    => '自定义通知内容 : ' . Translate::VALIDATE_REQUIRED,
            'attach.string'      => '自定义通知内容 : ' . Translate::VALIDATE_STRING,
            'attach.max'         => '自定义通知内容 : ' . Translate::VALIDATE_MAX_4096,
            'pushcontent.string' => '推送文案 : ' . Translate::VALIDATE_STRING,
            'pushcontent.max'    => '推送文案 : 最大500个字符',
            'payload.json'       => 'ios 推送对应的payload : 类型必须是json',
            'sound.string'       => '本地声音文件名 : ' . Translate::VALIDATE_STRING,
            'sound.max'          => '本地声音文件名 : 最大30个字符',
            'save.integer'       => '在线|离线状态 : ' . Translate::VALIDATE_INT,
            'save.in'            => '在线|离线状态 : 值类型必须是 1|2 ',
            'option.json'        => '发消息时特殊指定的行为选项 : 类型必须是json',
        ];
    }
}