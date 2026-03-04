<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class InstructivosController extends Controller
{
    public function index()
    {
        return view('admin.instructivos');
    }
}
