<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\userLoginRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\userDetail;
use App\Models\UserLogin;
use App\Models\UserTypes;
use App\Models\UserVerification;
use App\Models\userMedia;
use App\Models\userReference;
use App\Models\UserSewaBridge;

class UserController extends Controller
{

    protected $redirectTo = '/';



    public function get_user_list(Request $request)
    {
        $getResponse = userDetail::select('id','first_name','middle_name','last_name','phone_number','pet_name');

        if ($request->get('q'))
        {
            $getResponse->where('first_name','LIKE','%'.$request->get('q').'%');
            $getResponse->orWhere('middle_name','LIKE','%'.$request->get('q').'%');
            $getResponse->orWhere('last_name','LIKE','%'.$request->get('q').'%');
            $getResponse->orWhere('phone_number','LIKE','%'.$request->get('q').'%');
            $getResponse->orWhere('pet_name','LIKE','%'.$request->get('q').'%');
        }
        $response = ['results'=>[]];
        foreach ($getResponse->get() as $list_response)
        {
            $innerArray = [];
            $innerArray['id'] = $list_response->id;
            $arrange = $list_response->first_name;
            if($list_response->middle_name)
            {
                $arrange .= " ";
                $arrange .= $list_response->last_name;
            }
            $arrange .= " (";
            $arrange .= $list_response->phone_number . ")";
            $innerArray['text'] = $arrange;
            $response['results'][] = $innerArray;
        }
        return response($response);
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
        //
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
     * @param  \App\Models\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function show(userDetail $userDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(userDetail $userDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, userDetail $userDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(userDetail $userDetail)
    {
        //
    }



    /**
     * just verify login post with db
     */
    public function verify_login_post(userLoginRequest $request)
    {

        // now let's autheticate
        // $credentials = ['email']
        if(Auth::guard('admin')->attempt(
                [
                    'email'=>$request->email_address,
                    'password'=>$request->password,
                    'user_type' => $request->route
                ]
            )
         ){

             $request->session()->regenerate();
            return redirect()->intended(route('admin.admin_dashboard'));
        }
        return back()->withErrors(['email'=>"Credentials do not match our records."]);

    }

    // Admin Setup

    /**
     * Show login form for users / admin
     * 
     * @param \Illuminate\Http\Response
     */
    public function ad_login(Request $request)
    {

        if (Str::contains($request->route()->getPrefix(),"admin")){
            $prefix = "admin";
        }  else{
            $prefix = "user";
        }
        return $this->template('users/login',['route'=>$request->route()->getPrefix(),'route'=>$prefix],$prefix);
    }

    /**
     * Show user registration form
     * 
     * @param \Illuminate\Http\Response
     * 
     */
    public function new_user(Request $request)
    {
        // dd(Auth::guard('admin'));
        $user_type = UserTypes::get();
        $data['user_types'] = $user_type;
        if (Auth::guard("admin")->check())
        {
            if ($request->get('step') && $request->get('step') == "two")
            {
                $page = 'register-step-2';
                $user_id = $request->get('user_id');

                if (! $user_id )
                {
                    dd("Invalid Request");                    
                }
                $user_detail = userDetail::find(decrypt($request->get('user_id')));
                $data['user_detail'] = $user_detail;
            } else if ($request->get('step') && $request->get('step') == "three") {
                $page = "register-step-3";
                $data["user_detail"] = userDetail::findOrFail(decrypt($request->get('user_id')));
            } else if($request->get('step') && $request->get('step') === 'four') {
                $page = "register-step-4";
                $data['user_detail'] = userDetail::findOrFail(decrypt($request->get('user_id')));
            } else{
                $page = 'register';
            }

            return view('admin.users.'.$page,$data);
        }
    }

    public function submit_registration(Request $request)
    {
        
        $db_post_request = $request->post();

        if (Auth::guard('admin')->check() )
        {
            $db_post_request['created_by_user'] = Auth::guard('admin')->user()->id;
        }

        $userController = new userDetail;
        // dd($db_post_request);
        $createRecord = $userController->create($db_post_request);
        if($createRecord )
        {
            // current id;
            $user_inserted_id = $createRecord->id;


            // dd($createRecord->id);
            if($db_post_request['email'])
            {
                $userLogin = new userLogin;
                $user_login_instance['email'] = $db_post_request["email"];
                $user_login_instance['password'] = Hash::make(Str::random(8));;
                $user_login_instance['account_status'] = "Hold";
                $user_login_instance['created_by_user'] = Auth::guard('admin')->user()->id;
                $user_login_instance['user_detail_id'] = $user_inserted_id;
                $userLogin->create($user_login_instance);
            }

            // act according to user entry type.
            if (Auth::guard('admin')->check() )
            {
                return redirect()->route('admin.users.new_user_registration',['step'=>"two",'user_id'=>encrypt($user_inserted_id)]);
            }
        }

    }

    public function submit_user_verification(Request $request)
    {
        $userDetail = UserDetail::findOrFail(decrypt($request->get('user_id')));

        if ($request->pet_name)
        {
            $userDetail->pet_name = $request->pet_name;
            $userDetail->save();
        }
        $post_content = $request->post();
        $path = ($request->file('document_file')->store('avatars'));
        $file = $request->file('document_file');
        $file_detail = [
            "path" => $path,
            'orignal_name' => $file->getClientOriginalName(),
            'extension' => $file->extension(),
        ];
        $post_content["document_file_detail"] = json_encode($file_detail);
        $post_content['user_detail_id'] = $userDetail->id;
        $post_content['verification_type'] = $request->document_type;

        if ( $request->post('gaurdian_search') )
        {
            // let's get user detail from search.
            $gaurdianSearch = UserDetail::findOrFail($request->post('gaurdian_search'));

            $full_name = $gaurdianSearch->first_name;
            if($gaurdianSearch->middle_name){
                $full_name .= " ";
                $full_name .= $gaurdianSearch->middle_name;
            }
            $full_name .= " ";
            $full_name .= $gaurdianSearch->last_name;

            $post_content['parent_name'] = $full_name;
            $post_content['parent_phone'] = $gaurdianSearch->phone_number;
            $post_content['parent_id'] = $gaurdianSearch->id;
        } else {
            $post_content['parent_name'] = $request->post('gaurdian_name');
            $post_content['parent_phone'] = $request->gaurdian_phone;
    
        }

        if (Auth::guard('admin')->check() )
        {
            $post_content['created_by_user'] = Auth::guard('admin')->user()->id;
            $post_content["verified"] = true;
        }

        // $verificationModel = new 
        UserVerification::create($post_content);

        // act according to user entry type.
        if (Auth::guard('admin')->check() )
        {
            return redirect()->route('admin.users.new_user_registration',['step'=>"three",'user_id'=>encrypt($userDetail->id)]);
        }
    }

    public function store_webcam_upload(Request $request)
    {
        $user_detail = userDetail::find(decrypt($request->user_id));

        // let's search current active and change it to null;
        $currentActiveMedia = userMedia::where(['user_detail_id'=>$user_detail->id,'active'=>true])->first();
        if ($currentActiveMedia != null)
        {
            $currentActiveMedia->active = false;
            $currentActiveMedia->save();
        }

        // let's create new one.
        $db_post = [
            'created_by_user' => Auth::guard('admin')->user()->id,
            'user_detail_id' => $user_detail->id,
            'active' => true,
        ];

        // let's upload first.

        if ($request->file('webcam')->isValid()){

            // dd($request->file('webcam')->path());
            $path = Storage::putFile('profiles',$request->file('webcam')->path());
            $db_post['image_url'] = $path;
            $image_property = [
                "orignam_name" => $request->webcam->getClientOriginalName(),
                'extension' => $request->webcam->extension(),
                'hash_name' => $request->webcam->hashName()
            ];
            $db_post["image_property"] = json_encode($image_property);

            $new_media  = userMedia::create($db_post);

            if ($new_media->id)
            {
                return response()->json([
                    'error' => false,
                    'message' => "Snapshot was saved successfully. Please wait while you are redirect.",
                    'redirection' => url("admin/register"). "?step=four&user_id=".encrypt($user_detail->id)
                ]);
                // return redirect()->route('users.new_user_registration',['step'=>"four",'user_id'=>encrypt($user_detail->id)]);
            }
        }
    }

    public function save_sewa_reference(Request $request)
    {
        
        $user_detail = userDetail::findOrFail(decrypt($request->user_id));
        // user refernces content.
        $post_record = $request->post();
        
        if(Auth::guard('admin')->check()){
            $post_record['created_by_user'] = Auth::guard('admin')->user()->id;
        }
        $post_record["user_detail_id"] = decrypt($request->user_id);

        // check if reference is given in number or string.

        // also let's check if this user already entereed.

        $reference_detail = userReference::where('user_detail_id',$user_detail->id)->get()->first();

        if ( ! $refered_user_detail ):
            
            if ((int) $request->refered_by_person) {
                // let's search this user and get its detail.

                $refered_user_detail = userDetail::findOrFail($request->refered_by_person);
                $post_record["name"] = $refered_user_detail->full_name();
                $post_record['phone_number'] = $refered_user_detail->phone_number;
                $post_record['user_referer_id'] = $refered_user_detail->id;
            } else {
                $post_record['name'] = $request->refered_by_person;
            }
            
            if ( (int) $request->refered_branch_id ){
                $post_record["center_id"] = $request->refered_branch_id;
            }

            userReference::create($post_record);
        endif;
        

        if ( ! empty ($request->interested_sewa) ) 
        {
            $insert_bulk = [];
            foreach ( $request->interested_sewa as $list_sewa ) 
            {
                $innerArray = [];
                if (Auth::guard('admin')->check() ) {
                    $innerArray["created_by_user"] = Auth::guard('admin')->user()->id;
                }
                $innerArray['user_sewas_id'] = $list_sewa;
                $innerArray['user_involvement'] = 'sewa_interested';
                $innerArray['user_id'] = $user_detail->id;
                $insert_bulk[] = $innerArray;
                UserSewaBridge::create($innerArray);
            }
        }

        // now redirect user to either to provide login detail or book a room.
        $request->session()->flash('success','New User Record has been created.');
        return redirect()->route('user-list');

    }
}   
