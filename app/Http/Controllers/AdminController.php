<?php

namespace App\Http\Controllers;
use App\Tag;
use App\Category;
use Carbon\Carbon;
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
      $this->deleteFileFromServer($fileName);
      return 'done';
    }
    public function deleteFileFromServer($fileName){
       $filePath =public_path().'/uploads/'.$fileName;
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
         'categoryName' => 'required'
         
    ]);
    return Tag::where('id', $request->id)->update([
     'categoryName' => $request->categoryName,
     'iconImage'    => $request->iconImage
    ]);
    }
    
}
