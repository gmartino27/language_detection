<?php

declare(strict_types=1);

namespace Lochmueller\LanguageDetection\Event;

use Lochmueller\LanguageDetection\Domain\Collection\LocaleCollection;
use Lochmueller\LanguageDetection\Domain\Model\Dto\LocaleValueObject;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;

final class DetectUserLanguagesEvent extends AbstractEvent
{
    private LocaleCollection $userLanguages;

    public function __construct(
        protected SiteInterface $site,
        protected ServerRequestInterface $request
    ) {
        $this->userLanguages = new LocaleCollection();
    }

    public function getSite(): SiteInterface
    {
        return $this->site;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function getUserLanguages(): LocaleCollection
    {
        return $this->userLanguages;
    }

    public function setUserLanguages(LocaleCollection $userLanguages): void
    {
        $this->userLanguages = $userLanguages;
    }

    public function addUserLanguage(LocaleValueObject $userLanguage): void
    {
        $this->userLanguages->add($userLanguage);
    }
}
