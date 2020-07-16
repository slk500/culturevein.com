<?php


namespace ApiProblem;


final class ApiProblem extends \Exception
{
    const USER_ALREADY_EXIST = ['User with provided email address already exist', 400];
    const EMAIL_NOT_VALID = ['Not a valid email', 400];
    const ALL_FIELDS_HAVE_TO_BE_FILLED = ['All fields have to be filled', 400];

    const WRONG_CREDENTIALS = ['Wrong credentials', 401];
    const PASSWORD_MISMATCH = ['Password mismatch', 401];

    const NOT_FOUND = ['Resource not found', 404];

    private static array $titles = [
        self::WRONG_CREDENTIALS,
        self::PASSWORD_MISMATCH
    ];

    public array $title;

    public function __construct(array $title, \Exception $previous = null)
    {
        if (array_search($title, self::$titles)) {
            throw new \InvalidArgumentException("No title: $title[0]");
        }

        $this->title = $title;
        $message = $title[0];
        $statusCode = $title[1];

        parent::__construct($message, $statusCode, $previous);
    }
}