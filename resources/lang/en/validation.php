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

    'accepted' =>  '":attribute" должно быть accepted.',
    'active_url' =>  '":attribute" is not a valid URL.',
    'after' =>  '":attribute" должно быть a date after :date.',
    'after_or_equal' =>  '":attribute" должно быть a date after or equal to :date.',
    'alpha' =>  '":attribute" may only contain letters.',
    'alpha_dash' =>  '":attribute" may only contain letters, numbers, dashes and underscores.',
    'alpha_num' =>  '":attribute" may only contain letters and numbers.',
    'array' =>  '":attribute" должно быть array.',
    'before' =>  '":attribute" должно быть a date before :date.',
    'before_or_equal' =>  '":attribute" должно быть a date before or equal to :date.',
    'between' => [
        'numeric' =>  '":attribute" должно быть between :min and :max.',
        'file' =>  '":attribute" должно быть between :min and :max kilobytes.',
        'string' =>  '":attribute" должно быть between :min and :max characters.',
        'array' =>  '":attribute" must have between :min and :max items.',
    ],
    'boolean' =>  '":attribute" поле должно быть true or false.',
    'confirmed' => '":attribute" не соответствует.',
    'date' =>  '":attribute" is not a valid date.',
    'date_equals' =>  '":attribute" должно быть a date equal to :date.',
    'date_format' =>  '":attribute" does not match the format :format.',
    'different' =>  '":attribute" and :other должно быть different.',
    'digits' =>  '":attribute" должно быть :digits digits.',
    'digits_between' =>  '":attribute" должно быть between :min and :max digits.',
    'dimensions' =>  '":attribute" has invalid image dimensions.',
    'distinct' =>  '":attribute" поле has a duplicate value.',
    'email' =>  '":attribute" должно быть a valid email address.',
    'ends_with' =>  '":attribute" must end with one of the following: :values.',
    'exists' =>  'selected ":attribute" is invalid.',
    'file' =>  '":attribute" должно быть a file.',
    'filled' =>  '":attribute" поле must have a value.',
    'gt' => [
        'numeric' =>  '":attribute" должно быть greater than :value.',
        'file' =>  '":attribute" должно быть greater than :value kilobytes.',
        'string' =>  '":attribute" должно быть greater than :value characters.',
        'array' =>  '":attribute" must have more than :value items.',
    ],
    'gte' => [
        'numeric' =>  '":attribute" должно быть greater than or equal :value.',
        'file' =>  '":attribute" должно быть greater than or equal :value kilobytes.',
        'string' =>  '":attribute" должно быть greater than or equal :value characters.',
        'array' =>  '":attribute" must have :value items or more.',
    ],
    'image' =>  '":attribute" должно быть image.',
    'in' =>  'selected ":attribute" is invalid.',
    'in_array' =>  '":attribute" поле does not exist in :other.',
    'integer' =>  '":attribute" должно быть числом.',
    'ip' =>  '":attribute" должно быть a valid IP address.',
    'ipv4' =>  '":attribute" должно быть a valid IPv4 address.',
    'ipv6' =>  '":attribute" должно быть a valid IPv6 address.',
    'json' =>  '":attribute" должно быть a valid JSON string.',
    'lt' => [
        'numeric' =>  '":attribute" должно быть less than :value.',
        'file' =>  '":attribute" должно быть less than :value kilobytes.',
        'string' =>  '":attribute" должно быть less than :value characters.',
        'array' =>  '":attribute" must have less than :value items.',
    ],
    'lte' => [
        'numeric' =>  '":attribute" должно быть less than or equal :value.',
        'file' =>  '":attribute" должно быть less than or equal :value kilobytes.',
        'string' =>  '":attribute" должно быть less than or equal :value characters.',
        'array' =>  '":attribute" must not have more than :value items.',
    ],
    'max' => [
        'numeric' =>  '":attribute" may not be greater than :max.',
        'file' =>  '":attribute" may not be greater than :max kilobytes.',
        'string' =>  '":attribute" may not be greater than :max characters.',
        'array' =>  '":attribute" may not have more than :max items.',
    ],
    'mimes' =>  '":attribute" должно быть a file of type: :values.',
    'mimetypes' =>  '":attribute" должно быть a file of type: :values.',
    'min' => [
        'numeric' => '":attribute" должен быть длиною хотя бы :min.',
        'file' => '":attribute" должно быть at least :min kilobytes.',
        'string' => '":attribute" должен быть длиною хотя бы :min символов.',
        'array' =>  '":attribute" must have at least :min items.',
    ],
    'multiple_of' =>  '":attribute" должно быть a multiple of :value.',
    'not_in' =>  'selected ":attribute" is invalid.',
    'not_regex' =>  '":attribute" format is invalid.',
    'numeric' =>  '":attribute" должно быть a number.',
    'password' =>  'password is incorrect.',
    'present' =>  '":attribute" поле должно быть present.',
    'regex' =>  '":attribute" format is invalid.',
    'required' => '"":attribute"" поле обязательное.',
    'required_if' =>  '"":attribute"" поле is required when :other is :value.',
    'required_unless' =>  '":attribute" поле is required unless :other is in :values.',
    'required_with' =>  '":attribute" поле is required when :values is present.',
    'required_with_all' =>  '":attribute" поле is required when :values are present.',
    'required_without' =>  '":attribute" поле is required when :values is not present.',
    'required_without_all' =>  '":attribute" поле is required when none of :values are present.',
    'same' =>  '":attribute" and :other must match.',
    'size' => [
        'numeric' =>  '":attribute" должно быть :size.',
        'file' =>  '":attribute" должно быть :size kilobytes.',
        'string' =>  '":attribute" должно быть :size characters.',
        'array' =>  '":attribute" must contain :size items.',
    ],
    'starts_with' =>  '":attribute" must start with one of the following: :values.',
    'string' =>  '":attribute" должно быть a string.',
    'timezone' =>  '":attribute" должно быть a valid zone.',
    'unique' =>  '":attribute" has already been taken.',
    'uploaded' =>  '":attribute" failed to upload.',
    'url' =>  '":attribute" format is invalid.',
    'uuid' =>  '":attribute" должно быть a valid UUID.',

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
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'password' => 'Пароль',
        'username' => 'Логин',
        'name' => 'Название',
        'host' => 'Хост',
        'owner' => 'Владелец',
        'enabled' => 'Включено',
    ],

];
