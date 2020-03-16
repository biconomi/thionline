<?php

namespace App\Http\Controllers\thionline\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Laratrust;
use App\User;
use DB;
use Helper;
use Auth;
use App\permission_user;
use Illuminate\Support\Facades\Hash;
class userController extends Controller
{
    public function user_list()
    {
        // for($i=200000;$i<210000;$i++)
        // {
        //     $users=new User();
        //     $users->name='demo';       
        //     $users->email=$i.'@gmail.com';
        //     $users->password=bcrypt('123456'); 
        //     $users->updated_at='2020-02-10 09:33:02';
        //     $users->updated_at='2020-02-10 09:33:02';
        //     $users->save();

        // } 

        
        // $array['data']=  Helper::getUserlogin(Auth::user()->id);
        // $array['data2']=['demo'=>'hahaha'];        
        return view('backend.thionline.user.user_list');  
    }
    public function user_detail()
    {
        $profile_user=DB::table('users')
                    ->join('provinces', 'users.pr_id', '=', 'provinces.pr_id')
                    ->join('district', 'users.id_dis', '=', 'district.id_dis')
                    ->join('wards', 'users.wa_id', '=', 'wards.wa_id')
                    ->where('id','=',Auth::user()->id)
                    ->first();
        $permission=DB::table('permissions')->get();
        $provinces=DB::table('provinces')->get();     
        return view('backend.thionline.user.user_detail')
                ->with('profile_user',$profile_user)
                ->with('provinces',$provinces); 
    }
    public function user_detail_store(Request $request)
    {
        $user = Auth::user();
        $user->phone=$request->txt_phone;
        if(!empty($request->input('txt_pass')))
        {
            $user->password=Hash::make($request->input('txt_pass'));
        }

        if($request->hasFile('txt_file'))//neu co file
        {
            $inputimg=$request->txt_file;
            $type_inputing=$inputimg->getClientOriginalExtension();

            $name_img=rand().time().'.'.$type_inputing;
            if(file_exists('adminlte/upload/avartar/'.$user->img))
            {   
                //return 'ton tai';             
                \File::delete('adminlte/upload/avartar/'.$user->img); 
            }
            $inputimg->move('adminlte/upload/avartar/',$name_img);
            $user->img=$name_img; 
        }           
        $user->save();      
        return redirect()->route('users.detail')->with('message','true');
    }  

