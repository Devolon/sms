<?php

namespace Devolon\Sms\Services;

use Devolon\Sms\Jobs\SendSMSJob;
use Devolon\Sms\DTOs\SendSMSMessageDTO;

class ScheduleSMSService
{
    public function __invoke(SendSMSMessageDTO $sendSMSMessageDTO): void
    {
        SendSMSJob::dispatch($sendSMSMessageDTO);
    }
}
