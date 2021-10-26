<?php

namespace Devolon\Sms\DTOs;

use Devolon\Common\Bases\DTO;

class SendSMSMessageDTO extends DTO
{
    public function __construct(
        public SMSMessageDTO $message,
        public ?string $sender_service,
    ) {
    }
}
