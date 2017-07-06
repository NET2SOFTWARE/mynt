<?php

namespace App\Contracts;


/**
 * Interface UserInterface
 * @package App\Contracts
 */
interface UserInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);

    public function attemptUniqueCredential($email, $password);

    public function save(array $data);

    public function get(int $id);

    public function gets();

    public function countUserByEmail(string $email);

    public function isUserExistsByReferral(string $email, string $referral);

    public function isCompany(string $email);

    public function isMerchant(string $email);

    public function checkUsernameExists(string $username);

    public function checkEmailExists(string $email);

    public function checkPhoneExists(string $phone);

    public function checkingIsLinePhoneNumber(string $phone);

    public function serializePhone(string $phone);
}