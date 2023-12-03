<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Outcome
 *
 * @property array $access_control
 * @property array $fields
 * @property bool $action_resets_response
 * @property bool $actionvisibility
 * @property bool $allow_user_attachments
 * @property bool $bccfollowers
 * @property bool $default_send_to_pagerduty
 * @property bool $default_sync_to_jira
 * @property bool $default_sync_to_salesforce
 * @property bool $default_sync_to_servicenow
 * @property bool $dontshowscreen
 * @property bool $excludeFromDynamicLists
 * @property bool $follow
 * @property bool $hidden
 * @property bool $hideactionfromcandi
 * @property bool $hidecloserequest
 * @property bool $hidefromuser
 * @property bool $hidesendemail
 * @property bool $hidesendsms
 * @property bool $includeallattachments
 * @property bool $includecc
 * @property bool $includeto
 * @property bool $ishiddenfrominternalit
 * @property bool $isimportant
 * @property bool $mustaddnote
 * @property bool $mustassign
 * @property bool $newdetailsfromsource
 * @property bool $newsummaryfromsource
 * @property bool $primaryserviceusersfollow
 * @property bool $report_attach_csv
 * @property bool $report_attach_json
 * @property bool $report_attach_pdf
 * @property bool $report_attach_xls
 * @property bool $setdetailsfromnewticket
 * @property bool $show_email_fields
 * @property bool $show_to_user
 * @property bool $showattachmentstouser
 * @property bool $showautorelease
 * @property bool $showevenifnochild
 * @property bool $showfollowcheckbox
 * @property bool $showhidecheckbox
 * @property bool $showimportantcheckbox
 * @property bool $showsendsurvey
 * @property bool $showslacheckbox
 * @property bool $skip_pending_closure
 * @property bool $slaholdischecked
 * @property bool $slaholdischecked
 * @property bool $slareleaseischecked
 * @property bool $synctodynamics
 * @property bool $synctosap
 * @property bool $translate_before_sending
 * @property bool $update_dynamic_email_list
 * @property bool $usetimer
 * @property float $defaultmanhrs
 * @property float $defaultnonbill
 * @property int $access_control_level
 * @property int $ai_operation
 * @property int $approval_process_id
 * @property int $apptcompletetimetype
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
 * @property int $default_asset_status
 * @property int $default_asset_type
 * @property int $default_linkedticket_status
 * @property int $default_opp_closure_cat
 * @property int $defaultagent
 * @property int $defaultappointmentstatus
 * @property int $defaultappointmenttype
 * @property int $defaultpriority
 * @property int $defaultsupplier_id
 * @property int $defaultuserdef
 * @property int $emailtemplate_id
 * @property int $followersccbcc
 * @property int $id
 * @property int $integration_method_id
 * @property int $logtimeunits
 * @property int $minattachments
 * @property int $newstatus
 * @property int $parentdefaultuser
 * @property int $pdftemplate_id
 * @property int $replytype
 * @property int $reportid
 * @property int $requesttype
 * @property int $respondtype
 * @property int $script_id
 * @property int $sendemail
 * @property int $sendsms
 * @property int $sendsurvey
 * @property int $sequence
 * @property int $supplieremailintellisense
 * @property int $systemid
 * @property int $tagreleasetype
 * @property int $todo_template_id
 * @property int $update_parent_attachment_type
 * @property int $useremailintellisense
 * @property int $worddocid
 * @property int $workflow_id
 * @property string $ai_model
 * @property string $assetsearchtext
 * @property string $automation_runbookid
 * @property string $buttonname
 * @property string $ccoverride
 * @property string $colour
 * @property string $customurl
 * @property string $default_note
 * @property string $defaultcat1
 * @property string $defaultteam
 * @property string $fieldvisible
 * @property string $guid
 * @property string $hotkey
 * @property string $icon
 * @property string $icon
 * @property string $labellong
 * @property string $outcome
 * @property string $quoter_template
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
    protected $casts = [
        'access_control_level' => 'int',
        'action_resets_response' => 'bool',
        'actionvisibility' => 'bool',
        'ai_model' => 'string',
        'ai_operation' => 'int',
        'allow_user_attachments' => 'bool',
        'approval_process_id' => 'int',
        'apptcompletetimetype' => 'int',
        'assetsearchtext' => 'string',
        'automation_runbookid' => 'string',
        'azure_action' => 'int',
        'azure_connection_id' => 'int',
        'bccfollowers' => 'bool',
        'buttonimage' => 'int',
        'buttonname' => 'string',
        'callscreencallscript' => 'int',
        'ccoverride' => 'string',
        'chargerate' => 'int',
        'child_emailtemplate_id' => 'int',
        'child_template_id' => 'int',
        'child_ticket_type_id' => 'int',
        'colour_type' => 'int',
        'colour' => 'string',
        'createchildticketortemplate' => 'int',
        'customurl' => 'string',
        'default_asset_status' => 'int',
        'default_asset_type' => 'int',
        'default_linkedticket_status' => 'int',
        'default_note' => 'string',
        'default_opp_closure_cat' => 'int',
        'default_send_to_pagerduty' => 'bool',
        'default_sync_to_jira' => 'bool',
        'default_sync_to_salesforce' => 'bool',
        'default_sync_to_servicenow' => 'bool',
        'defaultagent' => 'int',
        'defaultappointmentstatus' => 'int',
        'defaultappointmenttype' => 'int',
        'defaultcat1' => 'string',
        'defaultmanhrs' => 'float',
        'defaultnonbill' => 'float',
        'defaultpriority' => 'int',
        'defaultsupplier_id' => 'int',
        'defaultteam' => 'string',
        'defaultuserdef' => 'int',
        'dontshowscreen' => 'bool',
        'emailtemplate_id' => 'int',
        'excludeFromDynamicLists' => 'bool',
        'fieldvisible' => 'string',
        'follow' => 'bool',
        'followersccbcc' => 'int',
        'guid' => 'string',
        'hidden' => 'bool',
        'hideactionfromcandi' => 'bool',
        'hidecloserequest' => 'bool',
        'hidefromuser' => 'bool',
        'hidesendemail' => 'bool',
        'hidesendsms' => 'bool',
        'hotkey' => 'string',
        'icon' => 'string',
        'icon' => 'string',
        'id' => 'int',
        'includeallattachments' => 'bool',
        'includecc' => 'bool',
        'includeto' => 'bool',
        'integration_method_id' => 'int',
        'ishiddenfrominternalit' => 'bool',
        'isimportant' => 'bool',
        'labellong' => 'string',
        'logtimeunits' => 'int',
        'minattachments' => 'int',
        'mustaddnote' => 'bool',
        'mustassign' => 'bool',
        'newdetailsfromsource' => 'bool',
        'newstatus' => 'int',
        'newsummaryfromsource' => 'bool',
        'outcome' => 'string',
        'parentdefaultuser' => 'int',
        'pdftemplate_id' => 'int',
        'primaryserviceusersfollow' => 'bool',
        'quoter_template' => 'string',
        'replytype' => 'int',
        'report_attach_csv' => 'bool',
        'report_attach_json' => 'bool',
        'report_attach_pdf' => 'bool',
        'report_attach_xls' => 'bool',
        'reportid' => 'int',
        'requesttype' => 'int',
        'respondtype' => 'int',
        'script_id' => 'int',
        'sendemail' => 'int',
        'sendsms' => 'int',
        'sendsurvey' => 'int',
        'sequence' => 'int',
        'setdetailsfromnewticket' => 'bool',
        'show_email_fields' => 'bool',
        'show_to_user' => 'bool',
        'showattachmentstouser' => 'bool',
        'showautorelease' => 'bool',
        'showevenifnochild' => 'bool',
        'showfollowcheckbox' => 'bool',
        'showhidecheckbox' => 'bool',
        'showimportantcheckbox' => 'bool',
        'showsendsurvey' => 'bool',
        'showslacheckbox' => 'bool',
        'skip_pending_closure' => 'bool',
        'slaholdischecked' => 'bool',
        'slaholdischecked' => 'bool',
        'slareleaseischecked' => 'bool',
        'supplieremailintellisense' => 'int',
        'synctodynamics' => 'bool',
        'synctosap' => 'bool',
        'systemid' => 'int',
        'tagreleasetype' => 'int',
        'tfstype' => 'string',
        'todo_template_id' => 'int',
        'tooverride' => 'string',
        'translate_before_sending' => 'bool',
        'update_dynamic_email_list' => 'bool',
        'update_parent_attachment_type' => 'int',
        'useremailintellisense' => 'int',
        'usetimer' => 'bool',
        'worddocid' => 'int',
        'worddocpath' => 'string',
        'workflow_id' => 'int',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/outcome';


    /**
     * Some of the responses have the data under a property
     */
    protected ?string $responseKey = 'invaild_to_stop_peeling';
    // NOTE: This is a hack until we fix this in the Builder by making it smarter
}
