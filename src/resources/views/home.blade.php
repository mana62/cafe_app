@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <div class="content">
        {{-- History セクション --}}
        <section class="history section">
            <h1 class="history__title">Our Story</h1>
            <div class="history__image left">
                <img src="{{ asset('img/cake5.jpeg') }}" alt="Delicious cake">
            </div>
            <p class="history__text">
                Nestled in the heart of Paris, <strong>Café Lumière</strong> was born in 2021, inspired by the timeless charm of French cafés.<br><br>
                We are more than just a coffee shop—we are a place where people connect, share stories, and find comfort in the aroma of freshly brewed coffee.<br><br>
                Our coffee beans are sourced from sustainable farms worldwide, ensuring each cup tells a story of craftsmanship and care.<br>
                We also offer a delightful selection of organic pastries, each crafted with love and dedication.<br><br>
                Step into our café and let the soft glow of our warm ambiance embrace you.
            </p>
        </section>

        {{-- News セクション --}}
        <section class="news section">
            <h2 class="news__title">Latest News</h2>
            <div class="news__image right">
                <img src="{{ asset('img/flower2.jpeg') }}" alt="Beautiful flowers">
            </div>
            <p class="news__text">
                We are thrilled to introduce our <strong>seasonal menu</strong>, featuring a selection of hand-crafted drinks inspired by the colors and flavors of Parisian spring.<br><br>
                Try our new <strong>Rose Latte</strong> or indulge in our signature <strong>Lavender Honey Croissant</strong>.<br><br>
                Stay tuned for our upcoming <strong>barista workshops</strong>, where you can learn the art of making the perfect espresso!
            </p>
        </section>

        {{-- Location セクション --}}
        <section class="location section">
            <h2 class="location__title">Our Location</h2>
            <div class="location__image left">
                <img src="{{ asset('img/coffee1.jpeg') }}" alt="Freshly brewed coffee">
            </div>
            <p class="location__text">
                Our café is situated in the heart of <strong>Le Marais, Paris</strong>, a charming district known for its rich history and artistic soul.<br><br>
                Enjoy your coffee while strolling through the cobblestone streets or relaxing on our <strong>terrace with a view of the Seine</strong>.<br><br>
                📍 <strong>Address:</strong> 12 Rue de Lumière, 75004 Paris, France<br>
                ☕ <strong>Opening Hours:</strong> Monday - Sunday: 8:00 AM - 8:00 PM
            </p>
        </section>
    </div>
@endsection
