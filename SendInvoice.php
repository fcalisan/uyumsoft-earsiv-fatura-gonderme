<?php

namespace App\Uyumsoft;

use App\Http\Helpers\StaticHelper;
use App\Models\CorporateEArchiveInformation;
use App\Models\Invoice;
use App\Models\Online\SiteOrder;
use App\Models\Online\SiteSetting;
use App\Uyumsoft\Entities\AccountingCustomerPartyEntity;
use App\Uyumsoft\Entities\AccountingSupplierPartyEntity;
use App\Uyumsoft\Entities\ContactEntity;
use App\Uyumsoft\Entities\IdEntity;
use App\Uyumsoft\Entities\InvoicedQuantityEntity;
use App\Uyumsoft\Entities\InvoiceEntity;
use App\Uyumsoft\Entities\InvoiceLineEntity;
use App\Uyumsoft\Entities\InvoiceLineItemEntity;
use App\Uyumsoft\Entities\LegalMonetaryTotalEntity;
use App\Uyumsoft\Entities\PartyEntity;
use App\Uyumsoft\Entities\PartyIdentificationEntity;
use App\Uyumsoft\Entities\PartyNameEntity;
use App\Uyumsoft\Entities\PartyTaxSchemeEntity;
use App\Uyumsoft\Entities\PersonEntity;
use App\Uyumsoft\Entities\PostalAddressEntity;
use App\Uyumsoft\Entities\PriceAmountEntity;
use App\Uyumsoft\Entities\PriceEntity;
use App\Uyumsoft\Entities\TaxAmountEntity;
use App\Uyumsoft\Entities\TaxCategoryEntity;
use App\Uyumsoft\Entities\TaxSchemeEntity;
use App\Uyumsoft\Entities\TaxSubTotalEntity;
use App\Uyumsoft\Entities\TaxTotalEntity;
use Illuminate\Support\Facades\Cache;

class SendInvoice
{
    private SiteOrder $siteOrder;
    private CorporateEArchiveInformation $eArchiveInformation;
    private Invoice $invoice;


    public function __construct(SiteOrder $siteOrder)
    {
        $this->siteOrder = $siteOrder;
        $this->eArchiveInformation = Cache::rememberForever('e_archive_information_' . $this->siteOrder->corporate_id, function () {
            return CorporateEArchiveInformation::where('corporate_id', $this->siteOrder->corporate_id)->first();
        });

        $this->getInvoice();

        $this->siteOrder->load([
            'user' => function ($query) {
                $query->with(['student' => function ($query) {
                    $query->with('contact');
                }]);
            }
        ]);
    }

    private function getInvoice()
    {
        $this->invoice = Invoice::where('id', $this->siteOrder->invoice_id)
            ->with([
                'items' => function ($query) {
                    $query->with([
                        'stock',
                        'tax',
                    ]);
                },
                'invoiceTotal',
            ])
            ->first();

        if (!$this->invoice) {
            throw new \Exception('Fatura bilgisi bulunamadı');
        }
    }

