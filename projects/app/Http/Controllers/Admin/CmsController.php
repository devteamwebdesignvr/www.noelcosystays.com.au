<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use App\Helper\Upload;
use Validator;
use Helper;

class CmsController extends Controller{
    
    public function __construct(Cms $model){
        $this->model=$model;
        $this->admin_base_url="cms.index";
        $this->admin_view="admin.cms";
    }
    
    public function index(){
        $data=$this->model::orderBy("id","desc")->get();
        return view($this->admin_view.".index",compact("data"));
    }
    
    public function create(){
        return view($this->admin_view.".create");
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), ['seo_url' => 'required|unique:cms,seo_url','name' => 'required']);   
        if($validator->fails()){
            return redirect()->back()->withInput()->with("danger",$validator->errors()->first())->withErrors($validator->errors());
        }
        $data=$request->all();
        if($request->hasFile("image")) {$data['image'] = Upload::fileUpload($request->file("image"),"cms");}
        if($request->hasFile("bannerImage")) {$data['bannerImage'] = Upload::fileUpload($request->file("bannerImage"),"cms");}
        $this->model::create($data);
        return redirect()->route($this->admin_base_url)->with("success","Successfully Added");
    }
  
    public function show($id){
        return redirect()->route($this->admin_base_url);
    }
   
    public function edit($id){
        $data=$this->model::find($id);
        if($data){
            return view($this->admin_view.".edit",compact("data"));
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }
  
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), ['seo_url' => 'required|unique:cms,seo_url,'.$id,'name' => 'required']);   
        if($validator->fails()){
            return redirect()->back()->withInput()->with("danger",$validator->errors()->first())->withErrors($validator->errors());
        }
        $exist=$this->model::find($id);
        if($exist){
            $data=$request->all();
            if($request->hasFile("image")) {$data['image'] = Upload::fileUpload($request->file("image"),"cms");}
            if($request->hasFile("bannerImage")) {$data['bannerImage'] = Upload::fileUpload($request->file("bannerImage"),"cms");}
            if($request->hasFile("image_2")) {$data['image_2'] = Upload::fileUpload($request->file("image_2"),"cms");}
            if($request->hasFile("image_3")) {$data['image_3'] = Upload::fileUpload($request->file("image_3"),"cms");}
            if($request->hasFile("faq_image")) {$data['faq_image'] = Upload::fileUpload($request->file("faq_image"),"cms");}
            if($request->hasFile("strip_image")) {$data['strip_image'] = Upload::fileUpload($request->file("strip_image"),"cms");}
            if($request->hasFile("about_image1")) {$data['about_image1'] = Upload::fileUpload($request->file("about_image1"),"cms");}
            if($request->hasFile("about_image2")) {$data['about_image2'] = Upload::fileUpload($request->file("about_image2"),"cms");}
            if($request->hasFile("owner_image")) {$data['owner_image'] = Upload::fileUpload($request->file("owner_image"),"cms");}
            $this->model::find($id)->update($data);
            return redirect()->route($this->admin_base_url)->with("success","Successfully Updated");
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }

    public function destroy($id){
        $exist=$this->model::find($id);
        if($exist){
            Helper::deleteFile($exist->image);
            Helper::deleteFile($exist->image2);
            Helper::deleteFile($exist->bannerImage);
            $exist->delete();
            return redirect()->route($this->admin_base_url)->with("success","Successfully Deleted");
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }
}