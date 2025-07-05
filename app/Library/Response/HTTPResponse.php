<?php

namespace App\Library\Response;

use Illuminate\Http\Response;

class HTTPResponse extends Response
{

    public $bag;

    public function bag($Status = null, $Data = null)
    {
        $this->bag = (object) [
            'Status' => $Status,
            'Data' => $Data
        ];
        return $this;
    }
}
