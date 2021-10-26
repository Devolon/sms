<?php

namespace Devolon\Sms\Tests\Unit\Services;

use InvalidArgumentException;
use Mockery;
use Mockery\MockInterface;
use Devolon\Sms\Tests\SmsTestCase;
use Devolon\Sms\Services\ResolveSMSSenderService;
use Devolon\Sms\Services\Contracts\SMSSenderServiceInterface;

class ResolveSMSSenderServiceTest extends SmsTestCase
{
    /**
     * @dataProvider provideData
     */
    public function testItCanResolveDefaultSMSSender(
        string $defaultSender,
        array $senders,
        ?string $requestedSender,
        $expectedSender
    ) {
        // Arrange
        config([
            'sms' => [
                'default' => $defaultSender,
            ],
        ]);
        $service = new ResolveSMSSenderService($senders);

        // Act
        $result = $service($requestedSender);

        // Assert
        $this->assertInstanceOf(SMSSenderServiceInterface::class, $result);
        $this->assertSame($expectedSender, $result);
    }

    public function testItThrowsInvalidArgumentExceptionWithWrongSenderName(): void
    {
        // Arrange
        $service = new ResolveSMSSenderService([]);

        // Expect
        $this->expectException(InvalidArgumentException::class);

        // Act
        $service('wrong_name');
    }

    public function testItThrowsInvalidArgumentExceptionWithoutDefaultSenderWhenItRequestForDefaultSender(): void
    {
        // Arrange
        $service = new ResolveSMSSenderService([]);

        // Expect
        $this->expectException(InvalidArgumentException::class);

        // Act
        $service();
    }

    public function provideData(): array
    {
        $smsSenderOne = $this->mockSMSSenderService();
        $smsSenderTwo = $this->mockSMSSenderService();
        $defaultSmsSender = $this->mockSMSSenderService();

        $senders = [
            'sms_sender_one' => $smsSenderOne,
            'sms_sender_two' => $smsSenderTwo,
            'sms_sender_three' => $defaultSmsSender,
        ];

        return [
            'Resolve first sender' => [
                'default_sms_sender', // $defaultSender
                $senders, // $senders,
                'sms_sender_one', // $requestedSender
                $smsSenderOne // $expectedSender
            ],
            'Resolve second sender' => [
                'default_sms_sender', // $defaultSender
                $senders, // $senders,
                'sms_sender_two', // $requestedSender
                $smsSenderTwo // $expectedSender
            ],
            'Resolve default sender' => [
                'sms_sender_three', // $defaultSender
                $senders, // $senders,
                null, // $requestedSender
                $defaultSmsSender // $expectedSender
            ],
            'Resolve another default sender' => [
                'sms_sender_two', // $defaultSender
                $senders, // $senders,
                null, // $requestedSender
                $smsSenderTwo // $expectedSender
            ],
        ];
    }

    private function mockSMSSenderService(): MockInterface | SMSSenderServiceInterface
    {
        return Mockery::mock(SMSSenderServiceInterface::class);
    }
}
