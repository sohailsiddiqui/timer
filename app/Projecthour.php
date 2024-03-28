<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Projecthour extends Model
{
    use SoftDeletes;
   
    protected $dates = ['deleted_at'];
	
	protected $table = 'projecthour';
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['user_id', 'post_id', 'parent_id', 'body'];
	protected $fillable = ['user_id', 'post_id', 'parent_id', 'body', 'publish_date','isactive','publishdate_end','hours'];
   
    /**
     * The belongs to Relationship
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   

}
