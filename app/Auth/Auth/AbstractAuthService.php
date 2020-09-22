<?php

declare(strict_types=1);

namespace App\Auth\Auth;

use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

abstract class AbstractAuthService
{
    /**
     * Validation rules.
     */
    protected array $validationRules = [];

    /**
     * A bag of error messages.
     */
    protected MessageBag $errors;

    /**
     */
    public function __construct()
    {
        $this->errors = new MessageBag();
    }

    /**
     * Returns the error message bag.
     *
     * @return MessageBag
     */
    public function getErrors(): MessageBag
    {
        return $this->errors;
    }

    /**
     * Gets a validator for a specific ruleset.
     *
     * @param string $ruleset   Validation rules.
     * @param array  $inputData Input data.
     * @param array  $messages  Error messages.
     *
     * @return Validator
     */
    public function getValidator(string $ruleset, array $inputData, array $messages = []): Validator
    {
        return ValidatorFactory::make($inputData, $this->validationRules[$ruleset], $messages);
    }
}
