<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupChatMessage extends Model
{
    protected $table = 'group_chat_messages';

    protected $fillable = [
        'group_id', 
        'sender_id', 
        'message', 
        'attaments'
    ];

    protected $casts = [
        'attaments' => 'array'
    ];


    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(GroupUser::class, 'sender_id');
    }
}
