<?php

namespace Devolon\Sms\Tests\Unit\Services;

use Devolon\Sms\Jobs\SendSMSJob;
use Devolon\Sms\DTOs\SendSMSMessageDTO;
use Devolon\Sms\DTOs\SMSMessageDTO;
use Devolon\Sms\Services\ScheduleSMSService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use ReflectionClass;
use Devolon\Sms\Tests\SmsTestCase;

class ScheduleSMSServiceTest extends SmsTestCase
{
    use WithFaker;

    public function testItScheduleJobAsynchronously()
    {
        // Arrange
        $smsMessageDTO = SMSMessageDTO::fromArray([
            'text' => $this->faker->text,
            'to' => $this->faker->e164PhoneNumber,
            'from' => $this->faker->name,
        ]);

        $sendSMSMessageDTO = SendSMSMessageDTO::fromArray([
            'message' => $smsMessageDTO,
            'sender_service' => $this->faker->name,
        ]);

        Bus::fake();

        $service = $this->resolveService();

        // Act
        $service($sendSMSMessageDTO);

        // Assert
        Bus::assertDispatched(function (SendSMSJob $job) use ($sendSMSMessageDTO) {
            $reflection = new ReflectionClass(SendSMSJob::class);
            $propertyReflection = $reflection->getProperty('sendSMSMessageDTO');
            $propertyReflection->setAccessible(true);
            $actualSendSMSMessageDTO = $propertyReflection->getValue($job);

            return $actualSendSMSMessageDTO === $sendSMSMessageDTO;
        });
        Bus::assertDispatchedTimes(SendSMSJob::class);
    }

    private function resolveService(): ScheduleSMSService
    {
        return resolve(ScheduleSMSService::class);
    }
}
