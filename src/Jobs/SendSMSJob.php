<?php

namespace Devolon\Sms\Jobs;

use Devolon\Sms\Actions\SendSMSAction;
use Devolon\Sms\DTOs\SendSMSMessageDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private SendSMSMessageDTO $sendSMSMessageDTO)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SendSMSAction $sendSMSAction)
    {
        $sendSMSAction($this->sendSMSMessageDTO);
    }
}
