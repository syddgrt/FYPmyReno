<?php

// app/Http/Controllers/GuideController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        // Retrieve the user's role
        $userRole = auth()->user()->role; // Assuming the role is stored in a column named 'role'

        // Return the view for the guides page with the user's role
        return view('guides.index', compact('userRole'));
    }

}
