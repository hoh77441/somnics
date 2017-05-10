<?php
require 'init.php';

initFramework();
return;

//initial laravel framework
require __DIR__.'/../bootstrap/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = Illuminate\Http\Request::capture());  //use Symfony\Component\HttpFoundation\Response;

//change default exception handler
new App\SomnicsApi\Exception\TExceptionHandler($app);

const KEY = 'monitor';
const FILE_NAME = 'name';
const ERROR = 'error';
const SOURCE = 'tmp_name';

if( $_FILES[KEY][ERROR] != UPLOAD_ERR_OK )
{
    echo 'error';
    return;
}

$fileName = basename($_FILES[KEY][FILE_NAME]);
$extension = pathinfo($fileName, PATHINFO_EXTENSION);
$file = $request->file(KEY);
if( $file->storeAs('/Users/admin/Documents/php/upload', $fileName) )
{
    echo 'upload success';
}
else
{
    echo 'upload fail';
}
/*if( move_uploaded_file($_FILES[KEY][SOURCE], '/Users/admin/Documents/php/somnics/storage/app/'.$fileName) )
{
    echo 'upload success';
}
else 
{
    echo 'fail';
}//*/

$kernel->terminate($request, $response);
