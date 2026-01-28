<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // Custom validation rules
    public $signup = [
        'first_name' => [
            'rules'  => 'required|min_length[2]|max_length[50]',
            'errors' => [
                'required' => 'First name is required',
                'min_length' => 'First name must be at least 2 characters',
            ]
        ],
        'last_name' => [
            'rules'  => 'required|min_length[2]|max_length[50]',
            'errors' => [
                'required' => 'Last name is required',
            ]
        ],
        'email' => [
            'rules'  => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required' => 'Email is required',
                'valid_email' => 'Please provide a valid email',
                'is_unique' => 'This email is already registered',
            ]
        ],
        'phone' => [
            'rules'  => 'required|min_length[10]|max_length[15]',
            'errors' => [
                'required' => 'Phone number is required',
            ]
        ],
        'password' => [
            'rules'  => 'required|min_length[6]',
            'errors' => [
                'required' => 'Password is required',
                'min_length' => 'Password must be at least 6 characters',
            ]
        ],
        'confirm_password' => [
            'rules'  => 'required|matches[password]',
            'errors' => [
                'required' => 'Please confirm your password',
                'matches' => 'Passwords do not match',
            ]
        ],
    ];

    public $login = [
        'email' => [
            'rules'  => 'required|valid_email',
            'errors' => [
                'required' => 'Email is required',
                'valid_email' => 'Please provide a valid email',
            ]
        ],
        'password' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Password is required',
            ]
        ],
    ];
}