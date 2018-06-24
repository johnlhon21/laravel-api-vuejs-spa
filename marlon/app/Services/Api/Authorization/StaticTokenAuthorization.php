<?php

namespace App\Services\Api\Authorization;


use App\Webhooks\XPost\Helper\DB\Keys\Keys;
use Illuminate\Http\Request;

/**
 * Class StaticTokenAutorization
 * @package App\Services\Api\Authorization
 */
class StaticTokenAuthorization extends AbstractAuthorization
{

    /**
     * StaticTokenAuthorization constructor.
     * @param Request $request
     * @throws \App\Services\Api\Exceptions\InvalidHeaderContentException
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Checks the authorization
     * @return bool
     */
    public function authorize()
    {
        return parent::authorize();
    }

}
