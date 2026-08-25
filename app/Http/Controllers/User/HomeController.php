<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function Index()
    {
        return view('user.pages.index');
    }

    public function Landing()
    {
        return view('user.pages.landing');
    }

    public function JobListings()
    {
        return view('user.pages.jobs.listings');
    }

    public function JobDetails()
    {
        return view('user.pages.jobs.job-details');
    }

    public function About()
    {
        return view('user.pages.about');
    }

    public function Contact()
    {
        return view('user.pages.contact');
    }

    public function Pricing()
    {
        return view('user.pages.pricing');
    }


}
