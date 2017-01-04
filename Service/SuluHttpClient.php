<?php

namespace Marem\Bundle\CmsClientBundle\Service;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
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
        $client = new Client([
            'base_uri' => $this->suluUrl,
            'headers' => ['Accept' => 'application/json'],
        ]);

        if ($parameters != null && !array_key_exists(self::PARAM_WEBSPACE, $parameters)) {
            $parameters[self::PARAM_WEBSPACE] = $this->defaultWebspace;
        }

        $json = [];
        try {
            /* @var ResponseInterface $response */
            $response = $client->request('GET', $endpoint, [
                'query' => $parameters
            ]);

            $json = json_decode($response->getBody(), true);
        } catch(\Exception $e) {
            // TODO : log and manage exception.
        }

        return $json;
    }
}