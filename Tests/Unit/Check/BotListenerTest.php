<?php

declare(strict_types=1);

namespace Lochmueller\LanguageDetection\Tests\Unit\Check;

use Lochmueller\LanguageDetection\Check\BotListener;
use Lochmueller\LanguageDetection\Event\CheckLanguageDetection;
use Lochmueller\LanguageDetection\Tests\Unit\AbstractTest;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;

/**
 * @internal
 * @coversNothing
 */
class BotListenerTest extends AbstractTest
{
    /**
     * @covers \Lochmueller\LanguageDetection\Check\BotListener
     * @covers \Lochmueller\LanguageDetection\Event\CheckLanguageDetection
     * @dataProvider data
     */
    public function testUserAgents(string $userAgent, bool $result): void
    {
        $site = $this->createMock(SiteInterface::class);

        $request = new ServerRequest(null, null, 'php://input', ['user-agent' => $userAgent]);
        $event = new CheckLanguageDetection($site, $request);

        $botListener = new BotListener();
        $botListener($event);

        self::assertEquals($result, $event->isLanguageDetectionEnable());
    }

    /**
     * @covers \Lochmueller\LanguageDetection\Check\BotListener
     * @covers \Lochmueller\LanguageDetection\Event\CheckLanguageDetection
     */
    public function testWithoutUserAgent(): void
    {
        $site = $this->createMock(SiteInterface::class);

        $request = new ServerRequest();
        $event = new CheckLanguageDetection($site, $request);

        $botListener = new BotListener();
        $botListener($event);

        self::assertTrue($event->isLanguageDetectionEnable());
    }

    /**
     * @return array<int, array<string|bool>>
     */
    public function data(): array
    {
        return [
            ['AdsBot-Google', false],
            ['Firefox', true],
            ['Chrome', true],
            ['Yandex-12378', false],
        ];
    }
}
