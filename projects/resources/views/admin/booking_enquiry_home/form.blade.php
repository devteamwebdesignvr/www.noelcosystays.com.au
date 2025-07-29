<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("property") !!}
            {!! Form::select("property_id",ModelHelper::getHostAwayPropertySelect(),null,["class"=>"form-control","required","placeholder"=>"Choose Property","id"=>"property-selector"]) !!}
            <span class="text-danger">{{ $errors->first("property_id")}}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("checkin") !!}
            {!! Form::text("start_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtFrom","placeholder"=>"Check in","class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("start_date")}}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("checkout") !!}
            {!! Form::text("end_date",null,["required","autocomplete"=>"off","inputmode"=>"none","id"=>"txtTo","placeholder"=>"Check Out","class"=>"form-control lst" ]) !!}
            <span class="text-danger">{{ $errors->first("end_date")}}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("name") !!}
            {!! Form::text("name",null,["class"=>"form-control","required"]) !!}
            <span class="text-danger">{{ $errors->first("name")}}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("mobile") !!}
            {!! Form::text("mobile",null,["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("mobile")}}</span>
        </div>
    </div> 
   <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("guests") !!}
            {!! Form::number("guests",null,["class"=>"form-control","id" =>"guests"]) !!}
            <span class="text-danger">{{ $errors->first("guests")}}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("email") !!}
            {!! Form::email("email",null,["class"=>"form-control","required"]) !!}
            <span class="text-danger">{{ $errors->first("email")}}</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("How did you hear about us?") !!}
            {!! Form::select('how_did_you_hear_about_us',Helper::GetHowDidYouHearABoutUs(),null,["class"=>"form-control","placeholder"=>"--Select--"]) !!}
            <span class="text-danger">{{ $errors->first("how_did_you_hear_about_us")}}</span>
        </div>
    </div>
    <div class="col-md-12 d-none">
        <div class="form-group">
            {!! Form::label("message") !!}
            {!! Form::textarea("message",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("message")}}</span>
        </div>
    </div>
   
</div>
