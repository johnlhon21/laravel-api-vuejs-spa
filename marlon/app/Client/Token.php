<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 7:39 AM
 */

namespace App\Client;


use App\Repositories\Contracts\AuthClientRepositoryContract;
use Carbon\Carbon;

class Token
{
    /**
     * @var
     */
    protected $apiKey;

    /**
     * Secret Key
     */
    const SECRET_KEY = '1Jf8l1Zj5v9Swq6NOSLX5BOVshR773zH';

    /**
     * Hashing Algo
     */
    const HASH_ALGO = 'sha256';

    /**
     * Supported JWT Hashing Algo
     */
    const ALG = 'HS256';

    /**
     * JWT
     */
    const TYP = 'JWT';

    /**
     * @var array
     */
    protected $payload = [];

    /**
     * @var array
     */
    protected $jwtHeader = [
        'alg' => self::ALG,
        'typ' => self::TYP
    ];

    /**
     * @var string
     */
    protected $base64UrlEncodedHeader;

    /**
     * @var string
     */
    protected $base64UrlEncodedPayload;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $token;


    protected $authClient;


    public function __construct(AuthClientRepositoryContract $authClientRepositoryContract)
    {
        $this->authClient = $authClientRepositoryContract;
    }

    /**
     * @return mixed
     */
    public static function getSecretKey()
    {
        return env('JWT_TOKEN', self::SECRET_KEY);
    }

    /**
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string JWT token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return Carbon
     */
    public function expires()
    {
        return Carbon::now();
    }

    /**
     * Generates the JWT Token for XPOST Authorization
     * @return $this
     */
    public function generate()
    {
        $this->generateBase64EncodedHeader()
            ->generateBase64EncodedPayload()
            ->generateSignature();

        $this->token = sprintf('%s.%s.%s', $this->base64UrlEncodedHeader, $this->base64UrlEncodedPayload, $this->signature);

        return $this;
    }

    /**
     * Update Token
     * @param $userId
     * @param $data
     */
    public function save($userId, $data)
    {
        return $this->refreshToken($userId, $data);
    }

    /**
     * Refreshes Token
     * @param $userId
     * @param $data
     */
    public function refreshToken($userId, $data)
    {
        return $this->authClient->refreshToken($userId, $data);
    }

    /**
     * Generates the url safe header
     * @return $this
     */
    protected function generateBase64EncodedHeader()
    {
        $this->base64UrlEncodedHeader = $this->base64urlEncode(json_encode($this->jwtHeader));

        return $this;
    }

    /**
     * Generates the url safe payload
     * @return $this
     */
    protected function generateBase64EncodedPayload()
    {
        $this->addRequiredPayload();
        $this->base64UrlEncodedPayload = $this->base64urlEncode(json_encode($this->payload));

        return $this;
    }

    /**
     * Generates the url safe signature
     * @return $this
     */
    protected function generateSignature()
    {
        $string = sprintf('%s.%s', $this->base64UrlEncodedHeader, $this->base64UrlEncodedPayload);
        $this->signature = $this->base64urlEncode($this->hash($string));

        return $this;
    }

    /**
     * Adds additional required payload
     */
    protected function addRequiredPayload()
    {
        $this->payload = array_add($this->payload, 'iat', Carbon::now()->timestamp);
        $this->payload = array_add($this->payload, 'jti', Carbon::now()->timestamp);
        $this->payload = array_add($this->payload, 'sub', $this->apiKey);
    }

    /**
     * Hashes the concatenated signature and payload with the secret key
     * @param $string
     * @return string
     */
    private function hash($string)
    {
        return hash_hmac(self::HASH_ALGO, $string, self::getSecretKey(), true);
    }

    /**
     * Create url safe base64 encoding
     * @param $string
     * @return string
     */
    private function base64urlEncode($string) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
    }
}
