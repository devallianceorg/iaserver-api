<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DEFAULT_CONNECTION', 'sqlsrv'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('MYSQL_DATABASE_URL'),
            'host' => env('MYSQL_DB_HOST', 'localhost'),
            'port' => env('MYSQL_DB_PORT', '3306'),
            'database' => env('MYSQL_DB_DATABASE', 'forge'),
            'username' => env('MYSQL_DB_USERNAME', 'forge'),
            'password' => env('MYSQL_DB_PASSWORD', ''),
            'unix_socket' => env('MYSQL_DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('SQLSRV_DATABASE_URL'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        'sqlebs' => [
            'driver' => 'sqlsrv',
            'host' => env('EBS_DB_HOST', 'localhost'),
            'port' => env('EBS_DB_PORT', '1433'),
            'database' => env('EBS_DB_DATABASE', 'forge'),
            'username' => env('EBS_DB_USERNAME', 'forge'),
            'password' => env('EBS_DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        'aoidata' => [
            'driver' => 'sqlsrv',
            'host' => env('AOIDATA_DB_HOST'),
            'port' => env('AOIDATA_DB_PORT'),
            'database' => env('AOIDATA_DB_DATABASE'),
            'username' => env('AOIDATA_DB_USERNAME'),
            'password' => env('AOIDATA_DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'prefix' => '',
            'prefix_indexes' => true,
        ],
        'iaserver' => [
            'driver' => 'sqlsrv',
            'host' => env('IASERVER_DB_HOST'),
            'port' => env('IASERVER_DB_PORT'),
            'database' => env('IASERVER_DB_DATABASE'),
            'username' => env('IASERVER_DB_USERNAME'),
            'password' => env('IASERVER_DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        'smtdatabase' => [
            'driver' => 'sqlsrv',
            'host' => env('SMTDATABASE_DB_HOST', 'iaserver-mysql'),
            'port' => env('SMTDATABASE_DB_PORT', '1433'),
            'database' => env('SMTDATABASE_DB_DATABASE', 'smtdatabase'),
            'username' => env('SMTDATABASE_DB_USERNAME', 'iaserver'),
            'password' => env('SMTDATABASE_DB_PASSWORD', 'iaserver'),
            'charset' => 'utf8mb4',
            'prefix' => '',
            'prefix_indexes' => true,
        ],
        'controlconsumibles' => [
            'driver' => 'sqlsrv',
            'host' => env('CONTROLCONSUMIBLES_DB_HOST'),
            'port' => env('CONTROLCONSUMIBLES_DB_PORT'),
            'database' => env('CONTROLCONSUMIBLES_DB_DATABASE'),
            'username' => env('CONTROLCONSUMIBLES_DB_USERNAME'),
            'password' => env('CONTROLCONSUMIBLES_DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        'controlplacas' => [
            'driver' => 'sqlsrv',
            'host' => env('CONTROLPLACAS_DB_HOST'),
            'port' => env('CONTROLPLACAS_DB_PORT'),
            'database' => env('CONTROLPLACAS_DB_DATABASE'),
            'username' => env('CONTROLPLACAS_DB_USERNAME'),
            'password' => env('CONTROLPLACAS_DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'prefix' => '',
            'prefix_indexes' => true,
        ],
        
        'memorias' => [
            'driver' => 'sqlsrv',
            'host' => env('MEMORIAS_DB_HOST'),
            'port' => env('MEMORIAS_DB_PORT'),
            'database' => env('MEMORIAS_DB_DATABASE'),
            'username' => env('MEMORIAS_DB_USERNAME'),
            'password' => env('MEMORIAS_DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        'stencil' => [
            'driver' => 'mysql',
            'host' => env('STENCIL_DB_HOST'),
            'port' => env('STENCIL_DB_PORT'),
            'database' => env('STENCIL_DB_DATABASE'),
            'username' => env('STENCIL_DB_USERNAME'),
            'password' => env('STENCIL_DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'npmpicker' => [
            'driver' => 'mysql',
            'host' => env('NPMPICKER_DB_HOST'),
            'port' => env('NPMPICKER_DB_PORT'),
            'database' => env('NPMPICKER_DB_DATABASE'),
            'username' => env('NPMPICKER_DB_USERNAME'),
            'password' => env('NPMPICKER_DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'authapi' => [
            'driver' => 'sqlsrv',
            'url' => env('AUTHAPI_DATABASE_URL'),
            'host' => env('AUTHAPI_DB_HOST', 'localhost'),
            'port' => env('AUTHAPI_DB_PORT', '1433'),
            'database' => env('AUTHAPI_DB_DATABASE', 'forge'),
            'username' => env('AUTHAPI_DB_USERNAME', 'forge'),
            'password' => env('AUTHAPI_DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        ///////////
        /// DB2 ///
        ///////////

        // 'cgsdb2' => [
        //     'driver' => 'db2_expressc_odbc',
        //     'driverName' => '{IBM i Access ODBC Driver 64-bit}',
        //     'host' => '10.30.10.90',
        //     'username' => 'Admin',
        //     'password' => 'Zxcv',
        //     'database' => '',
        //     'prefix' => '',
        //     'schema' => 'default schema',
        //     'port' => 50000,
        //     // or 'Y-m-d H:i:s.u' / 'Y-m-d-H.i.s.u'...
        //     'odbc_keywords' => [
        //         'SIGNON' => 3,
        //         'SSL' => 0,
        //         'CommitMode' => 2,
        //         'ConnectionType' => 0,
        //         'DefaultLibraries' => '',
        //         'Naming' => 0,
        //         'UNICODESQL' => 0,
        //         'DateFormat' => 5,
        //         'DateSeperator' => 0,
        //         'Decimal' => 0,
        //         'TimeFormat' => 0,
        //         'TimeSeparator' => 0,
        //         'TimestampFormat' => 0,
        //         'ConvertDateTimeToChar' => 0,
        //         'BLOCKFETCH' => 1,
        //         'BlockSizeKB' => 32,
        //         'AllowDataCompression' => 1,
        //         'CONCURRENCY' => 0,
        //         'LAZYCLOSE' => 0,
        //         'MaxFieldLength' => 15360,
        //         'PREFETCH' => 0,
        //         'QUERYTIMEOUT' => 1,
        //         'DefaultPkgLibrary' => 'QGPL',
        //         'DefaultPackage' => 'A /DEFAULT(IBM),2,0,1,0',
        //         'ExtendedDynamic' => 0,
        //         'QAQQINILibrary' => '',
        //         'SQDIAGCODE' => '',
        //         'LANGUAGEID' => 'ENU',
        //         'SORTTABLE' => '',
        //         'SortSequence' => 0,
        //         'SORTWEIGHT' => 0,
        //         'AllowUnsupportedChar' => 0,
        //         'CCSID' => 819,
        //         'GRAPHIC' => 0,
        //         'ForceTranslation' => 0,
        //         'ALLOWPROCCALLS' => 0,
        //         'DB2SQLSTATES' => 0,
        //         'DEBUG' => 0,
        //         'TRUEAUTOCOMMIT' => 0,
        //         'CATALOGOPTIONS' => 3,
        //         'LibraryView' => 0,
        //         'ODBCRemarks' => 0,
        //         'SEARCHPATTERN' => 1,
        //         'TranslationDLL' => '',
        //         'TranslationOption' => 0,
        //         'MAXTRACESIZE' => 0,
        //         'MultipleTraceFiles' => 1,
        //         'TRACE' => 0,
        //         'TRACEFILENAME' => '',
        //         'ExtendedColInfo' => 0,
        //     ],
        //     'options' => [
        //         PDO::ATTR_CASE => PDO::CASE_LOWER,
        //         PDO::ATTR_PERSISTENT => false
        //     ]
        //     + (defined('PDO::I5_ATTR_DBC_SYS_NAMING') ? [PDO::I5_ATTI5_ATTR_DBC_SYS_NAMINGR_COMMIT => false] : [])
        //     + (defined('PDO::I5_ATTR_COMMIT') ? [PDO::I5_ATTR_COMMIT => PDO::I5_TXN_NO_COMMIT] : [])
        //     + (defined('PDO::I5_ATTR_JOB_SORT') ? [PDO::I5_ATTR_JOB_SORT => false] : [])
        //     + (defined('PDO::I5_ATTR_DBC_LIBL') ? [PDO::I5_ATTR_DBC_LIBL => ''] : [])
        //     + (defined('PDO::I5_ATTR_DBC_CURLIB') ? [PDO::I5_ATTR_DBC_CURLIB => ''] : [])
        // ],

        // 'cgsdb2dw' => [
        //     'driver' => 'db2_expressc_odbc',
        //     'driverName' => '{IBM i Access ODBC Driver 64-bit}',
        //     'host' => '10.30.10.89',
        //     'username' => 'Admin',
        //     'password' => 'Zxcv',
        //     'database' => '',
        //     'prefix' => '',
        //     'schema' => 'default schema',
        //     'port' => 50000,
        //     // or 'Y-m-d H:i:s.u' / 'Y-m-d-H.i.s.u'...
        //     'odbc_keywords' => [
        //         'SIGNON' => 3,
        //         'SSL' => 0,
        //         'CommitMode' => 2,
        //         'ConnectionType' => 0,
        //         'DefaultLibraries' => '',
        //         'Naming' => 0,
        //         'UNICODESQL' => 0,
        //         'DateFormat' => 5,
        //         'DateSeperator' => 0,
        //         'Decimal' => 0,
        //         'TimeFormat' => 0,
        //         'TimeSeparator' => 0,
        //         'TimestampFormat' => 0,
        //         'ConvertDateTimeToChar' => 0,
        //         'BLOCKFETCH' => 1,
        //         'BlockSizeKB' => 32,
        //         'AllowDataCompression' => 1,
        //         'CONCURRENCY' => 0,
        //         'LAZYCLOSE' => 0,
        //         'MaxFieldLength' => 15360,
        //         'PREFETCH' => 0,
        //         'QUERYTIMEOUT' => 1,
        //         'DefaultPkgLibrary' => 'QGPL',
        //         'DefaultPackage' => 'A /DEFAULT(IBM),2,0,1,0',
        //         'ExtendedDynamic' => 0,
        //         'QAQQINILibrary' => '',
        //         'SQDIAGCODE' => '',
        //         'LANGUAGEID' => 'ENU',
        //         'SORTTABLE' => '',
        //         'SortSequence' => 0,
        //         'SORTWEIGHT' => 0,
        //         'AllowUnsupportedChar' => 0,
        //         'CCSID' => 819,
        //         'GRAPHIC' => 0,
        //         'ForceTranslation' => 0,
        //         'ALLOWPROCCALLS' => 0,
        //         'DB2SQLSTATES' => 0,
        //         'DEBUG' => 0,
        //         'TRUEAUTOCOMMIT' => 0,
        //         'CATALOGOPTIONS' => 3,
        //         'LibraryView' => 0,
        //         'ODBCRemarks' => 0,
        //         'SEARCHPATTERN' => 1,
        //         'TranslationDLL' => '',
        //         'TranslationOption' => 0,
        //         'MAXTRACESIZE' => 0,
        //         'MultipleTraceFiles' => 1,
        //         'TRACE' => 0,
        //         'TRACEFILENAME' => '',
        //         'ExtendedColInfo' => 0,
        //     ],
        //     'options' => [
        //         PDO::ATTR_CASE => PDO::CASE_LOWER,
        //         PDO::ATTR_PERSISTENT => false
        //     ]
        //     + (defined('PDO::I5_ATTR_DBC_SYS_NAMING') ? [PDO::I5_ATTI5_ATTR_DBC_SYS_NAMINGR_COMMIT => false] : [])
        //     + (defined('PDO::I5_ATTR_COMMIT') ? [PDO::I5_ATTR_COMMIT => PDO::I5_TXN_NO_COMMIT] : [])
        //     + (defined('PDO::I5_ATTR_JOB_SORT') ? [PDO::I5_ATTR_JOB_SORT => false] : [])
        //     + (defined('PDO::I5_ATTR_DBC_LIBL') ? [PDO::I5_ATTR_DBC_LIBL => ''] : [])
        //     + (defined('PDO::I5_ATTR_DBC_CURLIB') ? [PDO::I5_ATTR_DBC_CURLIB => ''] : [])
        // ]

        ////////////
        /// /DB2 ///
        ////////////

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];
