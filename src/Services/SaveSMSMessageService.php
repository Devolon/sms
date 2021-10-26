<?php

namespace Devolon\Sms\Services;

use Devolon\Sms\Models\SmsMessage;
use Devolon\Sms\DTOs\SentSMSMessageDTO;
use Devolon\Sms\Repositories\SmsMessageRepository;

class SaveSMSMessageService
{
    public function __construct(private SmsMessageRepository $SMSMessageRepository)
    {
    }

    public function __invoke(SentSMSMessageDTO $sendSMSMessageDTO): SmsMessage
    {
        return $this->SMSMessageRepository->create($sendSMSMessageDTO->toArray());
    }
}
