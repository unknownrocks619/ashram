<?php

namespace App\Http\Controllers;

use App\Models\UserSewa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class SewasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        // dd(Auth::user());
        if( Auth::guard('admin')->check()  && Auth::guard('admin')->user()->user_type == "admin")
        {
            $page = "admin";
            $data['sewas'] = UserSewa::paginate();
        } 
        return view($page.".sewas.index",$data);
    }

    public function sewa_form(Request $request)
    {
        $data = [];
        if( $request->get('sewa_id') )
        {
            $sewa_detail = UserSewa::find($request->get('sewa_id'));
            $data['sewa'] = $sewa_detail;
        }

        if( Auth::guard('admin')->check() && Auth::guard('admin')->user()->user_type == "admin")
        {
            $page = "admin";
        }

        return view($page.".sewas.form",$data);

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
       $post = $request->post();
       $post['created_by_user'] = Auth::guard('admin')->user()->id;
       $post["slug"] = Str::slug($request->sewa_name, '-');

       $store_response = UserSewa::create($post);
        if ( $request->ajax() ){
            
            if ($store_response){
                return response()->json([
                    'success' => true,
                    'message' => 'New sewa inserted.'
                ]);
            } else {
                return response()->json([
                            'success'=>false,
                            'message' => "Oops ! Something went wrong. Please try again" 
                        ]);
            }
        } else {
            return back()->with('success','New Sewas Added.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SewaModel  $sewaModel
     * @return \Illuminate\Http\Response
     */
    public function show(SewaModel $sewaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SewaModel  $sewaModel
     * @return \Illuminate\Http\Response
     */
    public function edit(SewaModel $sewaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_sewa_service(Request $request)
    {
        //

        $sewaDetail = UserSewa::findOrFail(decrypt($request->__app_id));
        $sewaDetail->sewa_name = $request->sewa_name;
        $sewaDetail->description = $request->description;

        if( $sewaDetail->isDirty()){

            $sewaDetail->save();

            if( $request->ajax() )
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Sewa Detail Updated.'
                ]);
            } else{
                $request->session()->flash('success',"Sewa Detail Updated.");
                return back();
            }

        } else{
            if( $request->ajax() )
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Nothing to update.'
                ]);
            } else{
                $request->session()->flash('success',"Nothing to update.");
                return back();
            }
        }
    }


    public function destroy(Request $request)
    {
        if ($request->__app_id ){
            $sewaDetail = UserSewa::findOrFail(decrypt($request->__app_id));
            // now let's delete.

            $sewaDetail->delete();
            if ($request->ajax())
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully Deleted Sewa.'
                ]);
            } else{
                $request->session()->flash('success',"Selected Sewa was deleted.");
                return back();
            }
        }
        abort(404);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SewaModel  $sewaModel
     * @return \Illuminate\Http\Response
     */
    public function destroy_form(Request $request)
    {
        //
        if ($request->get('sewa_id')){
            
            $sewa_detail = UserSewa::findOrFail(decrypt($request->get('sewa_id')));
            $page = "";
            $data = [];
            if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->user_type == "admin"){
                $page = "admin";
            }
            $data["sewa"] = $sewa_detail;

            return view($page.'.sewas.delete',$data);

        }
        abort(404);
    }
}
