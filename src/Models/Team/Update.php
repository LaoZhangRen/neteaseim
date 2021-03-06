<?php
/**
 * Created by PhpStorm.
 * User: ailuoy
 * Date: 2019/5/11
 * Time: 下午2:17
 */

namespace Ailuoy\NeteaseIm\Models\Team;


use Ailuoy\NeteaseIm\Models\Model;
use Ailuoy\NeteaseIm\Translate;
use Illuminate\Validation\Rule;

class Update extends Model
{

    /**
     * 编辑群资料
     *
     * @param string $tid
     * @param string $owner
     *
     * @return mixed
     */
    public function go(string $tid, string $owner)
    {
        $parameters = $this->mergeArgs([
            'tid'   => $tid,
            'owner' => $owner,
        ]);
        $this->validation($this->rules(), $this->messages(), $parameters);

        return $this->sendRequest('POST', 'nimserver/team/update.action', $parameters);
    }

    /**
     * 群名称，最大长度64字符
     *
     * @param string $tName
     *
     * @return $this
     */
    public function setTName(string $tName)
    {
        $this->args['tname'] = $tName;

        return $this;
    }


    /**
     * 群公告，最大长度1024字符
     *
     * @param string $announcement
     *
     * @return $this
     */
    public function setAnnouncement(string $announcement)
    {
        $this->args['announcement'] = $announcement;

        return $this;
    }

    /**
     * 群描述，最大长度512字符
     *
     * @param string $intro
     *
     * @return $this
     */
    public function setIntro(string $intro)
    {
        $this->args['intro'] = $intro;

        return $this;
    }

    /**
     * 群建好后，sdk操作时，0不用验证，1需要验证,2不允许任何人加入。其它返回414
     *
     * @param int $joinMode
     *
     * @return $this
     */
    public function setJoinMode(int $joinMode)
    {
        $this->args['joinmode'] = $joinMode;

        return $this;
    }

    /**
     * 自定义高级群扩展属性，第三方可以跟据此属性自定义扩展自己的群属性。（建议为json）,最大长度1024字符
     *
     * @param string $custom
     *
     * @return $this
     */
    public function setCustom(string $custom)
    {
        $this->args['msg'] = $custom;

        return $this;
    }

    /**
     * 群头像，最大长度1024字符
     *
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon)
    {
        $this->args['icon'] = $icon;

        return $this;
    }

    /**
     * 被邀请人同意方式，0-需要同意(默认),1-不需要同意。其它返回414
     *
     * @param int $beInviteMode
     *
     * @return $this
     */
    public function setBeInviteMode(int $beInviteMode)
    {
        $this->args['beinvitemode'] = $beInviteMode;

        return $this;
    }

    /**
     * 谁可以邀请他人入群，0-管理员(默认),1-所有人。其它返回414
     *
     * @param int $inviteMode
     *
     * @return $this
     */
    public function setInviteMode(int $inviteMode)
    {
        $this->args['invitemode'] = $inviteMode;

        return $this;
    }

    /**
     * 谁可以修改群资料，0-管理员(默认),1-所有人。其它返回414
     *
     * @param int $uptInfoMode
     *
     * @return $this
     */
    public function setUptInfoMode(int $uptInfoMode)
    {
        $this->args['uptinfomode'] = $uptInfoMode;

        return $this;
    }

    /**
     * 谁可以更新群自定义属性，0-管理员(默认),1-所有人。其它返回414
     *
     * @param int $upCustomMode
     *
     * @return $this
     */
    public function setUpCustomMode(int $upCustomMode)
    {
        $this->args['upcustommode'] = $upCustomMode;

        return $this;
    }

    /**
     * 该群最大人数(包含群主)，范围：2至应用定义的最大群人数(默认:200)。其它返回414
     *
     * @param int $teamMemberLimit
     *
     * @return $this
     */
    public function setTeamMemberLimit(int $teamMemberLimit)
    {
        $this->args['teamMemberLimit'] = $teamMemberLimit;

        return $this;
    }

