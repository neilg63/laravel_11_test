<?php
namespace App\Exceptions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Exceptions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundException extends Exceptions
{
    public function render(Request $request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Not Found'], 404);
            }
            return response()->view('404', [], 404);
        }
        return parent::render($request, $exception);
    }
}
