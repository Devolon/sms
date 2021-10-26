<?php

namespace Devolon\Sms\Tests\Unit\DTO\SMSMessageDTO;

use Illuminate\Foundation\Testing\WithFaker;
use Devolon\Sms\Tests\SmsTestCase;
use Devolon\Sms\DTOs\SMSMessageDTO;

class ConstructorTest extends SmsTestCase
{
    use WithFaker;

    public function testItHasSupposedAttributes()
    {
        // Arrange
        $data = [
            'to' => $this->faker->e164PhoneNumber,
            'text' => $this->faker->text,
            'from' => $this->faker->name,
        ];

        // Act
        $result = SMSMessageDTO::fromArray($data);

        // Assert
        $this->assertInstanceOf(SMSMessageDTO::class, $result);
        $this->assertEquals($data['to'], $result->to);
        $this->assertEquals($data['text'], $result->text);
        $this->assertEquals($data['from'], $result->from);
    }

    public function testItHasOptionalFields()
    {
        // Arrange
        $data = [
            'to' => $this->faker->e164PhoneNumber,
            'text' => $this->faker->text,
        ];

        // Act
        $result = SMSMessageDTO::fromArray($data);

        // Assert
        $this->assertInstanceOf(SMSMessageDTO::class, $result);
        $this->assertEquals($data['to'], $result->to);
        $this->assertEquals($data['text'], $result->text);
        $this->assertNull($result->from);
    }
}
