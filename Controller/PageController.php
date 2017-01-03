<?php

namespace Marem\Bundle\CmsClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function displayPageAction($url)
    {
        $contentService = $this->get('marem_cms_client.service.contentservice');

        $content = $contentService->getContentByUrl($url);

        $template = 'MaremCmsClientBundle:Page:page.html.twig';
        if ($content->getTemplate()) {
            $template = 'MaremCmsClientBundle:Page:' . $content->getTemplate() . '.html.twig';
        }

        return $this->render($template, array('content' => $content));
    }
}
