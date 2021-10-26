<?php

namespace Devolon\Sms\Database\Factories;

use Devolon\Sms\Models\SMSMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SmsMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SmsMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
