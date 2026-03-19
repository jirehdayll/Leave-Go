@extends('layouts.app')
@php $hideNav = true; @endphp


@section('title', 'Select Application - LeaveGo')

<style>
    /* Try to load SF Pro, fallback to system-ui */
    @font-face {
        font-family: "SF Pro Display";
        src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-regular-webfont.woff2");
    }

    .app-selector-view {
        /* Matching the very pale off-white/lavender-tinged background */
        background-color: #f7f6f9; 
        background-image: linear-gradient(180deg, #faf9fb 0%, #f7f6f9 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "SF Pro Display", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .main-wrapper {
        text-align: center;
        width: 100%;
        max-width: 1000px; /* Adjust to preferred width */
        padding: 40px;
    }

    .main-title {
        font-weight: 500;
        font-size: 2.5rem; /* Larger title like image */
        margin-bottom: 3rem;
        color: #000;
        letter-spacing: -0.5px;
    }

    .split-layout {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        width: 100%;
    }

    .selector-card {
        background-color: transparent; /* Changed from white to match transparent look */
        padding: 60px 40px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        min-height: 250px;
        justify-content: space-between;
    }

    /* Target the container of the card for border radius and shadow to avoid divider weirdness */
    .card-outer-wrapper {
        border-radius: 12px;
        transition: transform 0.2s;
    }

    /* If you want hover effect similar to image but less intense */
    .card-outer-wrapper:hover {
        transform: translateY(-5px);
    }

    .card-title-text {
        font-size: 2.25rem;
        font-weight: 600;
        letter-spacing: -0.5px;
        margin-top: 0;
    }

    .card-subtitle {
        color: #718096; /* Placeholder gray color for comments */
        font-size: 1.1rem;
        font-weight: 400;
        line-height: 1.5;
        margin-bottom: 2rem;
    }

    /* Vertical Divider */
    .vertical-line {
        width: 2px;
        background-color: rgba(0, 0, 0, 0.1);
        height: 60%; /* Or fixed height like 200px */
        align-self: center;
    }

    /* General Button Style */
    .btn-action {
        display: inline-block;
        padding: 12px 28px;
        border-radius: 99px; /* Fully rounded like image */
        text-decoration: none;
        font-weight: 500;
        font-size: 1.1rem;
        transition: opacity 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-action:hover {
        opacity: 0.9;
    }

    /* Travel Order - Blue Theme */
    .blue-theme .card-title-text { color: #007aff; } /* SF Pro Blue */
    .blue-theme .btn-action { background-color: #007aff; color: white; }

    /* Leave - Green Theme */
    .green-theme .card-title-text { color: #28cd41; } /* SF Pro Green */
    .green-theme .btn-action { background-color: #1e6e42; color: white; } /* Darker green for contrast on button */

    /* Basic Responsive Tweak */
    @media (max-width: 768px) {
        .split-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .vertical-line {
            display: none;
        }
    }
</style>

@section('content')
<div class="app-selector-view">
    <div class="main-wrapper">
        <h1 class="main-title">What would you like to apply for?</h1>

        <div class="split-layout">
            <div class="card-outer-wrapper blue-theme">
                <div class="selector-card">
                    <div>
                        <h2 class="card-title-text">Travel Order</h2>
                        <p class="card-subtitle">Apply for a travel order for official business.</p>
                    </div>
                    <a href="{{ route('forms.travel') }}" class="btn-action">Get Started</a>
                </div>
            </div>

            <div class="vertical-line"></div>

            <div class="card-outer-wrapper green-theme">
                <div class="selector-card">
                    <div>
                        <h2 class="card-title-text">Sick Leave</h2>
                        <p class="card-subtitle">Submit your request for a leave of absence due to illness.</p>
                    </div>
                    <a href="{{ route('forms.leave') }}" class="btn-action">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection