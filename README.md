# Shergela Laravel Command
Laravel Command is a command list of a few `php artisan` commands. You can use it to create a files (in app directory) or blade views.
<br />

## Installation
Require the package with composer using the following command:

```
composer require shergela/laravel-command
```

### Add ServiceProvide in config/app.php
```php
<?php
return [
    Shergela\LaravelCommand\ShergelaServiceProvider::class
];
```

## Artisan Command List

<!-- List Of Command -->
<div>
  	<ol>
    	<li><a href="#Create-File">Create File</a></li>
    	<li><a href="#Create-Views">Create Views</a></li>
        <li><a href="#Middleware-List">Middleware List</a></li>
        <li><a href="#Event-List">Event List</a></li>
        <li><a href="#Jobs-List">Jobs List</a></li>
        <li><a href="#Models-List">Models List</a></li>
  	</ol>
</div>
<!-- End list of command -->

<br />

## Create File

__Create a folder and file Class.__\
`php artisan create:file Your/Folder/file.php`

Example:
```
php artisan create:file Helpers/helper.php
```
or
```
php artisan create:file example.php
```

The above will create a **Folders and file** directory inside the **App** directory.\



__An Example of created repository class:__

```
<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Helper
{
    public function __construct()
    {
        // Your code here
    }

    public function index(Request $request): void
    {
        // Write logic here
    }
}


```

<br />


## Create Views
__Create a blade views.__\
`php artisan create:view your-blade-name`

Example:
```
php artisan create:view pages/users/user.blade.php
```
or
```
php artisan create:file users.blade.php
```

```
@extends('app')

@section('content')

	<h1> Hello World </h1>
	
@endsection
```

## Middleware List
__Display all Middlewares.__\
```php artisan middleware:list```

```
+--------------------------------------------------+--------------------------------------+-----------+----------+
| Full Path                                        | File Name                            | Extension | Size     |
+--------------------------------------------------+--------------------------------------+-----------+----------+
| C:\xampp\htdocs\laravel\app\Http\Middleware      | Authenticate.php                     | .php      | 0.49 kb  |
| C:\xampp\htdocs\laravel\app\Http\Middleware      | EncryptCookies.php                   | .php      | 0.324 kb |
| C:\xampp\htdocs\laravel\app\Http\Middleware      | PreventRequestsDuringMaintenance.php | .php      | 0.383 kb |
| C:\xampp\htdocs\laravel\app\Http\Middleware      | RedirectIfAuthenticated.php          | .php      | 0.963 kb |
| C:\xampp\htdocs\laravel\app\Http\Middleware      | TrimStrings.php                      | .php      | 0.4 kb   |
| C:\xampp\htdocs\laravel\app\Http\Middleware      | TrustHosts.php                       | .php      | 0.392 kb |
| C:\xampp\htdocs\laravel\app\Http\Middleware      | TrustProxies.php                     | .php      | 0.677 kb |
| C:\xampp\htdocs\laravel\app\Http\Middleware      | VerifyCsrfToken.php                  | .php      | 0.337 kb |
+--------------------------------------------------+--------------------------------------+-----------+----------+
```

## Event List
__Display all Events.__\
```php artisan event:list```

```
+--------------------------------------------------+--------------------------------------+-----------+----------+
| Full Path                                        | File Name                            | Extension | Size     |
+--------------------------------------------------+--------------------------------------+-----------+----------+
| C:\xampp\htdocs\laravel\app\Events               | Mail.php                             | .php      | 0.49 kb  |
| C:\xampp\htdocs\laravel\app\Events               | Subscribe.php                        | .php      | 0.124 kb |
| C:\xampp\htdocs\laravel\app\Events               | PasswordRecovery.php                 | .php      | 0.384 kb |
+--------------------------------------------------+--------------------------------------+-----------+----------+
```


## Jobs List
__Display all Jobs.__\
```php artisan jobs:list```

```
+--------------------------------------------------+--------------------------------------+-----------+----------+
| Full Path                                        | File Name                            | Extension | Size     |
+--------------------------------------------------+--------------------------------------+-----------+----------+
| C:\xampp\htdocs\laravel\app\Jobs                 | UserJob.php                          | .php      | 0.49 kb  |
| C:\xampp\htdocs\laravel\app\Jobs                 | AssignUserJob.php                    | .php      | 0.124 kb |
| C:\xampp\htdocs\laravel\app\Jobs                 | TestJob.php                          | .php      | 0.483 kb |
+--------------------------------------------------+--------------------------------------+-----------+----------+
```


## Models List
__Display all Models.__\
```php artisan model:list```

```
php artisan model:list
```

```
+--------------------------------------------------+--------------------------------------+-----------+----------+
| Full Path                                        | File Name                            | Extension | Size     |
+--------------------------------------------------+--------------------------------------+-----------+----------+
| C:\xampp\htdocs\laravel\app\Models               | User.php                             | .php      | 0.419 kb  |
| C:\xampp\htdocs\laravel\app\Models               | Post.php                             | .php      | 0.524 kb |
| C:\xampp\htdocs\laravel\app\Models               | Roles.php                            | .php      | 0.483 kb |
+--------------------------------------------------+--------------------------------------+-----------+----------+
```


# License

The MIT License (MIT). Please see [License](LICENSE) for more information.
