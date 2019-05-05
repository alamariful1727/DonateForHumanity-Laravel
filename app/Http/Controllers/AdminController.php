<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\Campaigns;
use App\Transaction;
use DB;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (auth()->user()->type != 'admin') {
        //         return redirect('/')->with('error', 'Restricted page for user!!');
        //     }
        //     return $next($request);
        // });
    }
    public function index()
    {
        // dd(Carbon::now()->addDays(5)->toDateTimeString());
        // dd(date('d'));
        return view('admin.index');
    }
    public function getNewClients(Request $request)
    {
        if ($request->ajax()) {
            $date = '';
            $query = $request->get('query');
            switch ($query) {
                case '1m':
                    $date = Carbon::now()->subMonths(1)->toDateTimeString();
                    break;
                case '6m':
                    $date = Carbon::now()->subMonths(6)->toDateTimeString();
                    break;
                case '1y':
                    $date = Carbon::now()->subYears(1)->toDateTimeString();
                    break;
                default:
                    $date = Carbon::now()->subDays((int)$query)->toDateTimeString();
                    break;
            }

            $data = DB::table('users')
                ->whereDate('created_at', '>', $date)
                ->get();

            $total_row = $data->count();

            $data = array(
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }
    public function getNewBlogs(Request $request)
    {
        if ($request->ajax()) {
            $date = '';
            $query = $request->get('query');
            switch ($query) {
                case '1m':
                    $date = Carbon::now()->subMonths(1)->toDateTimeString();
                    break;
                case '6m':
                    $date = Carbon::now()->subMonths(6)->toDateTimeString();
                    break;
                case '1y':
                    $date = Carbon::now()->subYears(1)->toDateTimeString();
                    break;
                default:
                    $date = Carbon::now()->subDays((int)$query)->toDateTimeString();
                    break;
            }

            $data = DB::table('blogs')
                ->whereDate('blog_created_at', '>', $date)
                ->get();

            $total_row = $data->count();

            $data = array(
                'total_data' => $total_row,
                'data' => $data
            );
            echo json_encode($data);
        }
    }
    public function getNewCampaigns(Request $request)
    {
        if ($request->ajax()) {
            $date = '';
            $query = $request->get('query');
            switch ($query) {
                case '1m':
                    $date = Carbon::now()->subMonths(1)->toDateTimeString();
                    break;
                case '6m':
                    $date = Carbon::now()->subMonths(6)->toDateTimeString();
                    break;
                case '1y':
                    $date = Carbon::now()->subYears(1)->toDateTimeString();
                    break;
                default:
                    $date = Carbon::now()->subDays((int)$query)->toDateTimeString();
                    break;
            }

            $data = DB::table('campaigns')
                ->whereDate('c_created_at', '>', $date)
                ->get();

            $total_row = $data->count();

            $data = array(
                'total_data' => $total_row,
                'data' => $data
            );
            echo json_encode($data);
        }
    }
    public function getUserCount(Request $request)
    {
        if ($request->ajax()) {
            $admin = DB::select('select COUNT(type) AS count from users where type = ?', ['admin']);
            $user = DB::select('select COUNT(type) AS count from users where type = ?', ['user']);

            $data = array(
                'admin' => $admin[0]->count,
                'user' => $user[0]->count
            );
            echo json_encode($data);
        }
    }
    public function getPerDay(Request $request)
    {
        // dd(Carbon::parse($d[0]->bc, 'Asia/Dhaka')->englishDayOfWeek);//Saturday
        // dd(Carbon::parse($d[0]->bc, 'Asia/Dhaka')->shortEnglishDayOfWeek); //Sat
        // dd(Carbon::parse($d[0]->bc, 'Asia/Dhaka')->dayOfWeek);//6
        if ($request->ajax()) {
            $blogs = DB::select("SELECT blog_created_at AS bc FROM blogs");
            $users = DB::select("SELECT created_at AS uc FROM users");
            $campaigns = DB::select("SELECT c_created_at AS cc FROM campaigns");
            $blogsPerDay = array(
                "Sun" => 0, "Mon" => 0, "Tue" => 0,
                "Wed" => 0, "Thu" => 0, "Fri" => 0,
                "Sat" => 0
            );
            $usersPerDay = array(
                "Sun" => 0, "Mon" => 0, "Tue" => 0,
                "Wed" => 0, "Thu" => 0, "Fri" => 0,
                "Sat" => 0
            );
            $campaignsPerDay = array(
                "Sun" => 0, "Mon" => 0, "Tue" => 0,
                "Wed" => 0, "Thu" => 0, "Fri" => 0,
                "Sat" => 0
            );

            foreach ($blogs as $i) {
                $blogsPerDay[Carbon::parse($i->bc, 'Asia/Dhaka')->shortEnglishDayOfWeek]++;
            }
            foreach ($users as $i) {
                $usersPerDay[Carbon::parse($i->uc, 'Asia/Dhaka')->shortEnglishDayOfWeek]++;
            }
            foreach ($campaigns as $i) {
                $campaignsPerDay[Carbon::parse($i->cc, 'Asia/Dhaka')->shortEnglishDayOfWeek]++;
            }

            $data = array(
                'blogsPerDay' => $blogsPerDay,
                'campaignsPerDay' => $campaignsPerDay,
                'usersPerDay' => $usersPerDay
            );
            echo json_encode($data);
        }
    }
    // admin options ends


    // Dealing with users
    public function addUser()
    {
        return view('admin.addUser');
    }
    public function storeUser(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $url = Str::limit(Hash::make($request->password), 20);
        $url = join(" ", explode(" / ", $url));
        // create user
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->url = $url;
        $user->save();

        return redirect()->route('admin.userDetails')->with('success', 'New user created NAME: ' . $request->name);
    }
    public function userDetails()
    {
        return view('admin.userDetails');
    }
    public function getUsersInfo(Request $request)
    {
        // dd(Carbon::now()->subDays(10)->toDateTimeString());
        if ($request->ajax()) {
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('users')
                    ->where('name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('url', 'like', '%' . $query . '%')
                    ->orWhere('type', 'like', '%' . $query . '%')
                    ->orWhere('balance', 'like', '%' . $query . '%')
                    ->orWhere('created_at', 'like', '%' . $query . '%')
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $data = DB::table('users')
                    ->orderBy('id', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            $index = $total_row;
            $output = '';
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                        <th scope=" row ">' . $index-- . '</th>
                        <td>' . $row->name . '</td>
                        <td>' . $row->email . '</td>
                        <td>' . $row->balance . '</td>
                        <td>' . $row->description . '</td>
                        <td>' . $row->url . '</td>
                        <td>' . $row->type . '</td>
                        <td>' . $row->created_at . '</td>
                        <td>
                            <a class=" btn btn-info" href= "/admin/user-details/' . $row->id .  ' /editUser" role= "button" data-toggle= "">Edit</a>
                            <a class= "btn btn-danger" href = "/admin/user-details/' . $row->id .   '/deleteUser" role ="button" data-toggle ="">Delete</a>
                        </td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align ="center" colspan = "8">No data found!!</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }
    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.editUser')->with('user', $user);
    }
    public function updateUser(Request $request, $id)
    {
        // dd($request);
        $user = User::find($id);
        // check URL
        if ($user->url != trim($request->url)) {
            $this->validate($request, [
                'url' => 'required|max:30|min:5|unique:users'
            ]);
        }
        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            $this->validate($request, [
                'cover_image' => 'image|nullable|max:1999'
            ]);
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            // $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $fileNameToStore = $user->id . '__' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/user_images', $fileNameToStore);
        }
        //check others
        $this->validate($request, [
            'name' => 'required|max:191|min:4',
            'description' => 'required|max:191|min:10'
        ]);
        // update user
        $url = join("", explode("/", $request->url));
        $user = User::find($id);
        $user->name = $request->name;
        $user->description = $request->description;
        $user->url = $url;
        if ($request->hasFile('cover_image')) {
            $user->image = $fileNameToStore;
        }
        $user->save();

        return redirect()->route('admin.userDetails')->with('success', 'User ID:' . $id . ' has been updated.');
    }
    public function deleteUser($id)
    {
        // update Blog
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.userDetails')->with('success', 'User ID:' . $id . ' has been Deleted.');
    }
    // Dealing with users ENDS


    // Dealing with Blogs
    public function blogDetails()
    {
        return view('admin.blogDetails');
    }
    public function getBlogsInfo(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('blogs')
                    ->join('users', 'blogs.user_id', '=', 'users.id')
                    ->where('type', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('body', 'like', '%' . $query . '%')
                    ->orWhere('blog_created_at', 'like', '%' . $query . '%')
                    ->orWhere('blog_updated_at', 'like', '%' . $query . '%')
                    ->orderBy('bid', 'desc')
                    ->get();
            } else {
                $data = DB::table('blogs')
                    ->join('users', 'blogs.user_id', '=', 'users.id')
                    ->orderBy('bid', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            $index = $total_row;
            $output = '';
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                        <th scope ="row">' . $index-- . '</th>
                        <td>' . $row->type . '</td>
                        <td>' . $row->email . '</td>
                        <td>' . $row->body . '</td>
                        <td>' . $row->blog_created_at . '</td>
                        <td>' . $row->blog_updated_at . '</td>
                        <td>
                            <a class ="" href ="/admin/blog-details/' . $row->bid . '/editBlog"><i class="fas fa-edit text-info"></i></a>
                            <a class="" href="/admin/blog-details/' . $row->bid . '/deleteBlog"><i class="fas fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td ali gn="ce nter" colsp a n="7">No data found!!</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }
    public function editBlog($id)
    {
        $blog = Blog::find($id);
        return view('admin.editBlog')->with('blog', $blog);
    }
    public function updateBlog(Request $request, $id)
    {
        $this->validate($request, [
            'body' => 'required|max:191|min:10'
        ]);
        // update blog
        $user = Blog::find($id);
        $user->body = $request->body;
        $user->save();

        return redirect()->route('admin.blogDetails')->with('success', 'Blog ID:' . $id . ' has been updated.');
    }
    public function deleteBlog($id)
    {
        // delete Blog
        $blog = Blog::find($id);
        $blog->delete();
        return redirect()->route('admin.blogDetails')->with('success', 'Blog ID:' . $id . ' has been Deleted.');
    }
    // Dealing with campaigns
    public function campaignDetails()
    {
        return view('admin.campaignDetails');
    }
    public function getCampaignsInfo(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');

            if ($query != '') {
                $data = DB::table('campaigns')
                    ->join('users', 'campaigns.user_id', '=', 'users.id')
                    ->where('title', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhere('c_desc', 'like', '%' . $query . '%')
                    ->orWhere('c_budget', 'like', '%' . $query . '%')
                    ->orWhere('c_balance', 'like', '%' . $query . '%')
                    ->orWhere('duration', 'like', '%' . $query . '%')
                    ->orWhere('c_status', 'like', '%' . $query . '%')
                    ->orWhere('c_created_at', 'like', '%' . $query . '%')
                    ->orderBy('cid', 'desc')
                    ->get();
            } else {
                $data = DB::table('campaigns')
                    ->join('users', 'campaigns.user_id', '=', 'users.id')
                    ->orderBy('cid', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            $output = '';
            $index = $total_row;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                        <th scope ="row">' . $index-- . '</th>
                        <td>' . $row->title . '</td>
                        <td>' . $row->email . '</td>
                        <td>' . $row->c_desc . '</td>
                        <td>' . $row->c_budget . '</td>
                        <td>' . $row->c_balance . '</td>
                        <td>' . $row->duration . '</td>
                        <td>' . $row->c_status . '</td>
                        <td>' . $row->c_created_at . '</td>
                        <td>
                            <a class ="" href ="/admin/campaign-details/' . $row->cid . '/editCampaign"><i class="fas fa-edit text-info"></i></a>
                            <a class="" href="/admin/campaign-details/' . $row->cid . '/deleteCampaign"><i class="fas fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="10">No data found!!</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }
    public function addCampaign()
    {
        return view('admin.addCampaign');
    }
    public function storeCampaign(Request $request)
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
            $fileNameToStore = time() . '.' . $extension; //aaa_12229151.png
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

        return redirect()->route('admin.campaignDetails')->with('success', 'New campaign created Title: ' . $request->title);
    }
    public function editCampaign($id)
    {
        $campaign = Campaigns::find($id);
        return view('admin.editCampaign')->with('campaign', $campaign);
    }
    public function updateCampaign(Request $request, $id)
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

        return redirect()->route('admin.campaignDetails')->with('success', 'Campaign edited Title: ' . $request->title);
    }
    public function deleteCampaign($id)
    {
        // delete Campaign
        $campaign = Campaigns::find($id);
        $campaign->delete();
        return redirect()->route('admin.campaignDetails')->with('success', 'Campaign ID:' . $id . ' has been Deleted.');
    }
    // Dealing with campaigns ENDS


    // Dealing with requests
    public function campaignRequest($status)
    {
        $requests = Campaigns::where('c_status', $status)->get();
        return view('admin.campaignRequest')->with('requests', $requests);
    }
    public function campaignSetRequest($cid, $status)
    {
        $Campaign = Campaigns::find($cid);
        if ($status == 'active' && $Campaign->starts == 'TBA') {
            // Active a new campaign
            $Campaign->starts = Carbon::now()->toDateTimeString();
            $Campaign->ends = Carbon::now()->addDays($Campaign->duration)->toDateTimeString();
        } else if ($status == 'finish' && $Campaign->starts == 'TBA' && $Campaign->c_status == 'pending') {
            // wrong req
            return redirect()->route('admin.campaignRequest', ['pending']);
        } else if ($status == 'success' && $Campaign->starts == 'TBA' && $Campaign->c_status == 'pending') {
            // wrong req
            return redirect()->route('admin.campaignRequest', ['pending']);
        } else if ($status == 'active' && $Campaign->starts != 'TBA' && $Campaign->c_status == 'pending') {
            // Active a pending campaign
            $starts = Carbon::createFromFormat('Y-m-d H:i:s', $Campaign->starts);
            $Campaign->ends = $starts->addDays($Campaign->duration)->toDateTimeString();
        } else if ($status == 'active' && $Campaign->starts != 'TBA' && $Campaign->c_status == 'finish') {
            // Active a finishing campaign
            $starts = Carbon::createFromFormat('Y-m-d H:i:s', $Campaign->starts);
            $Campaign->ends = $starts->addDays($Campaign->duration)->toDateTimeString();
        } else if ($status == 'pending') {
            // Pending a campaign
            $Campaign->ends = 'TBA';
        } else if ($status == 'finish') {
            // Finishing a campaign
            $Campaign->ends = Carbon::now()->toDateTimeString();
        } else if ($status == 'success') {
            // successfully end a campaign
            $Campaign->ends = Carbon::now()->toDateTimeString();
        }
        $Campaign->c_status = $status;
        $Campaign->save();
        return redirect()->route('admin.campaignRequest', [$status]);
    }
    public function recharge()
    {
        $users = User::all();
        return view('admin.recharge')->with('users', $users);
    }
    public function rechargeStore(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|min:1|max:10000|integer'
        ]);
        $to = User::where('email', $request->email)->get();

        if (count($to) == 0) {
            return redirect()->route('admin.recharge')->with('error', "Please enter a valid User's email");
        }
        // create Transaction
        $t = new Transaction;
        $t->user_id = $to[0]->id;
        $t->from = auth()->user()->id;
        $t->amount = $request->amount;
        $t->save();
        $user = User::find($to[0]->id);
        $user->balance = $user->balance +  $request->amount;
        $user->save();

        return redirect()->back()->with('success', 'Amount: ' . $request->amount . ' has been recharged.');
    }
    public function transactionRequest()
    {
        $requests = Transaction::where('from', 0)->get();
        // dd($requests);
        return view('admin.transactionRequest')->with('requests', $requests);
    }
    public function rechargeAccept($tid, Request $request)
    {
        // accept
        $t = Transaction::find($tid);
        // dd($t->user_id);
        $t->from = auth()->user()->id;
        $user = User::find($t->user_id);
        $user->balance = $user->balance +  $t->amount;
        $t->save();
        $user->save();
        return redirect()->back()->with('success', 'Amount: ' . $request->amount . ' has been recharged.');
    }
    // Dealing with requests ENDS
}
