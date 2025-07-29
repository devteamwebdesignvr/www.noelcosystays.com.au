<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAway\HostAwayProperty;
use Helper;
use App\Helper\Upload;
use Validator;
use LiveCart;
use Carbon\Carbon;
use App\Models\Category;

class HostFullyPropertyController extends Controller{
    
    public function __construct(HostAwayProperty $model){
        $this->model=$model;
        $this->admin_base_url="host_away_properties.index";
        $this->admin_view="admin.host_fully_properties";
    }

    public function index(){
        $data=$this->model::orderBy("id","desc")->get();
        return view($this->admin_view.".index",compact("data"));
    }
    
    public function create(){
        return redirect()->route($this->admin_base_url);
    }

    public function store(Request $request){
        return redirect()->route($this->admin_base_url);
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
        $validator = Validator::make($request->all(), ['seo_url' => 'required|unique:host_away_properties,seo_url,'.$id]);  
        if($validator->fails()){
            return redirect()->back()->withInput()->with("danger",$validator->errors()->first())->withErrors($validator->errors());
        }
        $exist=$this->model::find($id);
        if($exist){
            $data=$request->all();
          
        if($request->collection_ids){
            $data['collection_ids']=json_encode($request->collection_ids);
        }else{
            $data['collection_ids']=json_encode([]);
        }
            if($request->hasFile("rental_aggrement_attachment")) {Helper::deleteFile($exist->rental_aggrement_attachment);$data['rental_aggrement_attachment'] = Upload::uploadWithLogoImageData($request->file("rental_aggrement_attachment"),"properties");}
            if($request->remove_rental_aggrement_attachment){$data['rental_aggrement_attachment'] ='';Helper::deleteFile($exist->rental_aggrement_attachment);}
            if($request->hasFile("banner_image")) {Helper::deleteFile($exist->banner_image);$data['banner_image'] = Upload::uploadWithLogoImageData($request->file("banner_image"),"properties");}
            if($request->hasFile("feature_image")) {$data['feature_image'] = Upload::uploadWithLogoImageData($request->file("feature_image"),"properties");}
            if($request->remove_banner_image){$data['banner_image'] ='';Helper::deleteFile($exist->banner_image);}
            $this->model::find($id)->update($data);
            return redirect()->route($this->admin_base_url)->with("success","Successfully Updated");
        }
        return redirect()->back()->with("danger","Invalid Calling");
    }

    public function destroy($id){
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }
}