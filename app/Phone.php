<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'phones';

    protected $fillable = [
        'user_id', 'phone'
    ];

    //支店
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
