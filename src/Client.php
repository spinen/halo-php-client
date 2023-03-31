<?php

namespace Spinen\Halo;

use Carbon\Carbon;
use Spinen\Halo\Support\Collection;
use Spinen\Halo\Support\Model;

/**
 * Class Client
 *
 * @property bool $all_organisations_allowed
 * @property bool $allowall_category1
 * @property bool $allowall_category2
 * @property bool $allowall_category3
 * @property bool $allowall_category4
 * @property bool $allowall_tickettypes
 * @property bool $allowallchargerates
 * @property bool $alocked
 * @property bool $billforrecurringprepayamount
 * @property bool $dontinvoice
 * @property bool $emailinvoice
 * @property bool $excludefrominvoicesync
 * @property bool $floverride
 * @property bool $fluserdef1hide
 * @property bool $fluserdef1mand
 * @property bool $fluserdef2hide
 * @property bool $fluserdef2mand
 * @property bool $fluserdef3hide
 * @property bool $fluserdef3mand
 * @property bool $fluserdef4hide
 * @property bool $fluserdef4mand
 * @property bool $fluserdef5hide
 * @property bool $fluserdef5mand
 * @property bool $hubspot_archived
 * @property bool $hubspot_dont_sync
 * @property bool $inactive
 * @property bool $includeactions
 * @property bool $invoiceyes
 * @property bool $is_vip
 * @property bool $isarchived_xero
 * @property bool $isnhserveremaildefault
 * @property bool $monthlyreportemaildirect
 * @property bool $monthlyreportemailmanager
 * @property bool $monthlyreportinclude
 * @property bool $monthlyreportshowonweb
 * @property bool $needsinvoice
 * @property bool $override_org_logo
 * @property bool $override_portalcolour
 * @property bool $prepayrecurringminimumdeductiononlyactive
 * @property bool $priassign
 * @property bool $prinotify
 * @property bool $secassign
 * @property bool $secnotify
 * @property bool $showslaonweb
 * @property bool $taxable
 * @property bool $ticket_invoices_for_each_site
 * @property Carbon $alastupdate
 * @property Carbon $datecreated
 * @property Collection $allowed_tickettypes
 * @property Collection $custombuttons
 * @property Collection $customfields
 * @property Collection $external_links
 * @property Collection $popup_notes
 * @property float $prepayrecurringautomaticdeduction
 * @property float $prepayrecurringminimumdeduction
 * @property int $actionemail
 * @property int $ateraid
 * @property int $autotaskid
 * @property int $billinggroup
 * @property int $cautomateid
 * @property int $clearemail
 * @property int $client_to_invoice
 * @property int $client_to_invoice_recurring
 * @property int $confirmemail
 * @property int $connectwiseid
 * @property int $contract_tax_code
 * @property int $createdfrom_id
 * @property int $datto_alternate_id
 * @property int $datto_commerce_id
 * @property int $default_currency_code
 * @property int $default_mailbox_id
 * @property int $device42id
 * @property int $fcemail
 * @property int $id
 * @property int $imageindex
 * @property int $invoiceduedaysextraclient
 * @property int $item_tax_code
 * @property int $kashflow_tenant_id
 * @property int $kashflowid
 * @property int $linked_organisation_id
 * @property int $mailbox_override
 * @property int $main_site_id
 * @property int $messagegroup_id
 * @property int $ninjarmmid
 * @property int $overridepdftemplateinvoice
 * @property int $percentage_to_survey
 * @property int $preferreddeliverymethod
 * @property int $prepay_tax_code
 * @property int $purchase_tax_code
 * @property int $qbodefaulttax
 * @property int $qbodefaulttaxcode
 * @property int $sentinel_default_user_override
 * @property int $service_tax_code
 * @property int $snow_id
 * @property int $syncroid
 * @property int $toplevel_id
 * @property string $accountsbccemailaddress
 * @property string $accountsfirstname
 * @property string $accountslastname
 * @property string $client_to_invoice_name
 * @property string $client_to_invoice_recurring_name
 * @property string $clientcurrency
 * @property string $colour
 * @property string $contractaccountsdesc
 * @property string $datto_id
 * @property string $datto_url
 * @property string $dbc_company_id
 * @property string $defcat1
 * @property string $defcat2
 * @property string $defcat3
 * @property string $defcat4
 * @property string $itglue_id
 * @property string $jira_url
 * @property string $jira_username
 * @property string $kaseyaid
 * @property string $logo
 * @property string $main_site_name
 * @property string $name
 * @property string $override_org_email
 * @property string $override_org_name
 * @property string $override_org_phone
 * @property string $override_org_portalurl
 * @property string $override_org_website
 * @property string $portalbackgroundimageurl
 * @property string $portalchatprofile
 * @property string $portalcolour
 * @property string $prepayaccountsdesc
 * @property string $qbodefaulttaxcodename
 * @property string $sentinel_resource_group_name
 * @property string $sentinel_subscription_id
 * @property string $sentinel_workspace_name
 * @property string $servicenow_locale
 * @property string $servicenow_url
 * @property string $servicenow_username
 * @property string $servicenowid
 * @property string $snelstart_id
 * @property string $thirdpartynhdapiclientid
 * @property string $thirdpartynhdapiurl
 * @property string $thirdpartynhdauthurl
 * @property string $thirdpartynhdtenant
 * @property string $toplevel_name
 * @property string $trading_name
 * @property string $use
 * @property string $website
 * @property string $xero_tenant_id
 * @property string $xeroid
 */
class Client extends Model
{
    /**
     * The float attributes
     *
     * @var array
     */
    protected $casts = [
        'alastupdate' => 'datetime',
        'datecreated' => 'datetime',
    ];

    /**
     * Path float to
     */
    protected string $path = '/client';
}