    public function prepareEntities(): array
    {

        $invoiceEntity = new InvoiceEntity();
        $invoiceEntity->setLocalDocumentId($this->siteOrder->order_no);

        // FİRMA BİLGİLERİ
        $partyIdentificationEntity = new PartyIdentificationEntity();
        $partyIdentificationEntity->addIdEntity((new IdEntity())->setSchemeId($this->eArchiveInformation->fatura_sema == "TCKN" ? "TCKN" : "VKN")->setValue(9000068418));
        $partyIdentificationEntity->addIdEntity((new IdEntity())->setSchemeId("MERSISNO")->setValue($this->eArchiveInformation->mersis_no));
        $partyIdentificationEntity->addIdEntity((new IdEntity())->setSchemeId("TICARETSICILNO")->setValue($this->eArchiveInformation->ticaret_sicil_no));

        $partyNameEntity = new PartyNameEntity();
        $partyNameEntity->setName($this->eArchiveInformation->unvan);

        $postalAddressEntity = new PostalAddressEntity();
        $postalAddressEntity->setStreetName($this->eArchiveInformation->sokak_adi);
        $postalAddressEntity->setBuildingNumber($this->eArchiveInformation->bina_no);
        $postalAddressEntity->setCitySubdivisionName($this->eArchiveInformation->semt);
        $postalAddressEntity->setCityName($this->eArchiveInformation->sehir);
        $postalAddressEntity->setCountry($this->eArchiveInformation->ulke);

        $taxSchemeEntity = new TaxSchemeEntity();
        $taxSchemeEntity->setName($this->eArchiveInformation->vergi_dairesi);

        $partyTaxSchemeEntity = new PartyTaxSchemeEntity();
        $partyTaxSchemeEntity->setTaxScheme($taxSchemeEntity);

        $personEntity = new PersonEntity();
        $personEntity->setFirstName($this->eArchiveInformation->sorumlu_ad);
        $personEntity->setFamilyName($this->eArchiveInformation->sorumlu_soyad);


        $partyEntity = new PartyEntity();
        $partyEntity->setPartyIdentification($partyIdentificationEntity);
        $partyEntity->setPartyName($partyNameEntity);
        $partyEntity->setPostalAddress($postalAddressEntity);
        $partyEntity->setPerson($personEntity);
        $partyEntity->setPartyTaxScheme($partyTaxSchemeEntity);


        $accountingSupplierPartyEntity = new AccountingSupplierPartyEntity();
        $accountingSupplierPartyEntity->setPartyEntity($partyEntity);
        // FİRMA BİLGİLERİ


        // MÜŞTERİ BİLGİLERİ
        $partyIdentificationEntity = new PartyIdentificationEntity();
        $partyIdentificationEntity->addIdEntity((new IdEntity())->setSchemeId("TCKN")->setValue($this->siteOrder->user->identity_no ?? "11111111111"));

        $partyNameEntity = new PartyNameEntity();
        $partyNameEntity->setName($this->siteOrder->user->fullname);

        $studentContact = $this->siteOrder->user->student->contact;
        if (!$studentContact) {
            throw new \Exception('Müşteri ile ilgili bilgiler bulunamadı');
        }

        $postalAddressEntity = new PostalAddressEntity();
        $postalAddressEntity->setCitySubdivisionName($studentContact->region);
        $postalAddressEntity->setCityName($studentContact->city);
        $postalAddressEntity->setCountry("Türkiye");

        $taxSchemeEntity = new TaxSchemeEntity();
        $taxSchemeEntity->setName("");

        $partyTaxSchemeEntity = new PartyTaxSchemeEntity();
        $partyTaxSchemeEntity->setTaxScheme($taxSchemeEntity);

        $personEntity = new PersonEntity();
        $personEntity->setFirstName($this->siteOrder->user->name);
        $personEntity->setFamilyName($this->siteOrder->user->lastname);

        $contactEntity = new ContactEntity();
        $contactEntity->setTelephone($studentContact->phone);

        $partyEntity = new PartyEntity();
        $partyEntity->setPartyIdentification($partyIdentificationEntity);
        $partyEntity->setPartyName($partyNameEntity);
        $partyEntity->setPostalAddress($postalAddressEntity);
        $partyEntity->setPerson($personEntity);
        $partyEntity->setPartyTaxScheme($partyTaxSchemeEntity);


        $accountingCustomerPartyEntity = new AccountingCustomerPartyEntity();
        $accountingCustomerPartyEntity->setPartyEntity($partyEntity);

        // MÜŞTERİ BİLGİLERİ

        $invoiceEntity->setAccountingSupplierParty($accountingSupplierPartyEntity);
        $invoiceEntity->setAccountingCustomerParty($accountingCustomerPartyEntity);
        $invoiceEntity->setLegalMonetaryTotal(new LegalMonetaryTotalEntity());


        // ÜRÜN BİLGİLERİ
        $id = 1;
        $vatRatioArray = [];
        foreach ($this->invoice->items as $item) {

            if (!isset($vatRatioArray[$item->tax->tax_ratio])) {
                $vatRatioArray[$item->tax->tax_ratio] = [
                    'tax_ratio' => $item->tax->tax_ratio,
                    'tax_amount' => $item->total_tax,
                    'total_tax' => 0,
                    'total_price' => 0
                ];
            }

            $invoiceLineEntity = new InvoiceLineEntity();

            $invoiceLineItemEntity = new InvoiceLineItemEntity();
            $invoiceLineItemEntity->setDescription("");
            $invoiceLineItemEntity->setModelName("");
            $invoiceLineItemEntity->setName($item->stock->title);

            $invoiceLineEntity->setItem($invoiceLineItemEntity);

            $invoiceLineEntity->setId($id);
            $invoiceLineEntity->setNote("");
            $invoiceLineEntity->setInvoicedQuantity((new InvoicedQuantityEntity())->setValue($item->quantity));
            $invoiceLineEntity->setLineExtensionAmount((new TaxAmountEntity())->setValue($item->unit_price));

            $taxTotalEntity = new TaxTotalEntity();
            $taxTotalEntity->setTaxAmount((new TaxAmountEntity())->setValue($item->total_tax));

            $taxSubTotalEntity = new TaxSubTotalEntity();
            $taxSubTotalEntity->setTaxableAmount((new TaxAmountEntity())->setValue($item->unit_price));
            $taxSubTotalEntity->setTaxAmount((new TaxAmountEntity())->setValue($item->total_tax));
            $taxSubTotalEntity->setPercent($item->tax->tax_ratio);


            $taxSchemeEntity = new TaxSchemeEntity();
            $taxSchemeEntity->setName('KDV');
            $taxSchemeEntity->setTaxTypeCode('0015');

            $taxCategoryEntity = new TaxCategoryEntity();
            $taxCategoryEntity->setTaxScheme($taxSchemeEntity);

            $taxSubTotalEntity->setTaxCategory($taxCategoryEntity);
            $taxTotalEntity->setTaxSubTotal([$taxSubTotalEntity]);


            $priceAmountEntity = new PriceAmountEntity();
            $priceAmountEntity->setValue($item->unit_price);

            $priceEntity = new PriceEntity();
            $priceEntity->setPriceAmount($priceAmountEntity);
            $invoiceLineEntity->setPrice($priceEntity);

            $invoiceLineEntity->setTaxTotal($taxTotalEntity);

            $invoiceEntity->addInvoiceLine($invoiceLineEntity);


            $vatRatioArray[$item->tax->tax_ratio]['total_tax'] += $item->total_tax;
            $vatRatioArray[$item->tax->tax_ratio]['total_price'] += $item->unit_price;


            $id++;
        }

        $taxTotalEntity = new TaxTotalEntity();
        $taxTotalEntity->setTaxAmount((new TaxAmountEntity())->setValue($this->invoice->invoiceTotal->total_tax));
        $taxSubTotalArray = [];

        $invoiceEntity->addNoteLine("Fatura Notu -1");
        $invoiceEntity->addNoteLine("#" . StaticHelper::priceToText($this->invoice->invoiceTotal->total_price) . "#");


        foreach ($vatRatioArray as $vatRatioItem) {
            $taxSubTotalEntity = new TaxSubTotalEntity();

            $taxableAmount = new TaxAmountEntity();
            $taxableAmount->setValue($vatRatioItem['total_price']);

            $taxAmount = new TaxAmountEntity();
            $taxAmount->setValue($vatRatioItem['total_tax']);

            $taxSubTotalEntity->setTaxableAmount($taxableAmount);
            $taxSubTotalEntity->setTaxAmount($taxAmount);
            $taxSubTotalEntity->setPercent($vatRatioItem['tax_ratio']);

            $taxSchemeEntity = new TaxSchemeEntity();
            $taxSchemeEntity->setName('KDV');
            $taxSchemeEntity->setTaxTypeCode('0015');

            $taxCategoryEntity = new TaxCategoryEntity();
            $taxCategoryEntity->setTaxScheme($taxSchemeEntity);

            $taxSubTotalEntity->setTaxCategory($taxCategoryEntity);

            $taxSubTotalArray[] = $taxSubTotalEntity;
        }

        // ÜRÜN BİLGİLERİ

        $taxTotalEntity->setTaxSubTotal($taxSubTotalArray);
        $invoiceEntity->setTaxTotal($taxTotalEntity);
        $invoiceEntity->setLineCountNumeric($this->invoice->items->count());

        $legalMonetaryTotalEntity = new LegalMonetaryTotalEntity();

        $lineExtensionAmount = new TaxAmountEntity();
        $lineExtensionAmount->setValue($this->invoice->invoiceTotal->gross_amount);
        $taxExclusiveAmount = new TaxAmountEntity();
        $taxExclusiveAmount->setValue($this->invoice->invoiceTotal->gross_amount);
        $taxInclusiveAmount = new TaxAmountEntity();
        $taxInclusiveAmount->setValue($this->invoice->invoiceTotal->total_price);
        $allowanceTotalAmount = new TaxAmountEntity();
        $allowanceTotalAmount->setValue($this->invoice->total->sub_total_discount ?? 0);
        $payableAmount = new TaxAmountEntity();
        $payableAmount->setValue($this->invoice->invoiceTotal->total_price);

        $legalMonetaryTotalEntity->setLineExtensionAmount($lineExtensionAmount);
        $legalMonetaryTotalEntity->setTaxExclusiveAmount($taxExclusiveAmount);
        $legalMonetaryTotalEntity->setTaxInclusiveAmount($taxInclusiveAmount);
        $legalMonetaryTotalEntity->setAllowanceTotalAmount($allowanceTotalAmount);
        $legalMonetaryTotalEntity->setPayableAmount($payableAmount);
        $invoiceEntity->setLegalMonetaryTotal($legalMonetaryTotalEntity);



        return $invoiceEntity->getArray();
    }

