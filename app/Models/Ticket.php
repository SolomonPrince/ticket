<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'name',
        'email',
        'status',
        'message',
        'comment',
        'user_id',
        'responsible_id'
    ];

    protected $appends = [
        'created_time',
        'updated_time'

    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    public function getCreatedTimeAttribute(){
        return $this->created_at->format('d-m-Y H:i');
    }

    public function getUpdatedTimeAttribute(){
        return $this->updated_at->format('d-m-Y H:i');
    }

}
