<?php

namespace Devolon\Sms\Tests\Unit\Actions;

use Devolon\Sms\Actions\SendSMSAction;
use Devolon\Sms\DTOs\SentSMSMessageDTO;
use Devolon\Sms\Services\SendSMSService;
use Devolon\Sms\Services\SaveSMSMessageService;
use Devolon\Sms\DTOs\SendSMSMessageDTO;
use Devolon\Sms\DTOs\SMSMessageDTO;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Devolon\Sms\Tests\SmsTestCase;

class SendSMSActionTest extends SmsTestCase
{
    use WithFaker;

    public function testInvoke()
    {
        // Arrange
        $sendSMSMessageDTO = SendSMSMessageDTO::fromArray([
            'sender_service' => $this->faker->name,
            'message' => SMSMessageDTO::fromArray([
                'to' => $this->faker->e164PhoneNumber,
                'text' => $this->faker->text,
                'from' => $this->faker->name,
            ]),
        ]);

        $sentSMSMessageDTO = SentSMSMessageDTO::fromArray([
            'to' => $sendSMSMessageDTO->message->to,
            'text' => $sendSMSMessageDTO->message->text,
            'from' => $sendSMSMessageDTO->message->from,
            'tracking_code' => $this->faker->uuid,
            'sender_service' => $sendSMSMessageDTO->sender_service,
        ]);

        $sendSMSService = $this->mockSendSMSService();
        $saveSMSMessageService = $this->mockSaveSMSMessageService();
        $action = $this->resolveAction();

        // Expect
        $sendSMSService
            ->shouldReceive('__invoke')
            ->with($sendSMSMessageDTO)
            ->once()
            ->andReturn($sentSMSMessageDTO)
        ;

        $saveSMSMessageService
            ->shouldReceive('__invoke')
            ->with($sentSMSMessageDTO)
            ->once();

        // Act
        $action($sendSMSMessageDTO);
    }

    private function mockSendSMSService(): MockInterface | SendSMSService
    {
        return $this->mock(SendSMSService::class);
    }

    private function mockSaveSMSMessageService(): MockInterface | SaveSMSMessageService
    {
        return $this->mock(SaveSMSMessageService::class);
    }

    private function resolveAction(): SendSMSAction
    {
        return resolve(SendSMSAction::class);
    }
}
