<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Collection;
use Spinen\Halo\Support\Model;

/**
 * Class Agent
 *
 * @property bool $_canupdate
 * @property bool $_canupdate_moreinfo
 * @property bool $dontemailmeifiloggedit
 * @property bool $enablehighcontrast
 * @property bool $enableshifts
 * @property bool $excludefromresourcebooking
 * @property bool $is_agent
 * @property bool $is_online
 * @property bool $isapiagent
 * @property bool $isdisabled
 * @property bool $new_method
 * @property bool $orion_access
 * @property bool $sendowneremails
 * @property bool $warnifnoscan_integrator
 * @property Carbon $datecreated
 * @property Carbon $exchange_token_expiry
 * @property Carbon $lastlogindate
 * @property Collection $assetfields
 * @property Collection $assettypes
 * @property Collection $chargerates
 * @property Collection $clients
 * @property Collection $custombuttons
 * @property Collection $customfields
 * @property Collection $departments
 * @property Collection $qualifications
 * @property Collection $teams
 * @property Collection $tickettypes
 * @property Collection $uname_usercustomfields
 * @property Collection $unameappointmenttypes
 * @property Collection $unamecustomfields
 * @property float $costprice
 * @property float $holiday_allowance
 * @property float $lunchbreak
 * @property float $pomincostforapproval
 * @property float $quotemarginforapproval
 * @property int $actionscreen_display_type
 * @property int $adconnection
 * @property int $app_colour_type
 * @property int $autotaskid
 * @property int $chargerate
 * @property int $clientdetails_layout_id
 * @property int $default_action_display
 * @property int $default_columns_id_assets
 * @property int $default_columns_id_opps
 * @property int $default_columns_id_tickets
 * @property int $default_filter_id_opps
 * @property int $default_filter_id_tickets
 * @property int $default_ticket_preview_size
 * @property int $homescreenchartid
 * @property int $homescreendashboardid
 * @property int $id
 * @property int $language_id
 * @property int $licence_type
 * @property int $linemanager
 * @property int $list_type
 * @property int $nav_display_mode
 * @property int $navmenu_mode
 * @property int $newtabpref
 * @property int $onlinestatus
 * @property int $onlinestatus_actual
 * @property int $pagesize
 * @property int $pomincostforapprovaltype
 * @property int $quotemarginforapprovaltype
 * @property int $ticket_preview_mode
 * @property int $travelrate
 * @property int $useadlogin
 * @property int $warnifnoscan_integrator_hours
 * @property int $workday_id
 * @property string $app_colour
 * @property string $calendar_options
 * @property string $colour
 * @property string $default_action_view
 * @property string $default_calendar_view
 * @property string $default_feed_view
 * @property string $email
 * @property string $firstname
 * @property string $initials
 * @property string $lastonline
 * @property string $name
 * @property string $ncentral_username
 * @property string $oktaid
 * @property string $orion_password
 * @property string $orion_username
 * @property string $signature
 * @property string $team
 * @property string $theme
 * @property string $use
 */
class Agent extends Model
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'datecreated';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'lastlogindate';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'datecreated' => 'datetime',
        'exchange_token_expiry' => 'datetime',
        'lastlogindate' => 'datetime',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/agent';
}
