<?php

namespace App\Http\Controllers;

use App\Campaigns;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function show(Campaigns $campaigns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaigns $campaigns)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaigns $campaigns)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaigns $campaigns)
    {
        //
    }
}
