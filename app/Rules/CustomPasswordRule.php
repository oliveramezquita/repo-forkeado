<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomPasswordRule implements Rule
{
    /**
     * The minimum size of the password.
     *
     * @var int
     */
    protected $min = 8;

    /**
     * If the password requires at least one uppercase and one lowercase letter.
     *
     * @var bool
     */
    protected $mixedCase = true;

    /**
     * If the password requires at least one letter.
     *
     * @var bool
     */
    protected $letters = true;

    /**
     * If the password requires at least one number.
     *
     * @var bool
     */
    protected $numbers = true;

    /**
     * If the password requires at least one symbol.
     *
     * @var bool
     */
    protected $symbols = false;

    public function __construct($config = [])
    {
        // Aplica la configuración personalizada, si se proporciona
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function passes($attribute, $value)
    {
        $regex = '/^';

        // Agrega condiciones basadas en las propiedades
        if ($this->mixedCase) {
            $regex .= '(?=.*[a-z])(?=.*[A-Z])';
        }

        if ($this->letters) {
            $regex .= '(?=.*[a-zA-Z])';
        }

        if ($this->numbers) {
            $regex .= '(?=.*\d)';
        }

        if ($this->symbols) {
            $regex .= '(?=.*[@#$%^&+=])'; // Puedes personalizar los símbolos aquí
        }

        $regex .= '.{' . $this->min . ',}$/';

        return preg_match($regex, $value);
    }

    public function message()
    {
        return 'El campo :attribute debe cumplir con las reglas personalizadas.';
    }
}
