<?php

namespace App\Http\Controllers;
use App\Tag;
use App\Category;
use App\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function getTag(){
     // return Tag::all();
      //$date = Carbon::parse($value)->diffForHumans();
       
       return Tag::orderBy('id','desc')->get();
   }
    public function addTag(Request $request){
       //valideate request
       $this->validate($request ,[
            'tagName' => 'required'
       ]);
       return Tag::create([
        'tagName' => $request->tagName
       ]);
    }
    public function editTag(Request $request){
       //valideate request
       $this->validate($request ,[
            'id'      => 'required',
            'tagName' => 'required',
            
       ]);
       return Tag::where('id', $request->id)->update([
        'tagName' => $request->tagName
       ]);
    }
    public function deleteTag(Request $request){
      
       return Tag::where('id', $request->id)->delete();
    }
   

    public function upload( Request $request){
       $this->validate( $request, [
         'file' => 'required|mimes:jpeg,jpg,png'
       ]);
      $picName =time().'.'.$request->file->extension();
      $request->file->move(public_path('uploads'),$picName);
      return $picName;
    }
    public function deleteImage(Request $request){
      $fileName =$request->imageName;
      $this->deleteFileFromServer($fileName,false);
      return 'done';
    }
    public function deleteFileFromServer($fileName, $hasFullPath = false){
       if(!$hasFullPath ){
         $filePath =public_path().'/uploads/'.$fileName;
       }
       if(file_exists($filePath)){
          unlink($filePath);
       }
       return ;
    }
    public function addCategory(Request $request){
      $this->validate($request ,[
         'categoryName'   => 'required',
         'iconImage'      => 'required'
      ]);
      return Category::create([
      'categoryName' => $request->categoryName,
      'iconImage'    => $request->iconImage
      ]);
    }
    public function getCategory(){
      return Category::orderBy('id','desc')->get();
    }
    public function editCategory( Request $request){
      $this->validate($request ,[
         'id'           => 'required',
         'categoryName' => 'required',
         'iconImage'    => 'required'
         
    ]);
    return Category::where('id', $request->id)->update([
     'categoryName' => $request->categoryName,
     'iconImage'    => $request->iconImage
    ]);
    }
    public function deleteCategory(Request $request){
      //first Delete Ogiginal file from Dataserver
      $this->deleteFileFromServer($request->iconImage);
      //validate request
      $this->validate($request,[
         'id' =>'required'
      ]);
      return Category::where('id', $request->id)->delete();
   }

   public function createUser( Request $request){
      $this->validate($request,[
         'fullName' => 'required',
         'email'    => 'bail|required|email|unique:users',
         'password' => 'bail|required|min:6',
         'userType' => 'required'
      ]);
      $password = bcrypt($request->password);

      $user = User::create([
         'fullName'    => $request->fullName,
         'email'       => $request->email,
         'password'    => $password,
         'userType'    => $request->userType,
         ]);
      return $user;
   }
   public function getUser(){
      return User::where('userType','!=', 'User')->get();
   }

   public function editUser( Request $request){
      $this->validate($request,[
         'fullName' => 'required',
         'email'    => "bail|required|email|unique:users,email,$request->id",
         'password' => 'min:6',
         'userType' => 'required'
      ]);
      
      $editUserData =[
         'fullName'    => $request->fullName,
         'email'       => $request->email,
         'userType'    => $request->userType
    ];

    if($request->password){

      $password = bcrypt($request->password);
      $editUserData['password'] = $password;
    }
    $user =User::where('id',$request->id)->update($editUserData);
    return $user;
   }

   public function adminLogin( Request $request){
      $this->validate($request,[
         'email'    =>'bail|required|email',
         'password' =>'required'
      ]);
      if(Auth::attempt(['email'=> $request->email, 'password' => $request->password])){
        $user =Auth::user();
        if($user->userType == 'Editor'){
           Auth::logout();
           return response()->json([
               'msg' =>'Incorrect Login Details'
           ],401);
        }
         return response()->json([
            'msg' =>'You Are Logged in',
            'user'=> $user
         ]);
      }else{
         return response()->json([
            'msg' =>'Incorrect Login Details'
         ],401);
      }
   }
}