    public function handling_ajax_user()//ajax load list user toàn bộ
    {        
        $users = DB::table('users')
                ->join('provinces', 'users.pr_id', '=', 'provinces.pr_id')
                ->join('district', 'users.id_dis', '=', 'district.id_dis')
                ->select( 'users.id','users.name','users.sex','users.email','users.phone','users.created_at','users.status','users.img','district.dis_name');

            return DataTables::of($users)
                    ->setRowId(function ($users) {
                        return $users->id;
                    })
                    ->addColumn('sex', function ($users) {
                        return $users->sex== 0 ? 'Nam' : 'Nữ';
                    })
                    ->addColumn('created_at', function ($users) {
                        return Helper::diffForHumans($users->created_at);
                    })
                    ->addColumn('status', function ($users) {
                        return $users->status== 1 ? '<small class="badge badge-success">Enabled</small>' : '<small class="badge badge-danger">Disabled</small>';
                    })
                    ->addColumn('img', function ($users) {
                        return '<img class="direct-chat-img" src='.url('adminlte/upload/avartar/'.$users->img).' alt="message user image">';
                    })

                    ->addColumn('action', function ($users) {
                        return '
                        <spam class="btn btn-outline-primary"  id="btn-edit-user" onclick= "load_profile('.$users->id.')"><i class="fa fa-edit"></i></spam>
                        <a href="#" class="btn btn-outline-danger"  id="btn_permission" onclick="permission();"><i class="fa fa-cog text-warning"></i></a>
                        <a href="#" class="btn btn-outline-danger"  id="" onclick="show_profile('.$users->id.')"><i class="fa fa-eye"></i></i></a>
                        <a href="#" class="btn btn-outline-primary"  id=""><i class="fa fa-trash text-danger"></i></a>                        
                        ';
                    })
             ->rawColumns(['action','sex','status','img','created_at'])
            ->toJson();
    }
    public function user_add()
    {
        $provinces=DB::table('provinces')->get();
        return view('backend.thionline.user.user_add')->with('provinces',$provinces);  
    }
    public function store_user(Request $request)
    {
       
        try
        {
            $number=$this->check_email_exist($request->input('email'));
            if($number>0)
            {
                return redirect()->route('users.add')->with('message','false');
            }
            else
            {
                $user_create=new User();
                $user_create->name=$request->input('txt_name');
                $user_create->sex=$request->input('txt_sex');
                $user_create->phone=$request->input('txt_phone');
                $user_create->pr_id=$request->input('txt_provinces');
                $user_create->id_dis=$request->input('txt_district');
                $user_create->wa_id=$request->input('txt_wards');
                $user_create->address=$request->input('txt_address');

                if($request->hasFile('txt_file'))
                {
                    $inputimg=$request->txt_file;
                    $type_inputing=$inputimg->getClientOriginalExtension();
                    $name_img=rand().time().'.'.$type_inputing;
                        $inputimg->move('adminlte/upload/avartar/',$name_img);
                        $user_create->img=$name_img;

                }
                $user_create->status=1;
                $user_create->email=$request->input('email');
                $user_create->password=Hash::make($request->input('txt_pass'));
                $user_create->save();
                return redirect()->route('users.add')->with('message','true');
            }

        }
        catch(Exception $e)
        {

        }
        
    }
    public function hadding_user(Request $requests)//xu ly cac yeu cau ajjax cua from usser
    {
        switch ($requests->hadding) 
        {
            case 'checkemail'://check email cos ton tai
                    $number=$this->check_email_exist($requests->email);
                    if($number>0)
                    {
                        return '1';
                    }
                    else
                    {
                        return '0';
                    }
                break;
            case 'onchang_tinh'://thay doi tinh load lai huyen
                    $district=DB::table('district')->where('pr_id',$requests->id_province)->get();
                    return $district;
                break;
            case 'onchang_huyen'://thay doi huyen load lai xa, khoong co ham load tinh vi load ngay từ đầu
                    $wards=DB::table('wards')->where('id_dis',$requests->id_district)->get();
                    return $wards;
                break;

            case 'load_profile_id'://Load profile user theo id đc gui qua tra ve 1 cai view profile
                    $profile_user=DB::table('users')
                                    ->join('provinces', 'users.pr_id', '=', 'provinces.pr_id')
                                    ->join('district', 'users.id_dis', '=', 'district.id_dis')
                                    ->join('wards', 'users.wa_id', '=', 'wards.wa_id')
                                    ->where('id','=',$requests->id_user)
                                    ->first();
                    $permission=DB::table('permissions')->get();
                    $permission_user=DB::table('permission_user')->where('user_id','=',$requests->id_user)->get();
                    $provinces=DB::table('provinces')->get();

                    return view('backend.thionline.user.user_profile')
                            ->with('profile_user',$profile_user)
                            ->with('permission',$permission)
                            ->with('permission_user',$permission_user)
                            ->with('provinces',$provinces);  
                    break;
                    
            case 'update_permission'://thay doi huyen load lai xa, khoong co ham load tinh vi load ngay từ đầu
                    $id_permission=explode(',',$requests->id_permission);
                    DB::table('permission_user')->where('user_id', '=', $requests->id_user)->delete();
                    for($i=0;$i<count($id_permission)-1;$i++)
                    {
                        $permission_user =new permission_user();
                        $permission_user->permission_id=$id_permission[$i];
                        $permission_user->user_id=$requests->id_user;
                        $permission_user->save();
                    }
                    //return $id_permission;
                    // return count($id_permission);
                    return 'true';
                 break;
    
                
            default:
                # code...
                break;
        }
    }
    public function check_user_exist($Value_id)
    {
        $numberuser=count(DB::table('users')->where('id','=',$Value_id)->get());
        return $numberuser;
    }
    public function check_email_exist($Value_email)
    {
        $numbermail=count(DB::table('users')->where('email','=',$Value_email)->get());
        return $numbermail;
    }
}