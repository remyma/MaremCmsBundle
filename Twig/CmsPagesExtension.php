<?php

namespace Marem\Bundle\CmsClientBundle\Twig;

use Marem\Bundle\CmsClientBundle\Service\ContentService;

/**
 * @author marem
 */
class CmsPagesExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var $contentService ContentService
     */
    private $contentService;

    /**
     * SuluPagesExtension constructor.
     * @param ContentService $contentService
     * @param string $locale
     */
    public function __construct(ContentService $contentService, $locale)
    {
        $this->contentService = $contentService;
        $this->defaultLocale = $locale;
    }


    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'cms_navigation' => new \Twig_Function_Method($this, 'getNavigation'),
            'cms_content' => new \Twig_Function_Method($this, 'getContent'),
        );
    }

    /**
     * @return string
     */
    public function getContent($contentKey)
    {
        $contents = $this->contentService->getContentByKey($contentKey);
        return $contents;
    }

    /**
     * @return string
     */
    public function getNavigation($naviationKey, $parent = null, $level = 0, $depth = 1, $locale = 'en')
    {
        $locale = $locale ?: $this->defaultLocale;
        $contents = $this->contentService->getNavigation($naviationKey, $parent, $level, $depth, $locale);
        return $contents;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'marem_cms_pages';
    }
}