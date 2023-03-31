<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Item
 *
 * @property bool $doesnotneedconsigning
 * @property bool $dontinvoice
 * @property bool $iscontractitem
 * @property bool $isrecurringitem
 * @property bool $promptforprice
 * @property bool $purchasetaxincluded
 * @property bool $salestaxincluded
 * @property bool $taxable
 * @property float $baseprice
 * @property float $costprice
 * @property float $markupperc
 * @property float $maxitemdiscount
 * @property float $qboinitial_quantity_date
 * @property float $quantity_in_stock
 * @property float $recurringcost
 * @property float $recurringprice
 * @property int $assetaccountcode
 * @property int $assetgroup_id
 * @property int $assettype_id
 * @property int $autotaskproductid
 * @property int $autotaskserviceid
 * @property int $costingmethod
 * @property int $created_by
 * @property int $id
 * @property int $item_default_billing_period
 * @property int $kashflow_tenant_id
 * @property int $kashflowid
 * @property int $linked_item_id
 * @property int $primaryimageid
 * @property int $qbo_quantity
 * @property int $status
 * @property int $supplier_id
 * @property int $taxcode
 * @property int $taxcodeother
 * @property int $template_id
 * @property int $type
 * @property string $asset_account_name
 * @property string $assetgroup_name
 * @property string $assettype_name
 * @property string $dbc_company_id
 * @property string $expense_account_name
 * @property string $income_account_name
 * @property string $item_group_nominalcode
 * @property string $item_group_nominalcode_purchase
 * @property string $name
 * @property string $nominalcode
 * @property string $purchasenominalcode
 * @property string $qbocategoryid
 * @property string $qbocategoryname
 * @property string $qbosku
 * @property string $snelstart_department_id
 * @property string $snelstart_department_name
 * @property string $snelstart_id
 * @property string $supplier_name
 * @property string $use
 * @property string $xero_tenant_id
 */
class Item extends Model
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
    protected string $path = '/item';
}
