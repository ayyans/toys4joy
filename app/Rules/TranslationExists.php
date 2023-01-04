<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TranslationExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private $table,
        private $column,
        private $translation = 'en'
    ) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->table::where(
            $this->column.'->'.$this->translation, $value
        )->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf('The :attribute must exists in the column "%s" translation.', $this->translation);
    }
}
