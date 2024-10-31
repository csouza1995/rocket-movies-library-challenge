<?php

class Validator
{
    private Database $db;
    private $errors = [];

    public function __construct()
    {
        $this->db = new Database(config('database'));
    }

    public static function validate($rules, $data, $attributes = []): Validator
    {
        $validator = new Validator();

        foreach ($rules as $field => $fieldRules) {
            if (is_string($fieldRules)) {
                $fieldRules = explode('|', $fieldRules);
            }

            foreach ($fieldRules as $rule) {
                $ruleValues = explode(':', $rule);

                $rule = array_shift($ruleValues);

                $ruleValues = explode(',', implode(':', $ruleValues));

                if (method_exists($validator, $rule)) {
                    $validator->$rule($field, $data, $attributes, ...$ruleValues);
                } else {
                    throw new Exception("Rule {$rule} does not exist");
                }
            }
        }

        return $validator;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function addError(string $field, string $rule, string $message, array $attributes): void
    {
        // If the field does not exist in the errors array, create it
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        // Add the error message to the field
        $this->errors[$field][] = str_replace(
            [':attribute', ':rule'],
            [$attributes[$field] ?? $field, $rule],
            $message
        );
    }

    private function required($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            $this->addError(
                $field,
                'required',
                'Field :attribute is required',
                $attributes
            );
        }
    }

    private function email($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            return;
        }

        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError(
                $field,
                'email',
                'Field :attribute must be a valid email address',
                $attributes
            );
        }
    }

    private function numeric($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            return;
        }

        if (!is_numeric($data[$field])) {
            $this->addError(
                $field,
                'numeric',
                'Field :attribute must be a number',
                $attributes
            );
        }
    }

    private function min($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            return;
        }

        $min = $ruleValues[0];
        $checkValue = is_numeric($data[$field]) ? (float)$data[$field] : strlen($data[$field]);

        if ($checkValue < $min) {
            $this->addError(
                $field,
                'min',
                'Field :attribute must be at least :rule characters',
                $attributes
            );
        }
    }

    private function max($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            return;
        }

        $max = $ruleValues[0];
        $checkValue = is_numeric($data[$field]) ? (float)$data[$field] : strlen($data[$field]);

        if ($checkValue > $max) {
            $this->addError(
                $field,
                'max',
                'Field :attribute may not be greater than :rule characters',
                $attributes
            );
        }
    }

    private function confirmed($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            return;
        }

        $confirmationField = $ruleValues[0] ?? "{$field}_confirm";

        if ($data[$field] !== $data[$confirmationField]) {
            $this->addError(
                $field,
                'confirmed',
                'Field :attribute does not match the confirmation',
                $attributes
            );
        }
    }

    private function strong($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            return;
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $data[$field])) {
            $this->addError(
                $field,
                'strong',
                'Field :attribute must contain at least one uppercase letter, one lowercase letter, and one number',
                $attributes
            );
        }
    }

    private function unique($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            return;
        }

        $table = $ruleValues[0];
        $column = $ruleValues[1] ?? $field;

        $result = $this->db
            ->query(
                "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :{$column}",
                [$column => $data[$field]]
            )
            ->fetch();

        if ($result->count > 0) {
            $this->addError(
                $field,
                'unique',
                'Field :attribute must be unique',
                $attributes
            );
        }
    }

    private function exists($field, $data, $attributes, ...$ruleValues)
    {
        if (!isset($data[$field]) || strlen($data[$field]) === 0) {
            return;
        }

        $table = $ruleValues[0];
        $column = $ruleValues[1] ?? $field;

        $result = $this->db
            ->query(
                "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :{$column}",
                [$column => $data[$field]]
            )
            ->fetch();

        if ($result->count === 0) {
            $this->addError(
                $field,
                'exists',
                'Field :attribute must exist',
                $attributes
            );
        }
    }
}
