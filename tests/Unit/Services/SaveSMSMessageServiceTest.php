<?php

namespace Devolon\Sms\Tests\Unit\Services;

use Devolon\Sms\Models\SmsMessage;
use Devolon\Sms\DTOs\SentSMSMessageDTO;
use Devolon\Sms\Services\SaveSMSMessageService;
use Illuminate\Foundation\Testing\WithFaker;
use Devolon\Sms\Tests\SmsTestCase;

class SaveSMSMessageServiceTest extends SmsTestCase
{
    use WithFaker;

    public function testItSaveMessage()
    {
        // Arrange
        $sentSMSMessageDTO = SentSMSMessageDTO::fromArray([
            'to' => $this->faker->e164PhoneNumber,
            'text' => $this->faker->text,
            'from' => $this->faker->name,
            'sender_service' => $this->faker->name,
            'tracking_code' => $this->faker->uuid,
        ]);

        $service = $this->resolveService();

        // Act
        $result = $service($sentSMSMessageDTO);

        // Assert
        $this->assertInstanceOf(SmsMessage::class, $result);
        $this->assertDatabaseHas('sms_messages', [
            'id' => $result->id,
            'from' => $sentSMSMessageDTO->from,
            'to' => $sentSMSMessageDTO->to,
            'text' => $sentSMSMessageDTO->text,
            'sender_service' => $sentSMSMessageDTO->sender_service,
            'tracking_code' => $sentSMSMessageDTO->tracking_code,
        ]);
    }

    private function resolveService(): SaveSMSMessageService
    {
        return resolve(SaveSMSMessageService::class);
    }
}
