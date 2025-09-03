<!-- Dynamic Travel Background Animations -->
<div class="travel-background-layer">
    <!-- Flying Planes -->
    <div class="travel-vehicle plane-1">✈️</div>
    <div class="travel-vehicle plane-2">🛩️</div>
    <div class="travel-vehicle plane-3">🛩️</div>
    
    <!-- Moving Trains -->
    <div class="travel-vehicle train-1">🚄</div>
    <div class="travel-vehicle train-2">🚂</div>
    <div class="travel-vehicle train-3">🚆</div>
    
    <!-- Cars and Buses -->
    <div class="travel-vehicle car-1">🚗</div>
    <div class="travel-vehicle bus-1">🚌</div>
    <div class="travel-vehicle car-2">🚙</div>
    
    <!-- Ships and Boats -->
    <div class="travel-vehicle ship-1">🛳️</div>
    <div class="travel-vehicle boat-1">⛵</div>
    <div class="travel-vehicle ship-2">🚢</div>
    
    <!-- Travel Elements -->
    <div class="travel-element-bg map-1">🗺️</div>
    <div class="travel-element-bg compass-1">🧭</div>
    <div class="travel-element-bg luggage-1">🎒</div>
    <div class="travel-element-bg camera-1">📷</div>
    <div class="travel-element-bg world-1">🌍</div>
    <div class="travel-element-bg mountain-1">🏔️</div>
    
    <!-- Floating Travel Particles -->
    <div class="travel-particle star-1">⭐</div>
    <div class="travel-particle star-2">✨</div>
    <div class="travel-particle star-3">🌟</div>
    <div class="travel-particle cloud-1">☁️</div>
    <div class="travel-particle cloud-2">⛅</div>
    <div class="travel-particle sun-1">☀️</div>
</div>

<style>
/* Dynamic Travel Background Layer */
.travel-background-layer {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 1;
    overflow: hidden;
}

/* Travel Vehicles - Dynamic Movement */
.travel-vehicle {
    position: absolute;
    font-size: 2rem;
    opacity: 0.7;
    filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
}

/* Planes - Flying at edges only */
.plane-1 {
    top: 8%;
    left: -100px;
    animation: fly-right 25s linear infinite;
}

.plane-2 {
    top: 12%;
    right: -100px;
    animation: fly-left 30s linear infinite 8s;
    transform: scaleX(-1);
}

.plane-3 {
    top: 85%;
    left: -100px;
    animation: fly-diagonal 35s linear infinite 15s;
}

@keyframes fly-right {
    0% { transform: translateX(-100px) translateY(0px); }
    100% { transform: translateX(calc(100vw + 100px)) translateY(-50px); }
}

@keyframes fly-left {
    0% { transform: scaleX(-1) translateX(100px) translateY(0px); }
    100% { transform: scaleX(-1) translateX(calc(-100vw - 100px)) translateY(30px); }
}

@keyframes fly-diagonal {
    0% { transform: translateX(-100px) translateY(0px); }
    50% { transform: translateX(50vw) translateY(-80px); }
    100% { transform: translateX(calc(100vw + 100px)) translateY(20px); }
}

/* Trains - At bottom edge only */
.train-1 {
    bottom: 5%;
    left: -150px;
    animation: train-journey 20s linear infinite 5s;
}

.train-2 {
    bottom: 8%;
    right: -150px;
    animation: train-return 22s linear infinite 12s;
    transform: scaleX(-1);
}

.train-3 {
    bottom: 2%;
    left: -150px;
    animation: train-journey 18s linear infinite 20s;
}

@keyframes train-journey {
    0% { transform: translateX(-150px); }
    100% { transform: translateX(calc(100vw + 150px)); }
}

@keyframes train-return {
    0% { transform: scaleX(-1) translateX(150px); }
    100% { transform: scaleX(-1) translateX(calc(-100vw - 150px)); }
}

/* Travel Elements Background - Edge positions only */
.travel-element-bg {
    position: absolute;
    font-size: 1.8rem;
    opacity: 0.3;
}

.map-1 {
    top: 5%;
    left: 5%;
    animation: gentle-float 8s ease-in-out infinite;
}

.compass-1 {
    top: 10%;
    right: 5%;
    animation: gentle-float 10s ease-in-out infinite 2s;
}

@keyframes gentle-float {
    0%, 100% { transform: translateY(0px) translateX(0px); }
    25% { transform: translateY(-15px) translateX(5px); }
    50% { transform: translateY(-8px) translateX(-3px); }
    75% { transform: translateY(-12px) translateX(8px); }
}

/* Responsive - Reduce animations on smaller screens */
@media (max-width: 768px) {
    .travel-vehicle,
    .travel-element-bg {
        font-size: 1.5rem;
    }
    
    .travel-particle {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .travel-vehicle {
        display: none;
    }
    
    .travel-element-bg,
    .travel-particle {
        font-size: 0.8rem;
        opacity: 0.3;
    }
}
</style>
