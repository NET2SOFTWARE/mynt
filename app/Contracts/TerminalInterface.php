<?php
namespace App\Contracts;


/**
 * Interface TerminalInterface
 * @package App\Contracts
 */
interface TerminalInterface extends AppInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes);
}