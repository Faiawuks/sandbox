<?php

namespace Auction\Financial;

use Auction\Financial\Model\AccountRecord;
use Auction\Financial\Model\Person;

interface AccountRecordInterface
{
    /**
     * @param Person $accountHolder
     *
     * @return array
     */
    public function getAccountHolderDetails(Person $accountHolder);

    /**
     * @param Person $accountHolder
     * @param float  $transactionAmount
     *
     * @return AccountRecord
     */
    public function updateAccountingRecord(Person $accountHolder, $transactionAmount);

    /**
     * @param Person        $accountHolder
     * @param AccountRecord $accountRecord
     */
    public function accountNotification(Person $accountHolder, AccountRecord $accountRecord);

    /**
     * @param Person        $accountHolder
     * @param AccountRecord $accountRecord
     */
    public function makeReceipt(Person $accountHolder, AccountRecord $accountRecord);
}
