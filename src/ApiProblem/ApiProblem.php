<?php


namespace ApiProblem;


final class ApiProblem extends \Exception
{
    const USER_ALREADY_EXIST = ['User with provided email address already exist', 400];
    const EMAIL_NOT_VALID = ['Not a valid email', 400];
    const ALL_FIELDS_HAVE_TO_BE_FILLED = ['All fields have to be filled', 400];

    const WRONG_CREDENTIALS = ['Wrong credentials', 401];
    const PASSWORD_MISMATCH = ['Password mismatch', 401];

    const USER_NOT_LOGGED_IN = ['User have to be logged in to take that action', 403];

    const NOT_FOUND = ['Resource not found', 404];

    private static array $titles = [
        self::USER_ALREADY_EXIST,
        self::EMAIL_NOT_VALID,
        self::ALL_FIELDS_HAVE_TO_BE_FILLED,
        self::WRONG_CREDENTIALS,
        self::PASSWORD_MISMATCH,
        self::NOT_FOUND,
        self::USER_NOT_LOGGED_IN
    ];

    public array $title;

    public function __construct(array $title, \Exception $previous = null)
    {
        if (!array_search($title[0], array_column(self::$titles, 0))) {
            throw new \InvalidArgumentException("$title[0]");
        }

        $this->title = $title;
        $message = $title[0];
        $statusCode = $title[1];

        parent::__construct($message, $statusCode, $previous);
    }
}