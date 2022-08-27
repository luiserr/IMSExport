<?php

namespace IMSExport\Application\IMS\Services\Identifier;

class IMSIdentifierRef extends IMSIdentifierBase
{

    protected int $assessmentId = 0;
    protected int $webContentId = 0;
    protected int $discussionId = 0;


    public function getIdentifier(string $type): string
    {
        switch ($type) {
            case 'assets':
                return $this->createIdentifier('assessment', $this->assessmentId);
            case 'discussion':
                return $this->createIdentifier('discussion_topic', $this->discussionId);
            case 'web_content':
                return $this->createIdentifier('web_content', $this->webContentId);
            case 'lti':
                return $this->createIdentifier('lti', $this->webContentId);
        }
    }

}