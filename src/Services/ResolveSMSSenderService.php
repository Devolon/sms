<?php

namespace Devolon\Sms\Services;

use Devolon\Sms\Services\Contracts\SMSSenderServiceInterface;
use InvalidArgumentException;

class ResolveSMSSenderService
{
    /**
     * @param array<string, SMSSenderServiceInterface> $senders
     */
    public function __construct(private array $senders)
    {
    }

    public function __invoke(?string $name = null): SMSSenderServiceInterface
    {
        if (null === $name) {
            $name = config('sms.default');
        }

        if (!isset($this->senders[$name])) {
            throw new InvalidArgumentException('The name of sms sender is wrong.');
        }

        return $this->senders[$name];
    }
}
