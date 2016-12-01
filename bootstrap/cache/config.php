<?php return array (
  'app' => 
  array (
    'env' => 'local',
    'debug' => true,
    'url' => 'http://dev.destinyui',
    'timezone' => 'Asia/Bangkok',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'key' => 'base64:StKRLfLEkIUrsn2keDBBHKwitgnYTT7Bll5rV4X92Vk=',
    'cipher' => 'AES-256-CBC',
    'log' => 'single',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      13 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      14 => 'Illuminate\\Queue\\QueueServiceProvider',
      15 => 'Illuminate\\Redis\\RedisServiceProvider',
      16 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      17 => 'Illuminate\\Session\\SessionServiceProvider',
      18 => 'Illuminate\\Translation\\TranslationServiceProvider',
      19 => 'Illuminate\\Validation\\ValidationServiceProvider',
      20 => 'Illuminate\\View\\ViewServiceProvider',
      21 => 'Anhskohbo\\NoCaptcha\\NoCaptchaServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\AuthServiceProvider',
      24 => 'App\\Providers\\EventServiceProvider',
      25 => 'App\\Providers\\RouteServiceProvider',
      26 => 'App\\Providers\\RESTResponseServiceProvider',
      27 => 'App\\Providers\\ValidationServiceProvider',
      28 => 'Jenssegers\\Agent\\AgentServiceProvider',
      29 => 'Jenssegers\\Mongodb\\MongodbServiceProvider',
      30 => 'Jenssegers\\Rollbar\\RollbarServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Applicant' => 'App\\Applicant\\Applicant',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Bailey' => 'App\\Bailey\\Bailey',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Agent' => 'Jenssegers\\Agent\\Facades\\Agent',
      'RESTResponse' => 'App\\Facades\\RESTResponse',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'email' => 'auth.emails.password',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'pusher',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'D:\\MAMP\\htdocs\\site\\DestinyUIv3\\storage\\framework/cache',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'captcha' => 
  array (
    'secret' => '6LdwBwcUAAAAAADQ_WU96cxAmnlSDoPgtU4_zAQB',
    'sitekey' => '6LdwBwcUAAAAAEQaI6oRRQePEUZGChiWhnj1fLVr',
  ),
  'compile' => 
  array (
    'files' => 
    array (
    ),
    'providers' => 
    array (
    ),
  ),
  'database' => 
  array (
    'fetch' => 8,
    'default' => 'mongodb',
    'connections' => 
    array (
      'mongodb' => 
      array (
        'driver' => 'mongodb',
        'host' => '127.0.0.1',
        'port' => '27017',
        'database' => 'tuent',
        'username' => NULL,
        'password' => NULL,
        'options' => 
        array (
          'database' => 'admin',
        ),
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'cluster' => false,
      'default' => 
      array (
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 0,
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\MAMP\\htdocs\\site\\DestinyUIv3\\storage\\app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\MAMP\\htdocs\\site\\DestinyUIv3\\storage\\app/public',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => 'your-key',
        'secret' => 'your-secret',
        'region' => 'your-region',
        'bucket' => 'your-bucket',
      ),
      'document' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\MAMP\\htdocs\\site\\DestinyUIv3\\storage\\uploaded_documents',
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'mailgun',
    'host' => 'smtp.mailgun.org',
    'port' => 587,
    'from' => 
    array (
      'address' => NULL,
      'name' => NULL,
    ),
    'encryption' => 'tls',
    'username' => NULL,
    'password' => NULL,
    'sendmail' => '/usr/sbin/sendmail -bs',
    'mailgun' => 
    array (
      'domain' => 'apply.triamudom.ac.th',
      'secret' => 'key-d1bb6678eaed317ef26182a09ac71d87',
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'expire' => 60,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'ttr' => 60,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'expire' => 60,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => 'apply.triamudom.ac.th',
      'secret' => 'key-d1bb6678eaed317ef26182a09ac71d87',
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'App\\User',
      'key' => NULL,
      'secret' => NULL,
    ),
    'rollbar' => 
    array (
      'access_token' => '965f128778db41829bea980c8d5cd9df',
      'level' => 'error',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => true,
    'files' => 'D:\\MAMP\\htdocs\\site\\DestinyUIv3\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'destiny_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
  ),
  'uiconfig' => 
  array (
    'core_api_key' => 'debug',
    'core_base_api_url' => 'https://core3.destiny.triamudom.ac.th',
    'mode' => 'province_quota',
    'operation_year' => '2559',
    'isPTR' => false,
    'andromeda_key' => 'songkiatthepprasaneza555',
    'andromeda_url' => 'http://help.apply.triamudom.ac.th',
    'valkyrie_base_api_url' => 'http://dev.valkyrie',
    'valkyrie_api_key' => '',
    'move_in_deadline' => '16/05/2558',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'D:\\MAMP\\htdocs\\site\\DestinyUIv3\\resources\\views',
    ),
    'compiled' => 'D:\\MAMP\\htdocs\\site\\DestinyUIv3\\storage\\framework\\views',
  ),
);
