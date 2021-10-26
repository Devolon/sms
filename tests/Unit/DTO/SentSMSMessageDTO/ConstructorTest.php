<?php

namespace Devolon\Sms\Tests\Unit\DTO\SentSMSMessageDTO;

use Illuminate\Foundation\Testing\WithFaker;
use Devolon\Sms\Tests\SmsTestCase;
use Devolon\Sms\DTOs\SentSMSMessageDTO;

class ConstructorTest extends SmsTestCase
{
    use WithFaker;

    public function testItHasExpectedProperties()
    {
        // Arrange
        $data = [
            'to' => $this->faker->e164PhoneNumber,
            'text' => $this->faker->text,
            'from' => $this->faker->name,
            'tracking_code' => $this->faker->uuid,
            'sender_service' => $this->faker->name,
        ];

        // Act
        $result = SentSMSMessageDTO::fromArray($data);

        // Assert
        $this->assertInstanceOf(SentSMSMessageDTO::class, $result);
        $this->assertEquals($data['tracking_code'], $result->tracking_code);
        $this->assertEquals($data['to'], $result->to);
        $this->assertEquals($data['text'], $result->text);
        $this->assertEquals($data['from'], $result->from);
        $this->assertEquals($data['sender_service'], $result->sender_service);
    }
}
