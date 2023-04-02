<?php

namespace Spinen\Halo;

use Spinen\Halo\Support\Model;

/**
 * Class Invoice
 *
 * @property bool $hideinvoice
 * @property bool $is_recurring_invoice
 * @property bool $posted
 * @property Carbon $datepaid
 * @property Carbon $datesent
 * @property Carbon $invoice_date
 * @property Carbon $schedule_date
 * @property Collection $address
 * @property float $amountdue
 * @property float $amountpaid
 * @property float $currency_conversion_rate
 * @property float $invoicevalue
 * @property float $percent
 * @property float $tax_total
 * @property float $total
 * @property int $add_contract_assets
 * @property int $add_itemsissued
 * @property int $add_labour
 * @property int $add_mileage
 * @property int $add_prepay
 * @property int $add_project
 * @property int $add_salesorder
 * @property int $add_travel
 * @property int $billingcategory
 * @property int $client_id
 * @property int $contract_id
 * @property int $creditlinkedtoinvoiceid
 * @property int $currency_code
 * @property int $datetype
 * @property int $due_date_int
 * @property int $due_date_type
 * @property int $emailstatus
 * @property int $id
 * @property int $invoice_auto_increase_period
 * @property int $invoice_percent_increase
 * @property int $invoicetype
 * @property int $kashflow_tenant_id
 * @property int $original_client_id
 * @property int $paymentstatus
 * @property int $paymentterms
 * @property int $pdftemplate_id
 * @property int $percentold
 * @property int $qboid
 * @property int $recurring_invoice_id
 * @property int $salesorder_id
 * @property int $sitenumber
 * @property int $take_payment_on_duedate
 * @property int $ticket_id
 * @property int $type
 * @property int $uid
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property string $address4
 * @property string $client_name
 * @property string $contract_ref
 * @property string $currency
 * @property string $dbc_company_id
 * @property string $dbc_id
 * @property string $internal_note
 * @property string $invoicenumber
 * @property string $kashflow_pdf
 * @property string $name
 * @property string $site_name
 * @property string $snelstart_id
 * @property string $use
 * @property string $xero_branding_theme_id
 * @property string $xero_branding_theme_name
 * @property string $xero_status
 * @property string $xero_tenant_id
 * @property string $xeroid
 */
class Invoice extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'datepaid' => 'datetime',
        'datesent' => 'datetime',
        'invoice_date' => 'datetime',
        'schedule_date' => 'datetime',
    ];

    /**
     * Parameter for order by direction
     *
     * Default is "$orderByParameter . 'desc'"
     */
    protected ?string $orderByDirectionParameter = 'order';

    /**
     * Parameter for order by column
     */
    protected string $orderByParameter = 'orderby';

    /**
     * Path to API endpoint.
     */
    protected string $path = '/invoice';
}
