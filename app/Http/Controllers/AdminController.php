<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Blog;
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
                'total_data' => $total_row
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

            foreach ($blogs as $i) {
                $blogsPerDay[Carbon::parse($i->bc, 'Asia/Dhaka')->shortEnglishDayOfWeek]++;
            }
            foreach ($users as $i) {
                $usersPerDay[Carbon::parse($i->uc, 'Asia/Dhaka')->shortEnglishDayOfWeek]++;
            }

            $data = array(
                'blogsPerDay' => $blogsPerDay,
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
                        <th scope ="r ow">' . $index-- . '</th>
                        <td>' . $row->type . '</td>
                        <td>' . $row->email . '</td>
                        <td>' . $row->body . '</td>
                        <td>' . $row->blog_created_at . '</td>
                        <td>' . $row->blog_updated_at . '</td>
                        <td>
                            <a class ="btn  b tn-i nfo" hre f ="/ad m in/b l og-deta i ls/' . $row->bid  .  '/editB log" rol e="but ton" data-toggl e="">Edit</a>
                            <a clas s="btn   btn-da nger" hr e f="/a d min/ b log-det a ils/' . $row->bid   . '/delete Blog" ro le="bu tton" data-togg le="">Delete</a>
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
        // update Blog
        $blog = Blog::find($id);
        $blog->delete();
        return redirect()->route('admin.blogDetails')->with('success', 'Blog ID:' . $id . ' has been Deleted.');
    }
    // Dealing with Blogs ENDS
}
