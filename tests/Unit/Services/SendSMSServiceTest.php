<?php

namespace Devolon\Sms\Tests\Unit\Services;

use Devolon\Sms\DTOs\SendSMSMessageDTO;
use Devolon\Sms\DTOs\SentSMSMessageDTO;
use Devolon\Sms\DTOs\SMSMessageDTO;
use Devolon\Sms\Services\Contracts\SMSSenderServiceInterface;
use Devolon\Sms\Services\ResolveSMSSenderService;
use Devolon\Sms\Services\SendSMSService;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Devolon\Sms\Tests\SmsTestCase;

class SendSMSServiceTest extends SmsTestCase
{
    use WithFaker;

    /**
     * @dataProvider withSender
     */
    public function testSendSMSWithGivenSender(?string $sender)
    {
        // Arrange
        $sendSMSMessageDTO = SendSMSMessageDTO::fromArray([
            'message' => SMSMessageDTO::fromArray([
                'to' => $this->faker->e164PhoneNumber,
                'text' => $this->faker->text,
                'from' => $this->faker->name,
            ]),
            'sender_service' => $sender
        ]);

        $sentSMSMessageDTO = SentSMSMessageDTO::fromArray([
            'to' => $sendSMSMessageDTO->message->to,
            'text' => $sendSMSMessageDTO->message->text,
            'from' => $sendSMSMessageDTO->message->from,
            'tracking_code' => $this->faker->uuid,
        ]);

        $sentSMSMessageDTOWithSender = SentSMSMessageDTO::fromArray(array_merge($sentSMSMessageDTO->toArray(), [
            'sender_service' => $sendSMSMessageDTO->sender_service ?? 'default_sender',
        ]));

        $resolveSMSSenderService = $this->mockResolveSMSSenderService();
        $smsSenderService = $this->mockSMSSenderService();
        $service = $this->resolveService();

        // Expect
        $resolveSMSSenderService
            ->shouldReceive('__invoke')
            ->with($sender)
            ->once()
            ->andReturn($smsSenderService);

        $smsSenderService
            ->shouldReceive('__invoke')
            ->with($sendSMSMessageDTO->message)
            ->once()
            ->andReturn($sentSMSMessageDTO)
        ;

        $smsSenderService
            ->shouldReceive('getName')
            ->once()
            ->andReturn($sendSMSMessageDTO->sender_service ?? 'default_sender')
        ;

        // Act
        $result = $service($sendSMSMessageDTO);

        // Assert
        $this->assertInstanceOf(SentSMSMessageDTO::class, $result);
        $this->assertEquals($sentSMSMessageDTOWithSender, $result);
    }

    public function withSender(): array
    {
        return [
            'With default sender' => [null],
            'With a specific sender' => ['sample_sender']
        ];
    }

    private function mockResolveSMSSenderService(): ResolveSMSSenderService | MockInterface
    {
        return $this->mock(ResolveSMSSenderService::class);
    }

    private function mockSMSSenderService(): SMSSenderServiceInterface | MockInterface
    {
        return Mockery::mock(SMSSenderServiceInterface::class);
    }

    private function resolveService(): SendSMSService
    {
        return resolve(SendSMSService::class);
    }
}
