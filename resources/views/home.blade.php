@extends('layouts.app')

@section('title', 'Cholo Bondhu - Your Travel Companion')
@section('description', 'Discover incredible places with Cholo Bondhu Travel. Expert travel planning, best prices, and unforgettable experiences across India and beyond.')

@section('content')
    <!-- Hero Section -->
    @include('partials.hero')
    
    <!-- Travel Categories -->
    @include('partials.travel-categories')
    
    <!-- Why Choose Us -->
    @include('partials.why-choose-us')
    
    <!-- India Map Explorer -->
    @include('partials.india-map-explorer')
    
    <!-- About Us -->
    @include('partials.about-us')
    
    <!-- Contact Us -->
    @include('partials.contact-us')
@endsection