    private function checkEArchiveInformation()
    {
        if (!$this->eArchiveInformation) {
            throw new \Exception('E-Arşiv bilgileri bulunamadı');
        }

        if ($this->eArchiveInformation->uyumsoft_username == "" || $this->eArchiveInformation->uyumsoft_password == "") {
            throw new \Exception('E-Arşiv bilgileri eksik');
        }
    }

    public function createInvoice()
    {
        $entities = $this->prepareEntities();
        $json = [
            'Action' => 'SendInvoice',
            'parameters' =>
            array_merge(
                [
                    ...$entities,
                    'EArchiveInvoiceInfo' => [
                        "DeliveryType" => "Electronic"
                    ],
                    "Scenario" => 0,
                    "Notification" => [
                        "Mailing" => [
                            [
                                "Subject" =>  "Fatura: " . $this->siteOrder->order_no . " numaralı sipariş faturanız.",
                                "EnableNotification" => true,
                                "To" =>  "" . $this->siteOrder->email . "",
                                "Attachment" =>  [
                                    "Xml" =>  true,
                                    "Pdf" => true
                                ]
                            ]
                        ]
                    ]
                ],
                ["userInfo" => [
                    "Username" => "Uyumsoft", //$this->eArchiveInformation->uyumsoft_username,
                    "Password" => "Uyumsoft", //$this->eArchiveInformation->uyumsoft_password
                ]]
            ),

        ];

        //dd(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    public function sendInvoice()
    {
        try {
            $this->checkEArchiveInformation();

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://efatura-test.uyumsoft.com.tr/api/BasicIntegrationApi',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_POSTFIELDS => $this->createInvoice(),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
