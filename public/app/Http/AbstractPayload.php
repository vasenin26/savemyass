<?php

namespace app\Http;

use app\Http\Request\Request;
use app\Utils\Validator\AbstractValidator;

abstract class AbstractPayload implements RequestPayload
{
    private array $errors = [];

    private array $payload = [];

    protected array $rules = [];

    final public function __construct(protected readonly Request $request)
    {
        $this->doValidateRequest();
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function doValidateRequest(): void
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->request->getPayload($field);

            foreach ($rules as $rule) {
                $validator = $this->getValidator($value, $rule);

                if (!$validator->isValid()) {
                    array_key_exists($field, $this->errors) || $this->errors[$field] = [];
                    $this->errors[$field][] = $field . '.'. $validator->getError();
                }

            }

            $this->payload[$field] = $value;
        }
    }

    private function getValidator(mixed $value, string $rule): AbstractValidator
    {
        return new $rule($value);
    }

    public function __call(string $method, array $args)
    {
        if (str_starts_with($method, 'get')) {
            $field = strtolower(substr($method, 3));
            return $this->payload[$field] ?? null;
        }

        return null;
    }
}
