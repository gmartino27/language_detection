<?php

declare(strict_types=1);

namespace Lochmueller\LanguageDetection\Tests\Unit\Check;

use Lochmueller\LanguageDetection\Check\FromCurrentPageCheck;
use Lochmueller\LanguageDetection\Event\CheckLanguageDetectionEvent;
use Lochmueller\LanguageDetection\Tests\Unit\AbstractUnitTest;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class FromCurrentPageCheckTest extends AbstractUnitTest
{
    /**
     * @covers       \Lochmueller\LanguageDetection\Check\FromCurrentPageCheck
     * @covers       \Lochmueller\LanguageDetection\Event\CheckLanguageDetectionEvent
     *
     * @dataProvider data
     */
    public function testInvalidReferrer(string $referrer, string $baseUri, bool $isStillEnabled): void
    {
        $site = $this->createStub(SiteInterface::class);
        $site->method('getBase')->willReturn(new Uri($baseUri));

        $request = new ServerRequest(null, null, 'php://input', [], ['HTTP_REFERER' => $referrer]);
        $event = new CheckLanguageDetectionEvent($site, $request);

        $fromCurrentPageCheck = new FromCurrentPageCheck();
        $fromCurrentPageCheck($event);

        self::assertEquals($isStillEnabled, $event->isLanguageDetectionEnable());
    }

    /**
     * @return array<string, array<int, bool|string>>
     */
    public function data(): array
    {
        return [
            'Internal referrer as deeplink' => ['https://www.website.de/deeplink', 'https://www.website.de', false],
            'Without referrer' => ['', 'https://www.website.de', true],
            'External referrer as deeplink' => ['https://www.google.de/other-side', 'https://www.website.de', true],
            'Referrer as homepage' => ['https://www.website.de', 'https://www.website.de', false],
        ];
    }
}
