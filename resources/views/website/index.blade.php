@extends('layouts.website')
@section('title') ..::ASLOOB::.. @endsection
@section('content')


<!--====================  hero slider area ====================-->
<div class="hero-slider-area space__bottom--r120">
    <div class="hero-slick-slider-wrapper">
      @foreach($getBanner as $banner)
        <div class="single-hero-slider single-hero-slider--background single-hero-slider--overlay position-relative bg-img" data-bg="{{ asset('uploads/banner/'.$banner->ban_image) }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- hero slider content -->
                        <div class="hero-slider-content hero-slider-content--extra-space">
                            <h3 class="hero-slider-content__subtitle">{{ $banner->ban_subtitle }}</h3>
                            <h2 class="hero-slider-content__title space__bottom--50">{{ $banner->ban_title }}</h2>
                            <a href="#" class="default-btn default-btn--hero-slider">{{ $banner->ban_caption }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      @endforeach
    </div>
</div>
<!--====================  End of hero slider area  ====================-->
<!--====================  about area ====================-->
<div class="about-area space__bottom--r120 ">
    <div class="container">
        <div class="row align-items-center row-25">
            <div class="col-md-6">
                <div class="about-image space__bottom__lm--30">
                    <img src="{{ asset('contents/website') }}/assets/img/about/about-section-1.png" class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-content">
                    <!-- section title -->
                    <div class="section-title space__bottom--25">
                        <h3 class="section-title__sub">Science 1982</h3>
                        <h2 class="section-title__title">Provide the best quality service and construct</h2>
                    </div>
                    <p class="about-content__text space__bottom--40">Publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infance</p>
                    <a href="#" class="default-btn">Start now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--====================  End of about area  ====================-->


<!--====================  project area ====================-->
<div class="project-area space__bottom--r120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- section title -->
                <div class="section-title text-center  space__bottom--40 mx-auto">
                    <h3 class="section-title__sub">Our Projects</h3>
                    <h2 class="section-title__title">Here you find our latest projects that we did and doing</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="project-wrapper space__bottom--m5" id="project-justify-wrapper">
      @foreach($proj as $item)
        <div class="single-project-wrapper">
            <a class="single-project-item" href="{{ route('project-details',$item->proj_id) }}">
                @if($item->proj_main_thumb == NULL)
                <img src="{{ asset('contents/website') }}/assets/img/projects/project1.jpg" class="img-fluid" alt="">
                @else
                <img src="{{ asset($item->proj_main_thumb) }}" class="img-fluid" alt="#">
                @endif

                <span class="single-project-title">{{ $item->proj_name }}</span>
            </a>
        </div>
      @endforeach
    </div>
</div>
<!--====================  End of project area  ====================-->

@endsection()
