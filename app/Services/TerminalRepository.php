<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Terminal;
use App\Contracts\AbstractInterface;
use App\Contracts\TerminalInterface;

class TerminalRepository extends AbstractInterface implements TerminalInterface
{

    public function __construct(Terminal $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function attribute(array $attributes)
    {
        return [
            'code'  => $attributes['code'],
        ];
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $terminal = new Terminal;

        foreach ($data as $index => $value) { $terminal->$index = $value; }

        $terminal->created_at = Carbon::now();

        $terminal->save();

        return (!$terminal) ? false : terminal::find($terminal->id);
    }
}