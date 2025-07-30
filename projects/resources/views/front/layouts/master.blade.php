<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
    @include("front.layouts.head")
	@yield("header-section")
        {!! ModelHelper::getDataFromSetting('google-analytics') !!}
        {!! ModelHelper::getDataFromSetting('google-tag-master') !!}
        {!! ModelHelper::getDataFromSetting('facebook-pixel-code') !!}
        {!! ModelHelper::getDataFromSetting('other-thing-on-head') !!} 
		<!-- Google Tag Manager -->
		 <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-P3JRSVVC');</script>
        <!-- End Google Tag Manager -->		
	</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="100">

    

    	{!! ModelHelper::getDataFromSetting('after-body-open-tag') !!}
	  @include("front.layouts.header")


	  @yield('container')

	@include("front.layouts.footer")	

    @yield("footer-section")
    {!! ModelHelper::getDataFromSetting('chat-bot') !!}
	<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P3JRSVVC"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
</body>
</html>