<?php

namespace Marem\Bundle\CmsClientBundle\Service;

use Marem\Bundle\CmsClientBundle\Model\AbstractContent;
use Marem\Bundle\CmsClientBundle\Model\Content;
use Marem\Bundle\CmsClientBundle\Model\ContentList;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Content service.
 * @author marem
 */
class ContentService
{
    /**
     * @var SuluHttpClient sulu http client.
     */
    private $suluHttpClient;

    private $marketingContents;

    private $navs;

    public function __construct(SuluHttpClient $suluHttpClient, array $marketingContents, array $navs)
    {
        $this->suluHttpClient = $suluHttpClient;
        $this->marketingContents = $marketingContents;
        $this->navs = $navs;
    }

    /**
     * Get navigation.
     * @param string $navigationKey
     * @param string $parent
     * @param int $level
     * @param int $depth
     * @param string $language
     * @return array
     * @throws \Exception
     */
    public function getNavigation($navigationKey, $parent = null, $level = 0, $depth = 1, $language = 'en')
    {
        // search for markegingcontent by key
        if (empty($this->navs[$navigationKey])) {
            throw new \Exception("Unknown nav " . $navigationKey);
        }

        $nav = $this->navs[$navigationKey];

        $parameters = [];
        if ($parent) {
            $parameters['uuid'] = $parent;
        }
        $parameters['level'] = $level;
        $parameters['depth'] = $depth;
        $parameters['context'] = $nav['context'];
        $parameters['language'] = $language;

        $json = $this->suluHttpClient->getJson('/api/navigation', $parameters);

        $contents = [];
        foreach ($json as $jsonContentItem) {
            $content = new Content();
            $content->setTitle($jsonContentItem['title']);
            $content->setId($jsonContentItem['uuid']);
            $content->setUrl(substr($jsonContentItem['url'], 1));
            $contents[] = $content;
        }


        return $contents;
    }

    /**
     * Get content by key.
     * @param string $key : content key
     * @return array
     * @throws \Exception
     */
    public function getContentByKey($key)
    {
        if (empty($this->marketingContents[$key])) {
            throw new \Exception("Unknown content with key " . $key);
        }
        $marketingContent = $this->marketingContents[$key];

        // TODO : throw exception if no content found.
        $json = $this->suluHttpClient->getJson($marketingContent['url']);
        $content = new Content();
        $content->setBody($json);

        return $content;
    }

    /**
     * Get content by url.
     * @param string $url : content url
     * @return AbstractContent
     * @throws \Exception
     */
    public function getContentByUrl($url)
    {
        $json = $this->suluHttpClient->getJson($url);

        // TODO : Introduce some factory to init different json to object converters.

        if (array_key_exists('template', $json) && $json['template'] === "liste") {
            $content = new ContentList();
        } else {
            $content = new Content();
            $content->setBody($json['article']);
        }

        if (array_key_exists('template', $json)) {
            $content->setTemplate($json['template']);
        }
        if (array_key_exists('title', $json)) {
            $content->setTitle($json['title']);
        }


        return $content;
    }
}