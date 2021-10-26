<?php

namespace Devolon\Sms\Tests\Unit\DTO\SendSMSMessageDTO;

use Devolon\Sms\DTOs\SMSMessageDTO;
use Illuminate\Foundation\Testing\WithFaker;
use Devolon\Sms\Tests\SmsTestCase;
use Devolon\Sms\DTOs\SendSMSMessageDTO;

class ConstructorTest extends SmsTestCase
{
    use WithFaker;

    public function testItHasExpectedProperties()
    {
        // Arrange
        $data = [
            'sender_service' => $this->faker->name,
            'message' => SMSMessageDTO::fromArray([
                'to' => $this->faker->e164PhoneNumber,
                'text' => $this->faker->text,
                'from' => $this->faker->name,
            ])
        ];

        // Act
        $result = SendSMSMessageDTO::fromArray($data);

        // Assert
        $this->assertInstanceOf(SendSMSMessageDTO::class, $result);
        $this->assertEquals($data['sender_service'], $result->sender_service);
        $this->assertEquals($data['message'], $result->message);
    }

    public function testItHasOptionalValues()
    {
        // Arrange
        $data = [
            'message' => SMSMessageDTO::fromArray([
                'to' => $this->faker->e164PhoneNumber,
                'text' => $this->faker->text,
            ]),
        ];

        // Act
        $result = SendSMSMessageDTO::fromArray($data);

        // Assert
        $this->assertInstanceOf(SendSMSMessageDTO::class, $result);
        $this->assertNull($result->sender_service);
        $this->assertEquals($data['message'], $result->message);
    }
}
