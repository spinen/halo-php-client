<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Asset
 *
 * @property bool $inactive
 * @property bool $non_consignable
 * @property float $key_field3
 * @property int $assettype_id
 * @property int $automate_id
 * @property int $business_owner_cab_id
 * @property int $business_owner_id
 * @property int $client_id
 * @property int $datto_alternate_id
 * @property int $defaultsequence
 * @property int $device_number
 * @property int $id
 * @property int $issue_consignment_line_id
 * @property int $item_id
 * @property int $itemstock_id
 * @property int $ninjarmm_id
 * @property int $reserved_salesorder_id
 * @property int $reserved_salesorder_line_id
 * @property int $site_id
 * @property int $snow_id
 * @property int $status_id
 * @property int $supplier_contract_id
 * @property int $supplier_id
 * @property int $supplier_priority_id
 * @property int $supplier_sla_id
 * @property int $syncroid
 * @property int $technical_owner_cab_id
 * @property int $technical_owner_id
 * @property int $third_party_id
 * @property string $assettype_name
 * @property string $auvik_device_id
 * @property string $auvik_url
 * @property string $client_name
 * @property string $colour
 * @property string $datto_id
 * @property string $datto_url
 * @property string $inventory_number
 * @property string $item_name
 * @property string $itglue_url
 * @property string $key_field
 * @property string $key_field2
 * @property string $site_name
 * @property string $use
 */
class Asset extends Model
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
    protected string $path = '/asset';
}
