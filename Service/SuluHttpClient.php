<?php

namespace Marem\Bundle\CmsClientBundle\Service;

use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Client;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class SuluHttpClient
 * @package Marem\Bundle\SuluClientBundle\Service
 */
class SuluHttpClient
{
    /**
     * Param webspace.
     */
    const PARAM_WEBSPACE = 'webspace';

    /**
     * @var string sulu base url.
     */
    private $suluUrl;

    /**
     * @var string sulu default webspace.
     */
    private $defaultWebspace;

    /**
     * Init http client.
     * @param string $suluUrl sulu url
     * @param string $defaultWebspace sulu default webspace
     */
    public function __construct($suluUrl, $defaultWebspace)
    {
        $this->suluUrl = $suluUrl;
        $this->defaultWebspace = $defaultWebspace;
    }

    /**
     * Request sulu and return json.
     * @param string $endpoint
     * @param array $parameters
     * @return array
     */
    public function getJson($endpoint, array $parameters = null)
    {
        $client = new Client($this->suluUrl);
        $request = $client->get($endpoint);
        $request->setHeader('Accept', 'application/json');

        $query = $request->getQuery();

        if (count($parameters) > 0) {
            foreach ($parameters as $key => $value) {
                $query->set($key, $value);
            }
        }

        if ($query->get(self::PARAM_WEBSPACE) == null) {
            $query->set(self::PARAM_WEBSPACE, $this->defaultWebspace);
        }

        $json = [];
        try {
            $response = $request->send();
            $json = $response->json();
        } catch(\Exception $e) {
            // TODO : log and manage exception.
        }

        return $json;
    }
}