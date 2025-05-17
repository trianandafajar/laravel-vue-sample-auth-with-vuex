<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();

        if ($subjects->isEmpty()) {
            return $this->sendError('No subjects found', [], 404);
        }

        return $this->sendResponse($subjects, 'Successfully retrieved all subjects');
    }
}