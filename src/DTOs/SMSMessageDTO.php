<?php

namespace Devolon\Sms\DTOs;

use Devolon\Common\Bases\DTO;

class SMSMessageDTO extends DTO
{
    public function __construct(
        public string $to,
        public string $text,
        public ?string $from,
    ) {
    }
}
