<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */



    'accepted'             => ':attribute debe ser aceptado/a.',
    'active_url'           => ':attribute no es una URL válida.',
    'after'                => ':attribute debe ser una fecha posterior a :date',
    'alpha'                => ':attribute sólo puede contener letras.',
    'alpha_dash'           => ':attribute sólo puede contener letras, números y guiones.',
    'alpha_num'            => ':attribute sólo puede contener letras y números.',
    'array'                => ':attribute debe ser una matriz.',
    'before'               => ':attribute debe ser una fecha anterior a :date',
    'between'              => [
        'numeric' => ':attribute debe estar entre :min y :max',
        'file'    => ':attribute debe estar entre :min y :max Kilobytes',
        'string'  => ':attribute debe estar entre :min y :max Caracteres',
        'array'   => ':attribute debe tener entre :min y :max Artículos',
    ],
    'boolean'              => ':attribute debe ser verdadero o falso.',
    'confirmed'            => ':attribute de confirmación no coincide.',
    'date'                 => ':attribute no es una fecha válida.',
    'date_format'          => ':attribute no coincide con el formato :format.',
    'different'            => ':attribute  y :other deben ser diferetes.',
    'digits'               => ':attribute debe ser de :digits dígitos.',
    'digits_between'       => ':attribute debe estar entre: y: min. Dígitos máx',
    'email'                => ':attribute debe ser una dirección de correo electrónico válida.',
    'exists'               => ':attribute seleccionado  no es válido.',
    'filled'               => 'El campo :attribute: es obligatorio.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute seleccionado no es válido.',
    'integer'              => ':attribute debe ser un entero.',
    'ip'                   => ':attribute debe ser una dirección IP válida.',
    'json'                 => ':attribute debe ser una cadena JSON válido.',
    'max'                  => [
        'numeric' => ':attribute no puede ser mayor que :max',
        'file'    => ':attribute no puede ser mayor que :max Kilobytes',
        'string'  => ':attribute no puede ser mayor que :max Caracteres',
        'array'   => ':attribute no puede tener más de :max Artículos',
    ],
    'mimes'                => ':attribute debe ser un archivo de tipo: :values',
    'min'                  => [
        'numeric' => ':attribute debe ser de al menos :min.',
        'file'    => ':attribute debe ser de al menos :min kilobytes.',
        'string'  => ':attribute debe ser de al menos :min caracteres.',
        'array'   => ':attribute debe tener por lo menos :min artículos.',
    ],
    'not_in'               => 'El campo :attribute seleccionado no es válido.',
    'numeric'              => ':attribute debe ser un número.',
    'regex'                => 'El campo formato de :attribute no es válido.',
    'required'             => 'El campo :attribute: es obligatorio.',
    'required_if'          => 'El campo :attribute: es obligatorio cuando :other es :value',
    'required_with'        => 'El campo :attribute: es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute: es obligatorio cuando :values está presente.',
    'required_without'     => 'El campo :attribute: es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute: es obligatorio cuando ninguna de :values están presentes.',
    'same'                 => ':attribute  y :other deben coincidir.',    
    'size'                 => [
        'numeric' => ':attribute debe ser size:.',
        'file'    => ':attribute debe ser size: kilobytes.',
        'string'  => ':attribute debe ser size: cadacteres.',
        'array'   => ':attribute debe contener :size artículos.',    
    ],
    'string'               => ':attribute debe ser una cadena de texto.',
    'timezone'             => ':attribute debe ser una zona válida.',
    'unique'               => ':attribute ya ha sido tomado/a.',
    'url'                  => 'El campo Formato de :attribute  no es válido.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensaje personalizado',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];