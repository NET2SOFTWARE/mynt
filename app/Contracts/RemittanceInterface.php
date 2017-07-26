<?php

namespace App\Contracts;


interface RemittanceInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function delete(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function inquiry(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function inquiryStatus(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function transfer(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function getHashCreateData(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function getHashDeleteData(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function getHashInquiryData(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function getHashInquiryStatusData(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function getHashTransferData(array $data);

    /**
     * @return mixed
     */
    public function getNewId();

    /**
     * @param array $data
     * @return mixed
     */
    public function createRemittanceDb(array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteRemittanceDb(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id);

    /**
     * @return mixed
     */
    public function gets();

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteFromDB(int $id);
}