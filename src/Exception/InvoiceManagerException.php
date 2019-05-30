<?php

namespace App\Exception;

class InvoiceManagerException extends \Exception
{
    public const NOT_FOUND = 'not_found';
    public const PAGE_NOT_FOUND = 'not_found';
    public const DATA_NOT_ALLOWED = 'data_not_allowed';
    public const METHOD_NOT_ALLOWED = 'method_not_allowed';
    public const INVALID_CREDENTIALS = 'invalid_credentials';

    public const INVALID_AUTHORIZATION = 'invalid_authorization';
    public const INVALID_ARGUMENTS = 'invalid_arguments';
    public const DUPLICATE_ENTRY = 'duplicate_entry';
    public const MISSING_PARAMS = 'missing_params';

    public const DATABASE_ERROR = 'database_error';
    public const FILE_ERROR = 'file_error';
}