<?php

namespace App\Contracts;


interface RemittanceInterface
{
    public function create(array $data);
    public function delete(array $data);
    public function inquiry(array $data);
    public function inquiryStatus(array $data);
    public function transfer(array $data);
}