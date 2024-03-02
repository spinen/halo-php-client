<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Collection;
use Spinen\Halo\Support\Model;

/**
 * Class Asset
 *
 * @property bool $bookmarked
 * @property bool $inactive
 * @property bool $non_consignable
 * @property Collection $custombuttons
 * @property Collection $customfields
 * @property Collection $fields
 * @property int $access_control_level
 * @property int $assettype_id
 * @property int $automate_id
 * @property int $business_owner_cab_id
 * @property int $business_owner_id
 * @property int $client_id
 * @property int $commissioned
 * @property int $contract_id
 * @property int $criticality
 * @property int $datto_alternate_id
 * @property int $defaultsequence
 * @property int $device_number
 * @property int $device42_id
 * @property int $goodsin_po_id
 * @property int $id
 * @property int $issue_consignment_line_id
 * @property int $item_cost
 * @property int $item_id
 * @property int $itemstock_id
 * @property int $ncentral_details_id
 * @property int $ninjarmm_id
 * @property int $passportal_id
 * @property int $priority_id
 * @property int $prtg_id
 * @property int $reserved_salesorder_id
 * @property int $reserved_salesorder_line_id
 * @property int $site_id
 * @property int $sla_id
 * @property int $status_id
 * @property int $stockbin_id
 * @property int $supplier_contract_id
 * @property int $supplier_id
 * @property int $supplier_priority_id
 * @property int $supplier_sla_id
 * @property int $syncroid
 * @property int $technical_owner_cab_id
 * @property int $technical_owner_id
 * @property int $third_party_id
 * @property string $addigy_id
 * @property string $assettype_name
 * @property string $ateraid
 * @property string $auvik_device_id
 * @property string $auvik_network_id
 * @property string $azureTenantId
 * @property string $business_owner_name
 * @property string $client_name
 * @property string $colour
 * @property string $contract_ref
 * @property string $datto_id
 * @property string $datto_url
 * @property string $dlastupdate
 * @property string $icon
 * @property string $intune_id
 * @property string $inventory_number
 * @property string $itglue_id
 * @property string $itglue_url
 * @property string $key_field
 * @property string $key_field2
 * @property string $key_field3
 * @property string $lansweeper_id
 * @property string $lansweeper_url
 * @property string $last_modified
 * @property string $qualys_id
 * @property string $site_name
 * @property string $supplier_contract_ref
 * @property string $supplier_name
 * @property string $technical_owner_name
 * @property string $use
 */
class Asset extends Model
{
    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'last_modified';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dlastupdate' => 'datetime',
        'last_modified' => 'datetime',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/asset';
}
