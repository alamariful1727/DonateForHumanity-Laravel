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
        $data = Campaigns::orderBy('c_created_at', 'desc')->paginate(10);
        return view('campaign.index')->with('campaigns', $data);
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
        $this->validate($request, [
            'title' => ['required', 'string', 'max:191', 'unique:campaigns'],
            'c_desc' => ['required', 'string', 'min:5', 'max:191'],
            'c_budget' => ['required', 'integer', 'min:100'],
            'duration' => ['required', 'integer', 'min:3', 'max:30'],
            'cover_image' => 'image|required|max:1000'
        ]);
        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName(); //aaa.png
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); //aaa
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension(); //png
            // Filename to store
            $fileNameToStore =  time() . '.' . $extension; //aaa_12229151.png
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/campaign_images', $fileNameToStore);
        }

        $url = join("-", explode(" ", $request->title)); //health-care

        // create Campaign
        $Campaign = new Campaigns;
        $Campaign->user_id = auth()->user()->id;
        $Campaign->title = $request->title;
        $Campaign->c_desc = $request->c_desc;
        $Campaign->c_image = $fileNameToStore;
        $Campaign->c_budget = $request->c_budget;
        $Campaign->c_balance = 0;
        $Campaign->duration = $request->duration;
        $Campaign->c_url = $url;
        $Campaign->save();

        return redirect()->route('campaign.index')->with('success', 'New campaign created Title: ' . $request->title);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $data = Campaigns::where('c_url', $url)->get();
        return view('campaign.show')->with('campaign', $data[0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Campaigns::find($id);
        return view('campaign.edit')->with('campaign', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'c_desc' => ['required', 'string', 'min:5', 'max:191'],
            'c_budget' => ['required', 'integer', 'min:100'],
            'duration' => ['required', 'integer', 'min:3', 'max:30'],
            'cover_image' => 'image|nullable|max:1000'
        ]);

        // create Campaign
        $Campaign = Campaigns::find($id);
        // if title changed
        if ($request->title != $Campaign->title) {
            $this->validate($request, [
                'title' => ['required', 'string', 'min:5', 'max:191', 'unique:campaigns']
            ]);
        }

        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName(); //aaa.png
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); //aaa
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension(); //png
            // Filename to store
            $fileNameToStore = time() . '.' . $extension; //aaa_12229151.png
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/campaign_images', $fileNameToStore);
        }

        $Campaign->title = $request->title;
        $Campaign->c_desc = $request->c_desc;
        if ($request->hasFile('cover_image')) {
            $Campaign->c_image = $fileNameToStore;
        }
        $Campaign->c_budget = $request->c_budget;
        $Campaign->duration = $request->duration;
        $Campaign->save();

        return redirect()->route('campaign.show', [$Campaign->c_url])->with('success', 'Campaign edited Title: ' . $request->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->type == 'admin') {
            $campaign = Campaigns::find($id);
            $campaign->delete();
            return redirect()->route('campaign.index')->with('success', 'Campaign Title:' . $campaign->title . '. has been Deleted.');
        }
        return redirect()->route('campaign.index')->with('error', 'Unauthorized attempt.');
    }
}
