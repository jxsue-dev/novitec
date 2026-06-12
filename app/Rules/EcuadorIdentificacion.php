<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EcuadorIdentificacion implements ValidationRule
{
    public function __construct(
        protected string $type = 'both'
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $value = preg_replace('/\D+/', '', trim((string) $value)) ?? '';
        $len = strlen($value);

        if ($this->type === 'cedula' && $len !== 10) {
            $fail('La identificacion debe ser una cedula de 10 digitos.');
            return;
        }

        if ($this->type === 'ruc' && $len !== 13) {
            $fail('La identificacion debe ser un RUC de 13 digitos.');
            return;
        }

        if ($len !== 10 && $len !== 13) {
            $fail('La identificacion debe tener 10 digitos o 13 digitos.');
            return;
        }

        if ($value === '' || ! ctype_digit($value)) {
            $fail('La identificacion solo debe contener numeros.');
            return;
        }

        if ($len === 10 && ! $this->validarCedula($value)) {
            $fail('La cedula ingresada no es valida.');
            return;
        }

        if ($len === 13 && ! $this->validarRuc($value)) {
            $fail('El RUC ingresado no es valido.');
        }
    }

    protected function validarCedula(string $value): bool
    {
        $provincia = (int) substr($value, 0, 2);

        return (($provincia >= 1 && $provincia <= 24) || $provincia === 30);
    }

    protected function validarRuc(string $value): bool
    {
        $establecimiento = substr($value, 10, 3);
        $provincia = (int) substr($value, 0, 2);

        if ($establecimiento === '000') {
            return false;
        }

        return (($provincia >= 1 && $provincia <= 24) || $provincia === 30);
    }
}
