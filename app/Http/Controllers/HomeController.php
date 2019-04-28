<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //main page
    public function index()
    {
        $title = "Donate for Humanity";
        return view('home.index')->with('title', $title);
    }
    //about page
    public function about()
    {
        $data = array(
            'title' => 'About Us',
            'body' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laborum sunt dignissimos ipsam aliquid porro quod, quis esse odio accusantium dolor deserunt culpa architecto veniam quisquam corrupti quaerat officia repellat dolorum?'
        );
        return view('home.index')->with($data);
    }
}
