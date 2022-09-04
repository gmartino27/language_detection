<?php

declare(strict_types=1);

namespace Lochmueller\LanguageDetection\Tests\Unit\Domain\Model\Dto;

use Lochmueller\LanguageDetection\Domain\Model\Dto\SiteConfiguration;
use Lochmueller\LanguageDetection\Tests\Unit\AbstractUnitTest;

/**
 * @internal
 *
 * @coversNothing
 */
class SiteConfigurationTest extends AbstractUnitTest
{
    /**
     * @covers \Lochmueller\LanguageDetection\Domain\Model\Dto\SiteConfiguration
     */
    public function testGetterOfDto(): void
    {
        $dto = new SiteConfiguration(
            true,
            false,
            'value',
            false,
            102,
            'none',
            5,
            'path.mmdb',
            42,
            'abcd',
        );

        self::assertTrue($dto->isEnableLanguageDetection());
        self::assertFalse($dto->isDisableRedirectWithBackendSession());
        self::assertEquals('value', $dto->getAddIpLocationToBrowserLanguage());
        self::assertFalse($dto->isAllowAllPaths());
        self::assertEquals(102, $dto->getRedirectHttpStatusCode());
        self::assertEquals('none', $dto->getForwardRedirectParameters());
        self::assertEquals(5, $dto->getFallbackDetectionLanguage());
        self::assertEquals('path.mmdb', $dto->getMaxMindDatabasePath());
        self::assertEquals(42, $dto->getMaxMindAccountId());
        self::assertEquals('abcd', $dto->getMaxMindLicenseKey());
    }
}
