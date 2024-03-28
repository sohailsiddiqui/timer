<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
  
    protected $dates = ['deleted_at'];
	
	protected $table = 'project';
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body'];
   
    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function projecthours()
    {
        return $this->hasMany(Projecthour::class)->whereNull('parent_id');
    }
}
