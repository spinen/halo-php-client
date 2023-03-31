<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Collection;
use Spinen\Halo\Support\Model;

/**
 * Class TicketType
 *
 * @property bool $agentscanselect
 * @property bool $allowattachments
 * @property bool $anonymouscanselect
 * @property bool $cancreate
 * @property bool $copyattachmentstochild
 * @property bool $enduserscanselect
 * @property bool $is_sprint
 * @property Collection $kanbanstatuschoice
 * @property Collectiontion $kanbanstatuschoice
 * @property Collection $kanbanstatuschoice_list
 * @property int $default_sla
 * @property int $group_id
 * @property int $id
 * @property int $itilrequesttype
 * @property int $sequence
 * @property string $group_name
 * @property string $guid
 * @property string $jira_issue_type
 * @property string $name
 * @property string $use
 */
class TicketType extends Model
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
    protected string $path = '/tickettype';
}
