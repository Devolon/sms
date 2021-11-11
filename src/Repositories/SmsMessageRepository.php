<?php

namespace Devolon\Sms\Repositories;


use Devolon\Common\Bases\Repository;
use Devolon\Sms\Models\SmsMessage;

class SmsMessageRepository extends Repository
{
    protected array $fillable = [
        'from',
        'to',
        'text',
        'tracking_code',
        'sender_service',
    ];

    public function model(): string
    {
        return SmsMessage::class;
    }
}
