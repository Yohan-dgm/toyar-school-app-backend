<?php

namespace App\Library\Response;

use Illuminate\Http\RedirectResponse as BaseRedirectResponse;

class RedirectResponse extends BaseRedirectResponse
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
