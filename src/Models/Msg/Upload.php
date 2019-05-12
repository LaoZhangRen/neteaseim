<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/11
 * Time: 上午10:01
 */

namespace Ailuoy\NeteaseIm\Models\Msg;


use Ailuoy\NeteaseIm\Translate;
use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Exceptions\ParameterErrorException;

class Upload extends Model
{
    /**
     * 文件上传
     *
     * @param string $content
     *
     * @return mixed
     */
    public function go(string $content)
    {
        $parameters = $this->mergeArgs(['content' => $content]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/msg/upload.action', $parameters);
    }

    /**
     * 上传文件类型
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type)
    {
        $this->args['type'] = $type;

        return $this;
    }

    /**
     * 返回的url是否需要为https的url，true或false，默认false
     *
     * @param bool $isHttps
     *
     * @return $this
     */
    public function setIsHttps(bool $isHttps)
    {
        $this->args['ishttps'] = $isHttps ? 'true' : 'false';

        return $this;
    }

    /**
     * 文件过期时长
     *
     * @param int $expireSec
     *
     * @return $this
     * @throws ParameterErrorException
     */
    public function setExpireSec(int $expireSec)
    {
        if ($expireSec < 86400) {
            throw new ParameterErrorException('文件过期时长 时间大于等于 86400');
        }
        $this->args['expireSec'] = $expireSec;

        return $this;
    }

    /**
     * 文件的应用场景
     *
     * @param string $tag
     *
     * @return $this
     */
    public function setTag(string $tag)
    {
        $this->args['tag'] = $tag;

        return $this;
    }

    private function rules()
    {
        return [
            'content'   => 'required|string',
            'type'      => 'sometimes|string',
            'ishttps'   => 'sometimes|string',
            'expireSec' => 'sometimes|integer',
            'tag'       => 'sometimes|string|max:32',
        ];
    }

    private function messages()
    {
        return [
            'content.required'  => '字符流base64串(Base64.encode(bytes)) : ' . Translate::VALIDATE_REQUIRED,
            'content.string'    => '字符流base64串(Base64.encode(bytes)) : ' . Translate::VALIDATE_STRING,
            'type.string'       => '上传文件类型 : ' . Translate::VALIDATE_STRING,
            'ishttps.string'    => '返回的url是否需要为https的url : ' . Translate::VALIDATE_STRING,
            'expireSec.integer' => '文件过期时长 : ' . Translate::VALIDATE_INT,
            'tag.required'      => '文件的应用场景 : ' . Translate::VALIDATE_REQUIRED,
            'tag.string'        => '文件的应用场景 : ' . Translate::VALIDATE_STRING,
            'tag.max'           => '文件的应用场景 : ' . Translate::VALIDATE_MAX_32,
        ];
    }

}