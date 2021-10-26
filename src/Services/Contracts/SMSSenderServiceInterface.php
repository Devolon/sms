<?php

namespace Devolon\Sms\Services\Contracts;

use Devolon\Sms\DTOs\SentSMSMessageDTO;
use Devolon\Sms\DTOs\SMSMessageDTO;

interface SMSSenderServiceInterface
{
    public function __invoke(SMSMessageDTO $smsMessageDTO): SentSMSMessageDTO;

    public static function getName(): string;
}
