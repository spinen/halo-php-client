<?php

namespace Spinen\Halo;

use Carbon\Carbon;
use Spinen\Halo\Support\Model;

/**
 * Class Opportunity
 *
 * @property bool $closed_in_integration_system
 * @property bool $excludefromsla
 * @property bool $flagged
 * @property bool $inactive
 * @property bool $is_vip
 * @property bool $isimportantcontact
 * @property bool $onhold
 * @property bool $projectinternaltask
 * @property bool $read
 * @property bool $release_important
 * @property Carbon $dateoccurred
 * @property Carbon $deadlinedate
 * @property Carbon $fixbydate
 * @property Carbon $lastactiondate
 * @property Carbon $lastincomingemail
 * @property Carbon $respondbydate
 * @property Carbon $targetdate
 * @property float $cost
 * @property float $estimate
 * @property float $estimatedays
 * @property float $oppvalueadjusted
 * @property float $slaholdtime
 * @property int $agent_id
 * @property int $appointment_type
 * @property int $attachment_count
 * @property int $child_count
 * @property int $client_id
 * @property int $department_id
 * @property int $enduserstatus
 * @property int $id
 * @property int $impact
 * @property int $impactlevel
 * @property int $itil_requesttype_id
 * @property int $matched_kb_id
 * @property int $maximumRestrictedPriority
 * @property int $notuseful_count
 * @property int $organisation_id
 * @property int $priority_id
 * @property int $product_id
 * @property int $quantity
 * @property int $release_id
 * @property int $release2_id
 * @property int $release3_id
 * @property int $releasenotegroup_id
 * @property int $site_id
 * @property int $sla_id
 * @property int $source
 * @property int $starttimeslot
 * @property int $status_id
 * @property int $supplier_status
 * @property int $targettimeslot
 * @property int $ticketage
 * @property int $tickettype_id
 * @property int $urgency
 * @property int $useful_count
 * @property int $user_id
 * @property int $workflow_id
 * @property int $workflow_step
 * @property string $category_1
 * @property string $category_2
 * @property string $category_3
 * @property string $category_4
 * @property string $client_name
 * @property string $details
 * @property string $emailtolist
 * @property string $idsummary
 * @property string $oppcompanyname
 * @property string $oppcontactname
 * @property string $oppemailaddress
 * @property string $opptimezonename
 * @property string $opptype
 * @property string $reportedby
 * @property string $section_timezone
 * @property string $site_name
 * @property string $site_timezone
 * @property string $starttime
 * @property string $summary
 * @property string $targettime
 * @property string $team
 * @property string $use
 * @property string $user_name
 * @property string $userdef1
 * @property string $userdef2
 * @property string $userdef3
 * @property string $userdef4
 * @property string $userdef5
 */
class Opportunity extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dateoccurred' => 'datetime',
        'deadlinedate' => 'datetime',
        'fixbydate' => 'datetime',
        'lastactiondate' => 'datetime',
        'lastincomingemail' => 'datetime',
        'respondbydate' => 'datetime',
        'targetdate' => 'datetime',
    ];

    // TODO: This is wrapped up under "tickets"
    // "record_count" => 5,
    // "tickets" => [  here  ]

    /**
     * Path to API endpoint.
     */
    protected string $path = '/opportunities';
}
