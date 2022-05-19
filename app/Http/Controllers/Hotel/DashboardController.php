<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Guest;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'hotel-dashboard',
            'page_header' => 'Dashboard',
            'page_desc' => '',
            'guestList' => Guest::all(),
        ];
        return view('hotel.dashboard.index')->with(array_merge($this->data, $data));
    }
    
}
