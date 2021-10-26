<?php

namespace Devolon\Sms\Services;

use Devolon\Sms\DTOs\SendSMSMessageDTO;
use Devolon\Sms\DTOs\SentSMSMessageDTO;

class SendSMSService
{
    public function __construct(private ResolveSMSSenderService $resolveSMSSenderService)
    {
    }

    public function __invoke(SendSMSMessageDTO $sendSMSMessageDTO): SentSMSMessageDTO
    {
        $smsSenderService = ($this->resolveSMSSenderService)($sendSMSMessageDTO->sender_service);

        $sentSMSMessageDTO = $smsSenderService($sendSMSMessageDTO->message);
        $sentSMSMessageDTO->sender_service = $smsSenderService->getName();

        return $sentSMSMessageDTO;
    }
}
