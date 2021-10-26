<?php

namespace Devolon\Sms\Tests\Integration;

use Devolon\Sms\DTOs\SentSMSMessageDTO;
use Devolon\Sms\DTOs\SMSMessageDTO;
use Devolon\Sms\Services\Contracts\SMSSenderServiceInterface;
use Devolon\Sms\Services\ResolveSMSSenderService;
use Devolon\Sms\Tests\SmsTestCase;

class SmsServiceProviderTest extends SmsTestCase
{
    public function testItSendsAnyTaggedSMSServiceToSMSSenderResolver()
    {
        // Arrange
        $fakeSMSSender = $this->resolveAndTagFakeSMSSender();
        $smsSenderResolver = $this->resolveSMSSenderResolver();

        // Act
        $result = $smsSenderResolver($fakeSMSSender::getName());

        // Assert
        $this->assertEquals($fakeSMSSender, $result);
    }

    private function resolveSMSSenderResolver(): ResolveSMSSenderService
    {
        return resolve(ResolveSMSSenderService::class);
    }

    private function resolveAndTagFakeSMSSender(): SMSSenderServiceInterface
    {
        $class = get_class(new class () implements SMSSenderServiceInterface {
            private static string $name = '';
            public function __invoke(SMSMessageDTO $smsMessageDTO): SentSMSMessageDTO
            {
                return SentSMSMessageDTO::fromArray([]);
            }

            public static function getName(): string
            {
                if (self::$name === '') {
                    self::$name = uniqid();
                }

                return self::$name;
            }
        });
        $this->app->singleton($class);
        $this->app->tag($class, SMSSenderServiceInterface::class);

        return resolve($class);
    }
}
