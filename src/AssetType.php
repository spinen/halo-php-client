<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Collection;
use Spinen\Halo\Support\Model;

/**
 * Class AssetType
 *
 * @property array $bookingtypes
 * @property array $fields
 * @property array $xtype_roles
 * @property bool $allowall_status
 * @property bool $enableresourcebooking
 * @property bool $resourcebooking_allow_asset_selection
 * @property bool $show_to_users
 * @property bool $useteamviewer
 * @property float $fiveyearlycost
 * @property float $fouryearlycost
 * @property float $monthlycost
 * @property float $quarterlycost
 * @property float $resourcebooking_max_days_advance
 * @property float $resourcebooking_min_hours_advance
 * @property float $sixmonthlycost
 * @property float $threeyearlycost
 * @property float $twoyearlycost
 * @property float $weeklycost
 * @property float $yearlycost
 * @property int $asset_details_tab_display
 * @property int $assetgroup_id
 * @property int $businessowner_visibility
 * @property int $column_profile_id
 * @property int $defaultsequence
 * @property int $dependencies_visibility
 * @property int $fiid
 * @property int $id
 * @property int $keyfield_id
 * @property int $keyfield2_id
 * @property int $keyfield3_id
 * @property int $linkedcontracttype
 * @property int $manufacturer
 * @property int $notes_visibility
 * @property int $priority_visibility
 * @property int $resourcebooking_asset_restriction_type
 * @property int $resourcebooking_site_selection_type
 * @property int $resourcebooking_workdays_id
 * @property int $s_control_level
 * @property int $services_visibility
 * @property int $sla_visibility
 * @property int $supplier1
 * @property int $technicalowner_visibility
 * @property int $visibility_level
 * @property string $columnprofileoverride_name
 * @property string $finame
 * @property string $guid
 * @property string $item_code
 * @property string $keyfield_name
 * @property string $keyfield2_name
 * @property string $keyfield3_name
 * @property string $name
 */
class AssetType extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'access_control_level' => 'int',
        'allowall_status' => 'bool',
        'asset_details_tab_display' => 'int',
        'assetgroup_id' => 'int',
        'businessowner_visibility' => 'int',
        'column_profile_id' => 'int',
        'defaultsequence' => 'int',
        'dependencies_visibility' => 'int',
        'enableresourcebooking' => 'bool',
        'fiid' => 'int',
        'fiveyearlycost' => 'float',
        'fouryearlycost' => 'float',
        'id' => 'int',
        'keyfield_id' => 'int',
        'keyfield2_id' => 'int',
        'keyfield3_id' => 'int',
        'linkedcontracttype' => 'int',
        'manufacturer' => 'int',
        'monthlycost' => 'float',
        'notes_visibility' => 'int',
        'priority_visibility' => 'int',
        'quarterlycost' => 'float',
        'resourcebooking_allow_asset_selection' => 'bool',
        'resourcebooking_asset_restriction_type' => 'int',
        'resourcebooking_max_days_advance' => 'float',
        'resourcebooking_min_hours_advance' => 'float',
        'resourcebooking_site_selection_type' => 'int',
        'resourcebooking_workdays_id' => 'int',
        'services_visibility' => 'int',
        'show_to_users' => 'bool',
        'sixmonthlycost' => 'float',
        'sla_visibility' => 'int',
        'supplier1' => 'int',
        'technicalowner_visibility' => 'int',
        'threeyearlycost' => 'float',
        'twoyearlycost' => 'float',
        'useteamviewer' => 'bool',
        'visibility_level' => 'int',
        'weeklycost' => 'float',
        'yearlycost' => 'float',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/assettype';
}
