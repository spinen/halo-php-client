<?php

namespace Spinen\Halo;

use Carbon\Carbon;
use Spinen\Halo\Support\Model;

/**
 * Class SoftwareLicence
 *
 * @property ?Carbon $end_date
 * @property ?Carbon $requested_quantity_date
 * @property ?Carbon $start_date
 * @property ?string $billing_cycle
 * @property ?string $distributor
 * @property ?string $manufacturer
 * @property ?string $notes
 * @property ?string $site_name
 * @property ?string $snowid,
 * @property ?string $supplier_name
 * @property ?string $vendor
 * @property bool $deleted
 * @property bool $is_active
 * @property float $monthly_cost
 * @property float $monthly_price
 * @property float $price
 * @property float $purchase_price
 * @property int $assigned_at_deletion
 * @property int $azure_connection_id
 * @property int $client_id
 * @property int $count
 * @property int $id
 * @property int $licences_available
 * @property int $licences_in_use
 * @property int $licences_in_use_user
 * @property int $parent_id
 * @property int $requested_quantity
 * @property int $site_id
 * @property int $supplier_id
 * @property int $type
 * @property string $client_name
 * @property string $licence_client_name
 * @property string $name
 * @property string $name_extra
 */
class SoftwareLicence extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'end_date' => 'datetime',
        'requested_quantity_date' => 'datetime',
        'start_date' => 'datetime',
    ];

    /**
     * Some of the responses have the data under a property
     */
    protected ?string $responseKey = 'licences';

    /**
     * Path to API endpoint.
     */
    protected string $path = '/softwarelicence';
}
