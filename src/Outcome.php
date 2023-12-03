<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Outcome
 *
 * @property bool $action_resets_response
 * @property bool $actionvisibility
 * @property bool $bccfollowers
 * @property bool $dontshowscreen
 * @property bool $excludeFromDynamicLists
 * @property bool $follow
 * @property bool $hidden
 * @property bool $hideactionfromcandi
 * @property bool $hidecloserequest
 * @property bool $hidefromuser
 * @property bool $hidesendemail
 * @property bool $hidesendsms
 * @property bool $includecc
 * @property bool $includeto
 * @property bool $isimportant
 * @property bool $mustaddnote
 * @property bool $mustassign
 * @property bool $newdetailsfromsource
 * @property bool $newsummaryfromsource
 * @property bool $setdetailsfromnewticket
 * @property bool $show_email_fields
 * @property bool $showattachmentstouser
 * @property bool $showautorelease
 * @property bool $showevenifnochild
 * @property bool $showfollowcheckbox
 * @property bool $showhidecheckbox
 * @property bool $showimportantcheckbox
 * @property bool $showslacheckbox
 * @property bool $skip_pending_closure
 * @property bool $slaholdischecked
 * @property bool $slareleaseischecked
 * @property bool $synctodynamics
 * @property bool $synctosap
 * @property bool $update_dynamic_email_list
 * @property bool $usetimer
 * @property float $defaultmanhrs
 * @property float $defaultnonbill
 * @property int $approval_process_id
 * @property int $azure_action
 * @property int $azure_connection_id
 * @property int $buttonimage
 * @property int $callscreencallscript
 * @property int $chargerate
 * @property int $child_emailtemplate_id
 * @property int $child_template_id
 * @property int $child_ticket_type_id
 * @property int $colour_type
 * @property int $createchildticketortemplate
 * @property int $default_asset_type
 * @property int $default_linkedticket_status
 * @property int $defaultagent
 * @property int $defaultappointmentstatus
 * @property int $defaultpriority
 * @property int $defaultsupplier_id
 * @property int $defaultuserdef
 * @property int $emailtemplate_id
 * @property int $followersccbcc
 * @property int $id
 * @property int $logtimeunits
 * @property int $newstatus
 * @property int $parentdefaultuser
 * @property int $pdftemplate_id
 * @property int $replytype
 * @property int $reportid
 * @property int $requesttype
 * @property int $respondtype
 * @property int $script_id
 * @property int $securitylevel
 * @property int $sendemail
 * @property int $sendsms
 * @property int $sequence
 * @property int $supplieremailintellisense
 * @property int $systemid
 * @property int $todo_template_id
 * @property int $useremailintellisense
 * @property int $worddocid
 * @property int $workflow_id
 * @property string $assetsearchtext
 * @property string $automation_runbookname
 * @property string $buttonname
 * @property string $ccoverride
 * @property string $colour
 * @property string $customurl
 * @property string $default_note
 * @property string $defaultagent_name
 * @property string $defaultteam
 * @property string $fieldvisible
 * @property string $guid
 * @property string $hotkey
 * @property string $icon
 * @property string $labellong
 * @property string $outcome
 * @property string $script_name
 * @property string $tfstype
 * @property string $tooverride
 * @property string $worddocpath
 */
class Outcome extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/outcome';
}
