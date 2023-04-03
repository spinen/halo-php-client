<?php

namespace Spinen\Halo;

use Carbon\Carbon;
use Spinen\Halo\Support\Model;

/**
 * Class Contract
 *
 * @property bool $active
 * @property bool $expired
 * @property bool $started
 * @property Carbon $end_date
 * @property Carbon $next_invoice_date
 * @property Carbon $periodicinvoicenextdate
 * @property Carbon $start_date
 * @property float $numberofunitsfree
 * @property float $periodchargeamount
 * @property int $billingdescription
 * @property int $billingperiod
 * @property int $client_id
 * @property int $contracttype
 * @property int $id
 * @property int $site_id
 * @property int $sla_id
 * @property int $status
 * @property int $user_id
 * @property string $client_name
 * @property string $contract_status
 * @property string $contracttype_name
 * @property string $cost_calculation
 * @property string $ref
 * @property string $refextra
 * @property string $refextra2
 * @property string $site_name
 * @property string $user_name
 */
class Contract extends Model
{
   /**
    * The name of the "created at" column.
    *
    * @var string
    */
   const CREATED_AT = 'start_date';

    /**
     * The float attributes
     *
     * @var array
     */
    protected $casts = [
        'end_date' => 'datetime',
        'next_invoice_date' => 'datetime',
        'periodicinvoicenextdate' => 'datetime',
        'start_date' => 'datetime',
    ];

    /**
     * Path float to
     */
    protected string $path = '/clientcontract';
}
