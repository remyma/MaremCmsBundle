<?php

namespace Marem\Bundle\CmsClientBundle\Model;

class Query
{

    /**
     * @var $webspace
     */
    private $webspace;

    /**
     * @return string
     */
    public function getWebspace()
    {
        return $this->webspace;
    }

    /**
     * @param string $webspace
     */
    public function setWebspace($webspace)
    {
        $this->webspace = $webspace;
    }



}