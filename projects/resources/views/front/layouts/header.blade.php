
<header class="page-header desk">
  <div class="top"></div>
  <div class="upper-area">
     <div class="container">
        <div class="row">
           <div class="col-6 left-top">
              <ul>
                 <li><i class="fas fa-phone-volume"></i> <a href="tel:{!! $setting_data['mobile']!!}"> {!! $setting_data['mobile']!!}</a></li>
              </ul>
           </div>
           <div class="col-6 right-top">
              <ul>
                <li><i class="fas fa-envelope"></i> <a href="mailto:{!! $setting_data['email']!!}"> {!! $setting_data['email']!!}</a></li>
              </ul>
           </div>
        </div>
     </div>
  </div>
  <div class="bottom-area">
     <div class="container">
        <div class="row">
           <div class="col-5 left">
              <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                 <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav">
                       <li class="nav-item active"> <a class="nav-link" href="{{ url('/') }}"> Home </a> </li>
                       <li class="nav-item"><a class="nav-link" href="{{ url('properties') }}">Browse All Properties</a></li>
                     <li class="nav-item"><a class="nav-link" href="{{ url('properties') }}"> Book Now </a></li>
                    </ul>
                 </div>
              </nav>
           </div>
           <div class="col-2">
              <a href="{{ url('/') }}" class="logo"><img src="{{ asset($setting_data['header_logo'] ?? 'front/images/logo.png') }}" alt="Logo" class="img-fluid"></a>
           </div>
           <div class="col-5 right">
              <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                 <div class="collapse navbar-collapse right" id="main_nav">
                    <ul class="navbar-nav">
                       <li class="nav-item"> <a class="nav-link" href="{{ url('about-us') }}"> About us </a></li>
                      <li class="nav-item"> <a class="nav-link" href="{{ url('blogs') }}"> Blogs </a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ url('contact-us') }}"> Contact Us </a></li>
       
                    </ul>
                 </div>
              </nav>
        
           </div>
        </div>
     </div>
  </div>
 
</header>
<header class="page-header mob">
   <div class="container">
       <div class="row">
           <a href="{{ url('/') }}" class="logo">
     <img src="{{ asset($setting_data['header_logo'] ?? 'front/images/logo.png') }}" alt="Logo" class="img-fluid">
     </a>
           <div class="menu-toggle1" id="menu-toggle1"><i class="fa fa-bars"></i></div>
           <div class="menu-bar-in" id="tag1">
               <div class="mobile-nav">
                   <div class="mobile-menu-logo">
                         <a href="{{ url('/') }}" class="logo">
           <img src="{{ asset($setting_data['header_logo'] ?? 'front/images/logo.png') }}" alt="Logo" class="img-fluid">
           </a>
                       <span id="close-menu"><i class="fa fa-times" id="close-menu1"></i></span>
                   </div>
                   <nav class="navbar navbar-expand-lg">
                       <div class="navbar-collapse" id="main_nav">
                           <ul class="navbar-nav">
                                  <li class="nav-item active"> <a class="nav-link" href="{{ url('/') }}"> Home </a> </li>
                       <li class="nav-item"><a class="nav-link" href="{{ url('properties') }}">Browse All Properties</a></li>
                     <li class="nav-item"><a class="nav-link" href="{{ url('properties') }}"> Book Now </a></li>
                              <li class="nav-item"> <a class="nav-link" href="{{ url('about-us') }}"> About us </a></li>
                      <li class="nav-item"> <a class="nav-link" href="{{ url('blogs') }}"> Blogs </a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ url('contact-us') }}"> Contact Us </a></li>
                            
                           </ul>
                       </div>
                   </nav>
               </div>
           </div>
       </div>
   </div>
</header>

