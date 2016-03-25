<?php

namespace Auction\Financial;

use Auction\Financial\Model\AccountRecord;
use Auction\Financial\Model\Person;
use BankApp\AccountRecordService as BankAppAccountRecordService;
use BankApp\AccountHolderService as BankAppAccountHolderService;

class BankAppAccountRecordServiceAdapter implements AccountRecordInterface
{
    /** @var \BankApp\AccountRecordService */
    private $bankAppAccountRecordService;

    /** @var \BankApp\AccountHolderService */
    private $bankAppAccountHolderService;

    /**
     * @param \BankApp\AccountRecordService $bankAppAccountRecordService
     * @param \BankApp\AccountHolderService $bankAppAccountHolderService
     */
    public function __construct(
        BankAppAccountRecordService $bankAppAccountRecordService,
        BankAppAccountHolderService $bankAppAccountHolderService
    ) {
        $this->bankAppAccountRecordService = $bankAppAccountRecordService;
        $this->bankAppAccountHolderService = $bankAppAccountHolderService;
    }

    /**
     * @inheritdoc
     */
    public function getAccountHolderDetails(Person $accountHolder)
    {
        $accountRecordsExport = array();

        $externalAccountRecords = $this->getExternalAccountRecords($accountHolder);
        /** @var \BankApp\Model\AccountRecord $externalAccountRecord */
        foreach ($externalAccountRecords as $externalAccountRecord) {
            $accountRecordsExport[] = array();
        }

        return $accountRecordsExport;
    }

    /**
     * @inheritdoc
     */
    public function updateAccountingRecord(Person $accountHolder, $transactionAmount)
    {
        $bankAppAccountHolder = $this->bankAppAccountHolderService->getAccountHolder(
            $accountHolder->getExternalSearchName()
        );

        $this->bankAppAccountRecordService->updateAccountingRecord(
            $bankAppAccountHolder,
            new \DateTime(),
            $transactionAmount
        );
    }

    /**
     * @inheritdoc
     */
    public function accountNotification(Person $accountHolder, AccountRecord $accountRecord)
    {
        $bankAppAccountRecords = $this->getExternalAccountRecords($accountHolder);
        $this->bankAppAccountRecordService->notifyAccountHolder(
            $bankAppAccountRecords[$accountRecord->getExternalId()]
        );
    }

    /**
     * @inheritdoc
     */
    public function makeReceipt(Person $accountHolder, AccountRecord $accountRecord) { }

    /**
     * @param Person $accountHolder
     *
     * @return \BankApp\Model\AccountRecord[]
     */
    private function getExternalAccountRecords(Person $accountHolder)
    {
        $accountHolder = $this->bankAppAccountHolderService->getAccountHolder($accountHolder->getExternalSearchName());
        return $this->bankAppAccountRecordService->findAllRecords($accountHolder);
    }
}
