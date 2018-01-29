<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    /**
     * Validation rules
     *
     * @param bool $forUpdate
     * @return array
     */
    public function getValidationRules($forUpdate = false)
    {
        $createRule = [
            'title'       => 'required|max:200',
            'description' => 'required',
        ];

        $updateRule = [
            'title'       => 'required|max:200',
            'description' => 'required',
        ];

        return $forUpdate ? $updateRule : $createRule;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
