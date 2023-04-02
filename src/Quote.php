<?php

namespace Spinen\Halo;

use Carbon\Carbon;
use Spinen\Halo\Support\Model;

/**
 * Class Quote
 *
 * @property bool $includegroupeditemprice
 * @property bool $includegroupeditemqty
 * @property bool $includegrouppriceandqty
 * @property bool $includequotationlinenotes
 * @property bool $quote_viewed
 * @property Carbon $approvaldatetime
 * @property Carbon $date
 * @property Carbon $expiry_date
 * @property float $carriage_price
 * @property float $cost
 * @property float $currency_conversion_rate
 * @property float $profit
 * @property float $revenue
 * @property int $agent_id
 * @property int $approvalstate
 * @property int $canned_text_id
 * @property int $client_id
 * @property int $currency_code
 * @property int $datto_commerce_id
 * @property int $daystodeliver
 * @property int $id
 * @property int $internal_approval_status
 * @property int $internal_approvalagent
 * @property int $internal_approvalagentid
 * @property int $pdftemplate_id
 * @property int $site_id
 * @property int $status
 * @property int $ticket_id
 * @property int $user_id
 * @property string $approvalemailaddress
 * @property string $approvalname
 * @property string $approvalnote
 * @property string $auth_by
 * @property string $canned_text_name
 * @property string $carriage_desc
 * @property string $client_name
 * @property string $currency
 * @property string $internal_approvalemailaddress
 * @property string $internal_approvalnote
 * @property string $note
 * @property string $po_ref
 * @property string $qr2filename
 * @property string $risk
 * @property string $scope
 * @property string $site_name
 * @property string $title
 * @property string $use
 * @property string $user_name
 */
class Quote extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'approvaldatetime' => 'datetime',
        'date' => 'datetime',
    ];

    /**
     * Parameter for order by column
     */
    protected string $orderByParameter = 'orderby';

    /**
     * Path to API endpoint.
     */
    protected string $path = '/quotation';
}
