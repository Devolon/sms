<?php

namespace Devolon\Sms\DTOs;

use Devolon\Common\Bases\DTO;

class SentSMSMessageDTO extends DTO
{
    public function __construct(
        public string $to,
        public string $text,
        public string $tracking_code,
        public ?string $sender_service,
        public ?string $from,
    ) {
    }
}
