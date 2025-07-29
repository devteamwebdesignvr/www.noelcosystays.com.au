<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("name") !!}
            {!! Form::text("name",null,["class"=>"form-control","required"=>"required"]) !!}
            <span class="text-danger">{{ $errors->first("name")}}</span>
        </div>
    </div>
 
    <div class="col-md-6">
        <div class="form-group">
          <label>SEO URL ( Only A-z,0-9,_,- are allowed)</label>
            {!! Form::text("seo_url",null,["class"=>"form-control", "readonly","pattern"=>"[a-zA-Z0-9-_]+", "title"=>"Enter Valid SEO URL", "oninvalid"=>"this.setCustomValidity('SEO URL is not Valid Please enter first letter must be a-z and only accept chars a-z 0-9,-,_')" ,"onchange"=>"try{setCustomValidity('')}catch(e){}", "oninput"=>"setCustomValidity(' ')","required"=>"required"]) !!}
            <span class="text-danger">{{ $errors->first("seo_url")}}</span>
        </div>
    </div>
 


 
  @isset($data)
@if($data->seo_url=="home")  

    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label("about_image1") !!}
            {!! Form::file("about_image1",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("about_image1")}}</span>
             @isset($data)
                @if($data->about_image1!="")
                     <img src="{{ asset(($data->about_image1)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label("about_image2") !!}
            {!! Form::file("about_image2",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("about_image2")}}</span>
             @isset($data)
                @if($data->about_image2!="")
                     <img src="{{ asset(($data->about_image2)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            {!! Form::label("owner_image") !!}
            {!! Form::file("owner_image",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("owner_image")}}</span>
             @isset($data)
                @if($data->owner_image!="")
                     <img src="{{ asset(($data->owner_image)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>
    @elseif($data->seo_url=="about-us")

      <div class="col-md-3 ">
        <div class="form-group">
            {!! Form::label("bannerImage") !!}
            {!! Form::file("bannerImage",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("bannerImage")}}</span>
             @isset($data)
                @if($data->bannerImage!="")
                     <img src="{{ asset(($data->bannerImage)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>
     <div class="col-md-3 ">
        <div class="form-group">
            {!! Form::label("about_image1") !!}
            {!! Form::file("about_image1",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("about_image1")}}</span>
             @isset($data)
                @if($data->about_image1!="")
                     <img src="{{ asset(($data->about_image1)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>
    
    <div class="col-md-3 d-none">
        <div class="form-group">
            {!! Form::label("about_image2") !!}
            {!! Form::file("about_image2",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("about_image2")}}</span>
             @isset($data)
                @if($data->about_image2!="")
                     <img src="{{ asset(($data->about_image2)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>
     <div class="col-md-3 d-none">
        <div class="form-group">
            {!! Form::label("about_image3") !!}
            {!! Form::file("owner_image",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("owner_image")}}</span>
             @isset($data)
                @if($data->owner_image!="")
                     <img src="{{ asset(($data->owner_image)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>
@else
    <div class="col-md-6 ">
        <div class="form-group">
            {!! Form::label("bannerImage") !!}
            {!! Form::file("bannerImage",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("bannerImage")}}</span>
             @isset($data)
                @if($data->bannerImage!="")
                     <img src="{{ asset(($data->bannerImage)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>


    <div class="col-md-6 ">
        <div class="form-group">
            {!! Form::label("image") !!}
            {!! Form::file("image",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("image")}}</span>
             @isset($data)
                @if($data->image!="")
                     <img src="{{ asset(($data->image)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>
@endif
@endisset


    <div class="col-md-12 d-none">
        <div class="form-group">
            {!! Form::label("templete") !!}
            {!! Form::select("templete",Helper::getTempletes(),null,["class"=>"form-control","required"=>"required"]) !!}
            <span class="text-danger">{{ $errors->first("templete")}}</span>
        </div>
    </div>
    <div class="col-md-4 d-none">
        <div class="form-group">
            {!! Form::label("publish") !!}
            {!! Form::select("publish",["published"=>"published","draft"=>"draft","pending"=>"pending"],null,["class"=>"form-control","required"=>"required"]) !!}
            <span class="text-danger">{{ $errors->first("publish")}}</span>
        </div>
    </div>

   
</div>
@isset($data)
@if($data->seo_url=="home")

<div class="row ">
    <div class="col-md-4 ">
        <div class="form-group">
            {!! Form::label("strip_title") !!}
            {!! Form::text("strip_title",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("strip_title")}}</span>
        </div>
    </div>

    <div class="col-md-4 ">
        <div class="form-group">
            {!! Form::label("strip_description") !!}
            {!! Form::textarea("strip_desction",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("strip_desction")}}</span>
        </div>
    </div>

    <div class="col-md-4 ">
        <div class="form-group">
            {!! Form::label("strip_image") !!}
            {!! Form::file("strip_image",["class"=>"form-control"]) !!}
            <span class="text-danger">{{ $errors->first("strip_image")}}</span>
             @isset($data)
                @if($data->strip_image!="")
                     <img src="{{ asset(($data->strip_image)) }}" width="200" > 
                @endif
            @endisset
        </div>
    </div>

</div>
@endif
@endisset
 @isset($data)
@if($data->seo_url=="home")
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("instageram widget") !!}
            {!! Form::textarea("description",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("description")}}</span>
        </div>
    </div>
</div>
@endif
@endisset
<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("shortDescription") !!}
            {!! Form::textarea("shortDescription",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("shortDescription")}}</span>
        </div>
    </div>
  
</div>
<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("mediumDescription") !!}
            {!! Form::textarea("mediumDescription",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("mediumDescription")}}</span>
        </div>
    </div>
 
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("longDescription") !!}
            {!! Form::textarea("longDescription",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("longDescription")}}</span>
        </div>
    </div>
  
</div>

<div class="row">
    <div class="col-md-12 alert alert-warning text-center">
        <h3>Seo Section</h3>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("meta_title") !!}
            {!! Form::textarea("meta_title",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("meta_title")}}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label("meta_keywords") !!}
            {!! Form::textarea("meta_keywords",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("meta_keywords")}}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("meta_description") !!}
            {!! Form::textarea("meta_description",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("meta_description")}}</span>
        </div>
    </div>
</div>
<div class="row d-none">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("header_section") !!}
            {!! Form::textarea("header_section",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("header_section")}}</span>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("footer_section") !!}
            {!! Form::textarea("footer_section",null,["class"=>"form-control","rows"=>"2"]) !!}
            <span class="text-danger">{{ $errors->first("footer_section")}}</span>
        </div>
    </div>
</div>