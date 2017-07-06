<?php

namespace App\Contracts;

interface MemberInterface extends AppInterface
{

    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    /**
     * @param array $data
     * @return mixed
     */
    public function createProfile(array $data);

    /**
     * @param int $memberId
     * @param int $contactId
     * @return mixed
     */
    public function attachContact(int $memberId, int $contactId);

    /**
     * @param int $memberId
     * @param int $locationId
     * @return mixed
     */
    public function attachLocation(int $memberId, int $locationId);

    /**
     * @param int $memberId
     * @param int $accountId
     * @return mixed
     */
    public function attachAccount(int $memberId, int $accountId);

    /**
     * @param int $memberId
     * @param int $bankId
     * @return mixed
     */
    public function attachBank(int $memberId, int $bankId);

    /**
     * @param int $memberId
     * @param int $roleId
     * @return mixed
     */
    public function attachRole(int $memberId, int $roleId);

    /**
     * @param int $memberId
     * @param int $companyId
     * @return mixed
     */
    public function attachCompany(int $memberId, int $companyId);

    /**
     * @param int $memberId
     * @param int $userId
     * @return mixed
     */
    public function attachUser(int $memberId, int $userId);

    /**
     * @param int $memberId
     * @return mixed
     */
    public function getMyntId(int $memberId);

    /**
     * @param int $memberId
     * @param array $data
     * @return mixed
     */
    public function upgrade(int $memberId, array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function getMemberByUserId(int $id);

    /**
     * @param int $id
     * @param $accountNumber
     * @return mixed
     */
    public function approve(int $id, $accountNumber);


    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * @return mixed
     */
    public function getUnRegister();

    /**
     * @return mixed
     */
    public function getAccountable();

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function createChildAccount(int $id, array $data);


    /**
     * @param int $id
     * @return mixed
     */
    public function deActiveAccount(int $id);

    /**
     * @param int $limit
     * @return mixed
     */
    public function getListPendingApproval(int $limit = 15);

    /**
     * @param int $limit
     * @return mixed
     */
    public function getListMemberNeededApproved(int $limit = 15);

    /**
     * @param string $search
     * @param int $limit
     * @return mixed
     */
    public function sortListMemberNeededApproved(string $search, int $limit = 15);

    /**
     * @param int $userId
     * @return mixed
     */
    public function confirmUser(int $userId);

    /**
     * @param string $search
     * @param int $limit
     * @return mixed
     */
    public function sortConfirmationUser(string $search, int $limit);

    /**
     * @param string $search
     * @param int $limit
     * @return mixed
     */
    public function sortAllUser(string $search, int $limit);

    /**
     * @param int $id
     * @return mixed
     */
    public function getMemberReferralByMemberId(int $id);
}