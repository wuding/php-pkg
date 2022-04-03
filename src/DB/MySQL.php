<?php

namespace Pkg\DB;

class MySQL
{
    const VERSION = '22.4.1';

    public $pg_toc = array(
        'dev.mysql.com' => array(
            'doc' => array(
                'refman' => array(
                    '8.0' => array(
                        'en' => array(
                            'string-functions.html' => array(
                                '' => array(
                                    '' => 'MySQL :: MySQL 8.0 Reference Manual :: 12.8 String Functions and Operators',
                                    'UP' => 'https://dev.mysql.com/doc/refman/8.0/en/functions.html',
                                    'PREV' => 'https://dev.mysql.com/doc/refman/8.0/en/date-and-time-functions.html',
                                    'NEXT' -> 'https://dev.mysql.com/doc/refman/8.0/en/string-comparison-functions.html',
                                ),
                                'para' => array(
                                    'REPLACE(str, from_str, to_str)' => 'Replace occurrences of a specified string',
                                ),
                            ),
                        ),
                    ),

                ),
                'mysql-errors' => array(
                    '5.7' => array(
                        'en' => array(
                            'server-error-reference.html' => array(
                                '' => array(
                                    'MySQL :: MySQL 5.7 Error Reference :: 2 Server Error Message Reference',
                                    'Chapter 2 Server Error Message Reference',
                                ),
                                'para' => array(
                                    '1050' => array(
                                        'Symbol' => 'ER_TABLE_EXISTS_ERROR',
                                        'SQLSTATE' => '42s01',
                                        'Message' => "Table '%s' already exists",
                                    ),
                                    1064 => array(
                                        'Symbol' => 'ER_PARSE_ERROR',
                                        'SQLSTATE' => '42000',
                                        'Message' => "%s near '%s' at line %d",
                                    ),
                                    1133 => array(
                                        'Symbol' => 'ER_PASSWORD_NO_MATCH',
                                        'SQLSTATE' => '42000',
                                        'Message' => "can't find any matching row in the user table",
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    );
}