    private function rules()
    {
        return [
            'tid'             => 'required|string|max:128',
            'owner'           => 'required|string|max:32',
            'tname'           => 'sometimes|string|max:32',
            'announcement'    => 'sometimes|string|max:1024',
            'intro'           => 'sometimes|string|max:512',
            'joinmode'        => [
                'sometimes',
                'integer',
                Rule::in([0, 1, 2])
            ],
            'custom'          => 'sometimes|string|max:1024',
            'icon'            => 'sometimes|string|max:1024',
            'beinvitemode'    => [
                'sometimes',
                'integer',
                Rule::in([0, 1])
            ],
            'invitemode'      => [
                'sometimes',
                'integer',
                Rule::in([0, 1])
            ],
            'uptinfomode'     => [
                'sometimes',
                'integer',
                Rule::in([0, 1])
            ],
            'upcustommode'    => [
                'sometimes',
                'integer',
                Rule::in([0, 1])
            ],
            'teamMemberLimit' => [
                'sometimes',
                'integer'
            ],
        ];
    }

    private function messages()
    {


        return [
            'tid.required'            => 'team_id : ' . Translate::VALIDATE_REQUIRED,
            'tid.string'              => 'team_id : ' . Translate::VALIDATE_STRING,
            'tid.max'                 => 'team_id : ' . Translate::VALIDATE_MAX_128,
            'owner.required'          => '群主用户帐号 : ' . Translate::VALIDATE_REQUIRED,
            'owner.string'            => '群主用户帐号 : ' . Translate::VALIDATE_STRING,
            'owner.max'               => '群主用户帐号 : ' . Translate::VALIDATE_MAX_32,
            'tname.string'            => '群名称 : ' . Translate::VALIDATE_STRING,
            'tname.max'               => '群名称 : ' . Translate::VALIDATE_MAX_64,
            'announcement.string'     => '群公告 : ' . Translate::VALIDATE_STRING,
            'announcement.max'        => '群公告 : ' . Translate::VALIDATE_MAX_1024,
            'intro.string'            => '群描述 : ' . Translate::VALIDATE_STRING,
            'intro.max'               => '群描述 : ' . Translate::VALIDATE_MAX_512,
            'joinmode.integer'        => '加入群的验证 : ' . Translate::VALIDATE_INT,
            'joinmode.in'             => '加入群的验证 : 值只能值 0 | 1 | 2',
            'custom.string'           => '自定义高级群扩展属性 : ' . Translate::VALIDATE_STRING,
            'custom.max'              => '自定义高级群扩展属性 : ' . Translate::VALIDATE_MAX_1024,
            'icon.string'             => '群头像 : ' . Translate::VALIDATE_STRING,
            'icon.max'                => '群头像 : ' . Translate::VALIDATE_MAX_1024,
            'beinvitemode.integer'    => '被邀请人同意方式 : ' . Translate::VALIDATE_INT,
            'beinvitemode.in'         => '被邀请人同意方式 : 值只能值 0 | 1',
            'invitemode.integer'      => '谁可以邀请他人入群 : ' . Translate::VALIDATE_INT,
            'invitemode.in'           => '谁可以邀请他人入群 : 值只能值 0 | 1',
            'uptinfomode.integer'     => '谁可以修改群资料 : ' . Translate::VALIDATE_INT,
            'uptinfomode.in'          => '谁可以修改群资料 : 值只能值 0 | 1',
            'upcustommode.integer'    => '谁可以更新群自定义属性 : ' . Translate::VALIDATE_INT,
            'upcustommode.in'         => '谁可以更新群自定义属性 : 值只能值 0 | 1',
            'teamMemberLimit.integer' => '该群最大人数(包含群主) : ' . Translate::VALIDATE_INT,
        ];
    }
}