<?php

namespace BankApp;

use BankApp\Model\AccountHolder;
use BankApp\Model\AccountRecord;

class AccountRecordService
{
    /**
     * @param AccountHolder $accountHolder
     * @param \DateTime     $transactionDate
     * @param float         $transactionAmount
     *
     * @return object
     */
    public function updateAccountingRecord(
        AccountHolder $accountHolder,
        \DateTime $transactionDate,
        $transactionAmount
    ) {
        $accountRecord = new \stdClass();
        $accountRecord->setPerson($accountHolder);
        $accountRecord->setTransactionDate($transactionDate);
        $accountRecord->setTransactionAmount($transactionAmount);

        return $accountRecord;
    }

    /**
     * @param AccountRecord $accountRecord
     */
    public function notifyAccountHolder(AccountRecord $accountRecord)
    {
        // Do something to notify the account holder.
    }

    /**
     * @param AccountHolder $accountHolder
     *
     * @return array
     */
    public function findAllRecords(AccountHolder $accountHolder)
    {
        return array();
    }
}