<?php

namespace Marem\Bundle\CmsClientBundle\Model;

/**
 * Default Content. All content in the body.
 * @author: marem
 */
class Content extends AbstractContent
{
    private $body;

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed string
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}