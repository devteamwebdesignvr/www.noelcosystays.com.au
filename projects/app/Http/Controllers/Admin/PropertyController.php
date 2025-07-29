<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyGallery;
use App\Models\PropertyAmenityGroup;
use App\Models\PropertyAmenity;
use App\Models\PropertyFee;
use App\Models\PropertySpace;
use App\Models\PropertyRate;
use App\Models\PropertyRateGroup;
use App\Models\PropertyRoom;
use App\Models\BookingRequest;
use Helper;
use App\Helper\Upload;
use Validator;
use LiveCart;
use Carbon\Carbon;

class PropertyController extends Controller{
    
    public function __construct(Property $model){
        $this->model=$model;
        $this->admin_base_url="properties.index";
        $this->admin_view="admin.properties";
    }
  
    public function active($id){
        $data=$this->model::find($id);
        if($data){
            $data->status="true";
            $data->save();
            return redirect()->route($this->admin_base_url)->with("success","Successfully active");
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }
  
    public function deactive($id){
        $data=$this->model::find($id);
        if($data){
            $data->status="false";
            $data->save();
            return redirect()->route($this->admin_base_url)->with("success","Successfully deactive");
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }
    
    public function updateCaptionSOrt(Request $request){
        foreach($request->captionidsarray as $key=>$value){
            if(isset($value['id'])){
                $data=PropertyGallery::find($value['id']);
                if($data){
                    $data->sorting=$key;
                    if(isset($value['value']))
                    $data->caption=$value['value'];

                    $data->save();
                }
            }
        }
        echo "successfully update gallery";
    }
  
    public function copyData($id){
        $data=$this->model::find($id);
        if($data){
            $newPost = $data->replicate();
            $seo_url=$data->seo_url.'-'.uniqid().'-copy';
            $newPost->seo_url=$seo_url;
            $newPost->created_at = Carbon::now();
            $result=$newPost->save();
            if($result){
                $property=Property::where("seo_url",$seo_url)->first();
                $id1=$property->id;
                LiveCart::getFileIcalFileData($id1);
                $data=PropertyGallery::where("property_id",$id)->get();
                foreach($data as $c){
                    $asset=['image' =>$c->image,'property_id'=>$id1,'status'=>$c->status,'sorting'=>$c->sorting,'caption'=>$c->caption];
                    PropertyGallery::create($asset);
                }
                foreach(PropertyAmenityGroup::where("property_id",$id)->get() as $c){
                    $am_group=PropertyAmenityGroup::create(["property_id"=>$id1,"status"=>$c->status,"name"=>$c->name,"image"=>$c->image,"sorting"=>$c->sorting]);
                    foreach(PropertyAmenity::where("property_amenity_id",$c->id)->get() as $c1){
                        PropertyAmenity::create(["property_amenity_id"=>$am_group->id,"name"=>$c1->name,"status"=>$c1->status,"image"=>$c1->image,"sorting"=>$c1->sorting]);
                    }
                }
            }
            return redirect()->route($this->admin_base_url)->with("success","Successfully Coppied");
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }
    
    public function index(){
        return redirect('admin/host_away_properties');
        $data=$this->model::orderBy("id","desc")->get();
        return view($this->admin_view.".index",compact("data"));
    }
    
    public function create(){
        return view($this->admin_view.".create");
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), ['seo_url' => 'required|unique:properties,seo_url','name' => 'required']);   
        if($validator->fails()){
            return redirect()->back()->withInput()->with("danger",$validator->errors()->first())->withErrors($validator->errors());
        }
        $data=$request->all();
        if($request->hasFile("banner_image")) {$data['banner_image'] = Upload::fileUpload($request->file("banner_image"),"properties");}
        if($request->hasFile("feature_image")) {$data['feature_image'] = Upload::uploadWithLogoImageData($request->file("feature_image"),"properties");}
        if($request->hasFile("welcome_package_attachment")) {$data['welcome_package_attachment'] = Upload::uploadWithLogoImageData($request->file("welcome_package_attachment"),"properties");}
        if($request->hasFile("rental_aggrement_attachment")) {$data['rental_aggrement_attachment'] = Upload::uploadWithLogoImageData($request->file("rental_aggrement_attachment"),"properties");}
        $result=$this->model::create($data);
        if($result){
            $id=$result->id;
            LiveCart::getFileIcalFileData($id);
             if($request->file("images")){
                foreach($request->file("images") as $key1=>$image){
                    if($request->file("images")[$key1]){
                        $asset=['image' =>Upload::uploadWithLogoImageData($request->file("images")[$key1]),'property_id'=>$id,];
                        PropertyGallery::create($asset);
                    }
                }
            }
            PropertyFee::where("property_id",$id)->delete();
            if($request->fee_name){
                foreach($request->fee_name as $key => $value){
                    $ar=["property_id"=>$id,"fee_name"=>$request->fee_name[$key],"fee_rate"=>$request->fee_rate[$key],"fee_type"=>$request->fee_type[$key],"fee_apply"=>$request->fee_apply[$key],"fee_status"=>$request->fee_status[$key]];
                    PropertyFee::create($ar);
                }
            }
            PropertySpace::where("property_id",$id)->delete();
            if($request->space_name){
                foreach($request->space_name as $key => $value){
                    $ar=["property_id"=>$id,"space_name"=>$request->space_name[$key],"space_status"=>$request->space_status[$key]];
                    if($request->file("space_image")[$key]){
                        $ar['space_image']=Upload::uploadWithLogoImageData($request->file("space_image")[$key]);
                    }
                    PropertySpace::create($ar);
                }
            }
        }
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
        $validator = Validator::make($request->all(), ['seo_url' => 'required|unique:properties,seo_url,'.$id,'name' => 'required']);  
        if($validator->fails()){
            return redirect()->back()->withInput()->with("danger",$validator->errors()->first())->withErrors($validator->errors());
        }
        $exist=$this->model::find($id);
        if($exist){
            $data=$request->all();
            if ($request->hasFile("banner_image")) {
                Helper::deleteFile($exist->bannerImage);
                $data['banner_image'] = Upload::fileUpload($request->file("banner_image"),"properties");
            }
            if ($request->hasFile("feature_image")) {
                Helper::deleteFile($exist->feature_image);
                $data['feature_image'] = Upload::uploadWithLogoImageData($request->file("feature_image"),"properties");
            }
            if ($request->hasFile("welcome_package_attachment")) {
                Helper::deleteFile($exist->welcome_package_attachment);
                $data['welcome_package_attachment'] = Upload::uploadWithLogoImageData($request->file("welcome_package_attachment"),"properties");
            }
            if ($request->hasFile("rental_aggrement_attachment")) {
                Helper::deleteFile($exist->rental_aggrement_attachment);
                $data['rental_aggrement_attachment'] = Upload::uploadWithLogoImageData($request->file("rental_aggrement_attachment"),"properties");
            }
            if($request->remove_banner_image){
                $data['bannerImage'] ='';
                Helper::deleteFile($exist->bannerImage);
            }
            if($request->remove_rental_aggrement_attachment){
                $data['rental_aggrement_attachment'] ='';
                Helper::deleteFile($exist->rental_aggrement_attachment);
            }
            if($request->remove_welcome_package_attachment){
                $data['welcome_package_attachment'] ='';
                Helper::deleteFile($exist->welcome_package_attachment);
            }
            if($request->remove_feature_image){
                $data['feature_image'] ='';
                Helper::deleteFile($exist->feature_image);
            }
            $this->model::find($id)->update($data);
            LiveCart::getFileIcalFileData($id);
            if($request->preloaded){
                PropertyGallery::whereNotIn("id",$request->preloaded)->delete();
            }
            if($request->file("images")){
                foreach($request->file("images") as $key1=>$image){
                    if($request->file("images")[$key1]){
                        $asset=['image' =>Upload::uploadWithLogoImageData($request->file("images")[$key1]),'property_id'=>$id,];
                        PropertyGallery::create($asset);
                    }
                }
            }
            PropertyFee::where("property_id",$id)->delete();
            if($request->fee_name){
                foreach($request->fee_name as $key => $value){
                    $ar=["property_id"=>$id,"fee_name"=>$request->fee_name[$key],"fee_rate"=>$request->fee_rate[$key],"fee_type"=>$request->fee_type[$key],"fee_apply"=>$request->fee_apply[$key],"fee_status"=>$request->fee_status[$key],];
                    PropertyFee::create($ar);
                }
            }
            if($request->space_name){
                foreach($request->space_name as $key => $value){
                    $ar=["property_id"=>$id,"space_name"=>$request->space_name[$key],"space_status"=>$request->space_status[$key]];
                    if($request->file("space_image")){
                        if(isset($request->file("space_image")[$key])){
                            $ar['space_image']=Upload::uploadWithLogoImageData($request->file("space_image")[$key]);
                        }
                    }
                    if(isset($request->space_id[$key])){
                        $ar12=PropertySpace::find($request->space_id[$key]);
                        if($ar12){
                            $ar12->update($ar);
                        }
                    }else{
                        PropertySpace::create($ar);
                    }
                }
            }
            return redirect()->back()->with("success","Successfully Updated");
        }
        return redirect()->back()->with("danger","Invalid Calling");
    }

    public function destroy($id){
        $exist=$this->model::find($id);
        if($exist){
            Helper::deleteFile($exist->bannerImage);
            Helper::deleteFile($exist->rental_aggrement_attachment);
            Helper::deleteFile($exist->welcome_package_attachment);
            Helper::deleteFile($exist->feature_image);
            foreach(PropertyAmenityGroup::where("property_id",$id)->get() as $c){
                PropertyAmenity::where("property_amenity_id",$c->id)->delete();
                $c->delete();
            }
            PropertyFee::where("property_id",$id)->delete();
            foreach(PropertyGallery::where("property_id",$id)->get() as $data){
                Helper::deleteFile($data->image);
            }
            PropertyGallery::where("property_id",$id)->delete();
            PropertyRate::where("property_id",$id)->delete();
            PropertyRateGroup::where("property_id",$id)->delete();
            PropertyRoom::where("property_id",$id)->delete();
            PropertySpace::where("property_id",$id)->delete();
            BookingRequest::where("property_id",$id)->delete();
            $exist->delete();
            return redirect()->route($this->admin_base_url)->with("success","Successfully Deleted");
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }

    public function imageDeleteAsset(Request $request){
        $data=PropertyGallery::find($request->id);
        if($data){
            Helper::deleteFile($data->image);
            $data->delete();
        }
    }

    public function  deletePropertySpace(Request $request){
        if($request->id){
            $data=  PropertySpace::find($request->id);
            if($data){
                $data->delete();
            }
        }
    }
}