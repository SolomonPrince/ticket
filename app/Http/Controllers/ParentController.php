<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ParentController extends Controller
{
    
    public function sendResponse($result, $message, $code = 200)
    {
        return response()->json(["message" => $message, "data" => $result, "success" => true], $code);
    }

  
    public function sendError($error, $code = 404)
    {
        return response()->json(["message" => $error, "success" => false], $code);
    }

}