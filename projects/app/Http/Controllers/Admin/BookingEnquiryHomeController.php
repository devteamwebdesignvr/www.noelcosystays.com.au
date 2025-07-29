<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingEnquiryHome;
use App\Helper\Upload;
use Validator;
use LiveCart;

class BookingEnquiryHomeController extends Controller{
    
    public function __construct(BookingEnquiryHome $model){
        $this->model=$model;
        $this->admin_base_url="booking_enquiry_home.index";
        $this->admin_view="admin.booking_enquiry_home";
    }
    
    public function index(){
        $data=$this->model::orderBy("id","desc")->get();
        return view($this->admin_view.".index",compact("data"));
    }
    
    public function create(){
        return view($this->admin_view.".create");
    }

    public function store(Request $request){
        $data=$request->all();
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
        $exist=$this->model::find($id);
        if($exist){
            $data=$request->all();
            $this->model::find($id)->update($data);
            return redirect()->route($this->admin_base_url)->with("success","Successfully Updated");
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }

    public function destroy($id){
        $exist=$this->model::find($id);
        if($exist){
            $exist->delete();
            return redirect()->route($this->admin_base_url)->with("success","Successfully Deleted");
        }
        return redirect()->route($this->admin_base_url)->with("danger","Invalid Calling");
    }
  
  public function getCheckinCheckoutData(Request $request){
        $new_data_blocked=LiveCart::iCalDataCheckInCheckOut($request->id);
        $checkin=$new_data_blocked['checkin'];
        $checkout=$new_data_blocked['checkout'];
        return response()->json($new_data_blocked);
    }
}