<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Modeernize an Aging PHP App

From the good folks at [Tighten Co.](https://tighten.co), see [this blog](https://tighten.co/blog/converting-a-legacy-app-to-laravel/) from [Andrew Morgan](https://tighten.co/authors/andrew-morgan)

This repo will implement the process of modernizing an old php application using [Laravel 8.x](https://laravel.com/docs/8.x).

For another approach see [Modernizing Legacy Applications in PHP](https://leanpub.com/mlaphp) by Paul M. Jones

See a presentation titled [It Was Like That When I Got Here: Steps Toward Modernizing a Legacy Codebase
](https://www.youtube.com/watch?v=65NrzJ_5j58) on this approach from a talk by Paul given at [#phpworld](https://www.youtube.com/hashtag/phpworld) 2014.

You can purchase Paul's book [here](https://leanpub.com/mlaphp) and [here](https://www.amazon.com/Modernizing-Legacy-Applications-Paul-Jones/dp/131210063X).

# Initial setup to Modernize an Aging PHP App


Create a new laravel app.
Create a new subdir `legacy` in the new laravel app root.

Update routes/web.php:

  * Add a legacy catch-all route to your Laravel app, at the bottom of routes/web.php
  * Import LegacyController

Your routes/web.php should look like this:

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegacyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('{path}', [LegacyController::class, 'index'])->where('path', '.*');
```

Create the LegacyController with an index method.
Your LegacyController should look like this:

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LegacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ob_start();
        require app_path('Http') . '/legacy.php';
        $output = ob_get_clean();

        // be sure to import Illuminate\Http\Response
        return new Response($output);
    }
}
```

Create file app/Http/legacy.php with contents:

```
<?php

// This is assuming the entry point to the legacy app is at `legacy/index.php`
require __DIR__.'/../../legacy/index.php';
```

Create a test version of legacy/index.php with content:

```
<?php

$request_uri = $_SERVER['REQUEST_URI'] ?? '';
echo "Hello from the old legacy app. Looking for {$request_uri} by any chance?";
```

Open your browser to the new laravel app and confirm that you can see something like:

```
Hello from the old legacy app. Looking for / by any chance?
```

If all is well, copy the old legacy application into the `legacy` subdirectory and begin your modernization.

You will need to address these issues:

* PHP Superglobals
* Global Variables
* CSRF Tokens
* Migrating to Eloquent
* Gathering the Database Code
* Stopping Execution Early
* Laravel Views
* Generating Database Migrations
* Helper Methods
* Legacy Path Helper
* Converting Native PHP Sessions

All are discussed in [Legacy to Laravel: How to Modernize an Aging PHP Application](https://tighten.co/blog/converting-a-legacy-app-to-laravel/) from [Andrew Morgan](https://tighten.co/authors/andrew-morgan)
