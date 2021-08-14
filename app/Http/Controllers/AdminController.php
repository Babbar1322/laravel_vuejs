<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Category;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request){
        // first we check that we are logged in and a admin user
        
        if(!Auth::check() && $request->path() != 'login'){
            return redirect("/login");
        }
        if(!Auth::check() && $request->path() == "login"){
            return view("welcome");
 
        }
       $user = Auth::user();
        if($user->userType == "User"){
            return redirect("/login");
        }
        if($request->path() == "login"){
            $user = User::count();
            return redirect("/dashboard")->with($user);
        }
       
        
        return view("welcome");
    }
    public function logout(){
        Auth::logout();
        return redirect("/login");
    }
    public function addTag(Request $request){
        $this->validate($request,[
            'tagName'=>'required'
        ]);
        
        return Tag::create([
            'tagName'=> $request->tagName
        ]);
    }

    public function getTags(){
        $tags = Tag::orderBy('id','desc')->get();
        return response()->json($tags);
    }
    public function editTag(Request $request){
        $this->validate($request,[
            'tagName'=>'required'
        ]);
        return Tag::where('id',$request->id)->update([
            'tagName'=> $request->tagName
        ]);
        
    }
    public function deleteTag(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        return Tag::where('id',$request->id)->delete();
        
    }

    public function upload(Request $request){
        // $this->validate($request,[
        //     'file'=> 'required|mimes:jpeg,png,jpg'
        // ]);
         $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'),$picName);
        return $picName;
    }

    public function deleteImage(Request $request){
        $fileName = $request->imageName;
         $this->deleteFileFromServer($fileName);
        return 'done';
    }

    public function deleteFileFromServer($fileName){
        $file_path = public_path().'/uploads/'.$fileName;
        if(file_exists($file_path)){
            @unlink($file_path);
        }
        return;
    }

    public function addCategory(Request $request){
        $this->validate($request,[
            'categoryName'=>'required',
            'iconImage'=>'required'
        ]);
        return Category::create([
            'categoryName'=>$request->categoryName,
            'iconImage'=> $request->iconImage
        ]);
    }

    public function getCategory(Request $request){
        $cats = Category::orderBy('id','desc')->get();
        return response()->json($cats);
    }
    public function editCategory(Request $request){
        $this->validate($request,[
            'categoryName'=>'required'
        ]);
        return Category::where('id',$request->id)->update([
            'categoryName'=> $request->categoryName,
            'iconImage'=>$request->iconImage
        ]);
    }

    public function deleteCategory(Request $request){
         $this->validate($request,[
            'id'=>'required'
        ]);
        $del = Category::where('id',$request->id)->delete();
        
    }

    public function createUser(Request $request){
        $this->validate($request,[
            "fullName" => "required",
            "email" => "bail|required|unique:users",
            "password" => "bail|required|min:6",
            "userType" => "required"
        ]);
       $user =  User::create([
            "fullName" => $request->fullName,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "userType" => $request->userType
        ]);
       
       
        return $user;
    }
    public function getUsers(){
        return User::where('userType','!=','Admin')->orderBy('id','desc')->get();
    }

    public function editUser(Request $request){
        $this->validate($request,[
            "fullName" => "required",
            "email" => "bail|required|unique:users,email,$request->id",
            "userType" => "required"
        ]);
        $user = User::where('id',$request->id)->update([
            "fullName" => $request->fullName,
            "email" => $request->email,
            "userType" => $request->userType
        ]);
        return $user;
    }

    public function adminLogin(Request $request){
        $this->validate($request,[
            "email"=>"required",
            "password"=>"required|min:6"
        ]);

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            if($user->userType == "User"){
                Auth::logout();
            }
            return response()->json(["msg"=>"you are logged in ", "user"=>$user]);
        }else{
            return response()->json(["msg"=>"Incorrect Login details"],401);

        }
    }

    public function register(Request $request){
        $this->validate($request,[
            "fullName" => "required",
            "email" => "bail|required|unique:users",
            "password" => "bail|required|min:6",
        ]);

        if($request->password == $request->confirm_password){
        $user =  User::create([
            "fullName" => $request->fullName,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "userType" => "User"
            
        ]);
        return response()->json(["msg"=>"successfully registerd","user"=>$user]);
    }
    else{
        return response()->json(["msg"=>"password does not match"],401);
    }
    }

    public function tagDetails(Request $request , $id){
        $tag = tag::findOrFail($id);
        return response()->json($tag);
    }

    public function addRole(Request $request){
        $this->validate($request,[
            'roleName'=>'required'
        ]);
        $role = Role::create([
            'roleName'=> $request->roleName
        ]);
        return $role;
    }
    public function updateRole(Request $request){
        $this->validate($request,[
            'roleName'=>'required'
        ]);
        $role = Role::where('id',$request->id)->update([
            'roleName'=> $request->roleName
        ]);
        return $role;
    }

    public function getRole(){
        $role =  Role::orderBy('id','desc')->get();
        return response()->json($role);
    }

    public function deleteRole(Request $request){
        $role = Role::where('id',$request->id)->delete();
        return $role;
    }
    public function deleteUser(Request $request){
        $this->validate($request,[
           'id'=>'required'
       ]);
       $del = User::where('id',$request->id)->delete();
   }

}
