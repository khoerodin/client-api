<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id', 'user_id',
    ];

    protected $casts = [
        'book_id' => 'integer',
        'user_id' => 'integer',
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
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];

        $updateRule = [
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];

        return $forUpdate ? $updateRule : $createRule;
    }
}
