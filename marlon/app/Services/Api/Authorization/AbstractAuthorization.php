<?php

namespace App\Services\Api\Authorization;


use App\Client\Token;
use App\Models\AuthClient;
use App\Repositories\AuthClientRepository;
use App\Services\Api\Exceptions\InvalidHeaderContentException;
use Illuminate\Http\Request;

/**
 * Class AbstractAuthorization
 * @package App\Webhooks\XPost\Authorization
 */
abstract class AbstractAuthorization
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\HttpFoundation\HeaderBag
     */
    protected $headers;

    /**
     * Token
     * @var null
     */
    protected $token = null;

    /**
     * @var null|string|string[]
     */
    protected $authorizationHeader = null;

    protected $authClientRepository;

    protected $secretKey = null;

    protected $apiKey = null;

    /**
     * AbstractAuthorization constructor.
     * @param Request $request
     * @throws InvalidHeaderContentException
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->headers = $request->headers;
        $this->secretKey = Token::getSecretKey();
        $this->authClientRepository = new AuthClientRepository(new AuthClient());

        if (! $this->isJsonRequest()) {
            throw new InvalidHeaderContentException();
        }

        $this->authorizationHeader = $this->headers->get('authorization');
        $this->parseToken();
    }

    /**
     * Default to false
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Detects if the content-type is json
     * @return bool
     */
    protected function isJsonRequest()
    {
        $contentType = $this->headers->get('content-type');

        return ($contentType !== null && $contentType == 'application/json');
    }

    /**
     * Gets the token from Authorization header
     * @return null
     */
    protected function parseToken()
    {
        if ($this->authorizationHeader !== null) {
            list($title, $this->token) = sscanf($this->authorizationHeader, "%s %s");
        }

        return null;
    }

}
