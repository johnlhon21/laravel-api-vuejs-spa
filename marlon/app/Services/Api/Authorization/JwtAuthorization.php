<?php

namespace App\Services\Api\Authorization;


use App\Services\Api\Exceptions\InvalidHeaderContentException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class JwtAuthorization
 * @package App\Services\Api\Authorization
 */
class JwtAuthorization extends AbstractAuthorization
{
    /**
     * Default ALG
     */
    const ALG = ['HS256'];

    /**
     * JwtAuthorization constructor.
     * @param Request $request
     * @throws InvalidHeaderContentException
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Checks the authorization
     * @return bool
     */
    public function authorize(): bool
    {
        $this->apiKey = $this->decode();
        return $this->authClientRepository->getByApiKey($this->apiKey) != null;
    }

    /**
     * Decodes the Authorization : Bearer {token}
     * @return string|null
     */
    private function decode()
    {
        try {
            $decoded = (array)JWT::decode($this->token, $this->secretKey, self::ALG);
            return $decoded['sub'];
        } catch (\Exception $exception) {
           Log::error($exception->getTraceAsString());
           return null;
        }
    }
}
