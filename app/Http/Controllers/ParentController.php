<?php

namespace App\Http\Controllers;

use App\Services\ParentService;
use Illuminate\Http\Request;

/**
 * Class ParentController
 * @package App\Http\Controllers
 */
class ParentController extends Controller
{

    /**
     * @param Request $request
     * @param ParentService $parentService
     * get all list from difference sourses 
     */
    public function index(Request $request, ParentService $parentService)
    {
        // get all data from request
        $request = $request->all();
        // get all parents 
        $data = $parentService->getAllParents($request);
        // return result data
        return response()->json($data);
    }
}
