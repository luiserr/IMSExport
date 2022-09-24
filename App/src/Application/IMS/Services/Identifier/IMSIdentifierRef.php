<?php

namespace IMSExport\Application\IMS\Services\Identifier;

use IMSExport\Application\Constants\Activities;

class IMSIdentifierRef extends IMSIdentifierBase
{

    protected $assessmentId = 0;
    protected $webContentId = 0;
    protected $discussionId = 0;


    public function getIdentifier($type)
    {
        switch ($type) {
            case Activities::exam:
            case Activities::probe:
                return $this->createIdentifier('assessment', $this->assessmentId);
            case Activities::post:
                return $this->createIdentifier('discussion_topic', $this->discussionId);
            case Activities::task:
            case Activities::blog:
            case Activities::resource:
            case Activities::wiki:
                return $this->createIdentifier('web_content', $this->webContentId);
        }
        return null;
    }

}