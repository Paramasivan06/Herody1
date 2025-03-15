<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mail Driver
    |--------------------------------------------------------------------------
    |
    | Laravel supports various drivers for email delivery, such as SMTP,
    | Sendmail, Mailgun, SES, and others. Here, we configure it for SMTP.
    |
    */

    'driver' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Address
    |--------------------------------------------------------------------------
    |
    | This is the SMTP server used for sending emails. Update this to match
    | the server provided by your email service (e.g., InstaAlerts).
    |
    */

    'host' => env('MAIL_HOST', 'smtp.instaalerts.zone'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Port
    |--------------------------------------------------------------------------
    |
    | This is the port for the SMTP server. Common ports are 587 for TLS
    | or 465 for SSL. InstaAlerts recommends port 587 with no encryption.
    |
    */

    'port' => env('MAIL_PORT', 587),

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | Define a global email address and name to use for all outgoing emails.
    | These values can be customized per email using the `from` method.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'alerts@herody.in'),
        'name' => env('MAIL_FROM_NAME', 'Herody On-Boarding'),
    ],

    /*
    |--------------------------------------------------------------------------
    | E-Mail Encryption Protocol
    |--------------------------------------------------------------------------
    |
    | Specify the encryption protocol for email delivery. If encryption is not
    | required, set this to `null`. Otherwise, use `tls` or `ssl` based on your setup.
    |
    */

    'encryption' => env('MAIL_ENCRYPTION', null),

    /*
    |--------------------------------------------------------------------------
    | SMTP Server Username
    |--------------------------------------------------------------------------
    |
    | If your SMTP server requires authentication, set your username here.
    | It is used along with the password for authentication during connection.
    |
    */

    'username' => env('MAIL_USERNAME', 'herody_email'),

    'password' => env('MAIL_PASSWORD', 'anabeanaherodY@1'),

    /*
    |--------------------------------------------------------------------------
    | Sendmail System Path
    |--------------------------------------------------------------------------
    |
    | If using the "sendmail" driver, specify the system path to the Sendmail
    | binary here. This is not relevant for SMTP-based email delivery.
    |
    */

    'sendmail' => '/usr/sbin/sendmail -bs',

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | When rendering email messages using Markdown, these paths and themes
    | control the design. Customize these as per your application's needs.
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channel
    |--------------------------------------------------------------------------
    |
    | If using the "log" driver, you can define the logging channel to keep
    | email logs separate from other application logs for better organization.
    |
    */

    'log_channel' => env('MAIL_LOG_CHANNEL'),

];
