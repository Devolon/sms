<?php

namespace Devolon\Sms\Tests\Unit\Jobs;

use Devolon\Sms\DTOs\SendSMSMessageDTO;
use Devolon\Sms\DTOs\SMSMessageDTO;
use Devolon\Sms\Jobs\SendSMSJob;
use Devolon\Sms\Actions\SendSMSAction;
use Hamcrest\Core\IsEqual;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Devolon\Sms\Tests\SmsTestCase;

class SendSMSJobTest extends SmsTestCase
{
    use WithFaker;

    public function testItCallsSendSMSAction()
    {
        // Arrange
        $sendSMSMessageDTO = SendSMSMessageDTO::fromArray([
            'sender_service' => $this->faker->name,
            'from' => $this->faker->name,
            'message' => SMSMessageDTO::fromArray([
                'to' => $this->faker->e164PhoneNumber,
                'text' => $this->faker->text,
            ])
        ]);

        $sendSMSAction = $this->mockSendSMSAction();

        // Expect
        $sendSMSAction
            ->shouldReceive('__invoke')
            ->with(IsEqual::equalTo($sendSMSMessageDTO))
            ->once();

        // Act
        SendSMSJob::dispatchSync($sendSMSMessageDTO);
    }

    private function mockSendSMSAction(): SendSMSAction | MockInterface
    {
        return $this->mock(SendSMSAction::class);
    }
}
