<?php

namespace Devolon\Sms\Models;

use Devolon\Common\Traits\RepositoryRouteBinding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string to
 * @property string text
 * @property string from
 * @property string sender_service
 * @property string tracking_code
 */
class SmsMessage extends Model
{
    use HasFactory;
    use RepositoryRouteBinding;

    protected $table = 'sms_messages';
}
