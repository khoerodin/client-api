<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id', 'parent', 'title', 'content',
    ];

    protected $casts = [
        'book_id' => 'integer',
        'parent'  => 'integer',
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
            'parent'  => 'nullable',
            'title'   => 'required|max:200',
        ];

        $updateRule = [
            'book_id' => 'required|integer',
            'parent'  => 'nullable',
            'title'   => 'required|max:200',
        ];

        return $forUpdate ? $updateRule : $createRule;
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
