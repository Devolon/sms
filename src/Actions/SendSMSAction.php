<?php

namespace Devolon\Sms\Actions;

use Devolon\Sms\DTOs\SendSMSMessageDTO;
use Devolon\Sms\Services\SaveSMSMessageService;
use Devolon\Sms\Services\SendSMSService;

class SendSMSAction
{
    public function __construct(
        private SendSMSService $sendSMSService,
        private SaveSMSMessageService $saveSMSMessageService
    ) {
    }

    public function __invoke(SendSMSMessageDTO $sendSMSMessageDTO)
    {
        $sentSMSMessageDTO = ($this->sendSMSService)($sendSMSMessageDTO);

        ($this->saveSMSMessageService)($sentSMSMessageDTO);
    }
}
