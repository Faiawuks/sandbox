<?php

namespace Auction\Financial;

use Auction\Financial\Model\AccountRecord;
use Auction\Financial\Model\Person;

class AccountRecordService implements AccountRecordInterface
{
    /**
     * @inheritdoc
     */
    public function getAccountHolderDetails(Person $accountHolder)
    {
        $accountRecordsExport = array();

        $accountRecords = array('$repository->getAccountRecords()');
        /** @var AccountRecord $accountRecord */
        foreach ($accountRecords as $accountRecord) {
            $accountRecordsExport[] = array(
                'person' => $accountRecord->getPerson()->getName(),
                'transactionDate' => $accountRecord->getTransactionDate()->format('Y-m-d'),
                'transactionAmount' => $accountRecord->getTransactionAmount()
            );
        }

        return $accountRecordsExport;
    }

    /**
     * @inheritdoc
     */
    public function updateAccountingRecord(Person $accountHolder, $transactionAmount)
    {
        $accountRecord = new AccountRecord();
        $accountRecord->setPerson($accountHolder);
        $accountRecord->setTransactionDate(new \DateTime());
        $accountRecord->setTransactionAmount($transactionAmount);

        return $accountRecord;
    }

    /**
     * @inheritdoc
     */
    public function accountNotification(Person $accountHolder, AccountRecord $accountRecord)
    {
        $emailApp = new \stdClass();
        $emailApp->setReceipent($accountRecord->getPerson()->getEmail());
        $emailApp->setSubject('New transaction made for your account.');
        $emailApp->addBody('Amount in Euro:' . $accountRecord->getTransactionAmount());
        $emailApp->addBody('Transaction date:' . $accountRecord->getTransactionDate()->format('Y-m-d'));

        $emailApp->sendEmail();
    }

    /**
     * @inheritdoc
     */
    public function makeReceipt(Person $accountHolder, AccountRecord $accountRecord)
    {
        $printer = new \stdClass();
        $printer->setSubject('New transaction receipt.');
        $printer->addBody('Amount in Euro:' . $accountRecord->getTransactionAmount());
        $printer->addBody('Transaction date:' . $accountRecord->getTransactionDate()->format('Y-m-d'));

        $printer->printReceipt();
    }
}