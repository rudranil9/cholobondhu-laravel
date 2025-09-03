<section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image with Overlay -->
    <div 
        class="absolute inset-0 parallax-bg"
        style="background-image: url('{{ asset('assets/hero-travel-bg.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-black/60"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 text-center text-white px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto pt-20">
        <div class="space-y-8 fade-in-up">
            <!-- Main Heading -->
            <div class="space-y-4">
                <!-- Company Logo -->
                <div class="w-20 h-20 mx-auto mb-6 bg-white rounded-full shadow-2xl overflow-hidden ring-4 ring-white/20 animate-pulse-glow">
                    <img 
                        src="{{ asset('assets/destinations/cholobondhu-logo.jpg') }}" 
                        alt="Cholo Bondhu Logo" 
                        class="w-full h-full object-contain"
                    />
                </div>
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold font-poppins leading-tight">
                    <span class="text-gradient-bright-ocean block animate-glow">Cholo Bondhu</span>
                    <span class="text-white block">Tour & Travels</span>
                </h1>
                <p class="text-xl sm:text-2xl lg:text-3xl font-light max-w-3xl mx-auto leading-relaxed">
                    Discover incredible places, create unforgettable memories, and explore the world with trusted companions
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="flex flex-wrap justify-center gap-8 text-center py-6">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">📍</span>
                    <span class="text-lg font-medium">100+ Destinations</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">📅</span>
                    <span class="text-lg font-medium">1,200+ Happy Travelers</span>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                <a 
                    href="{{ route('tour-packages') }}"
                    class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-700 text-white rounded-lg overflow-hidden font-semibold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-500 flex items-center space-x-2 glow-effect"
                >
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 via-purple-400 to-blue-500 opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-700 rounded-lg blur opacity-25 group-hover:opacity-75 transition-opacity duration-500 animate-pulse-glow"></div>
                    <span class="relative z-10">Explore Packages</span>
                    <span class="relative z-10 text-xl group-hover:translate-x-2 transition-transform duration-300">→</span>
                </a>
                <a 
                    href="{{ route('contact') }}"
                    class="group relative px-8 py-4 border-2 border-white text-white rounded-lg hover:bg-white hover:text-gray-900 transition-all duration-500 font-semibold text-lg backdrop-blur-sm bg-white/10 hover:shadow-xl transform hover:-translate-y-1 hover:scale-105"
                >
                    <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-white/5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <span class="relative z-10">Plan Your Journey</span>
                </a>
            </div>

            <!-- Trust Indicators -->
            <div class="flex flex-wrap justify-center items-center gap-8 pt-8 text-gray-300">
                <div class="flex items-center space-x-2">
                    <span class="text-yellow-400 text-xl">⭐</span>
                    <span>4.9/5 Rating</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-green-400 text-xl">✓</span>
                    <span>Verified Reviews</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-blue-400 text-xl">🛡️</span>
                    <span>Secure Booking</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
        <div class="w-6 h-10 border-2 border-white rounded-full flex justify-center">
            <div class="w-1 h-3 bg-white rounded-full mt-2 animate-pulse"></div>
        </div>
    </div>
</section>

<style>
    .text-gradient-bright-ocean {
        background: linear-gradient(135deg, #ffee00ff 0%, #eeff00ff 25%, #ff5100ff 50%, #e5ff00ff 75%, #ffcc00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        background-size: 200% 200%;
        animation: shimmer-bright 2s ease-in-out infinite, rainbow-flow 4s linear infinite;
        text-shadow: 0 0 30px rgba(0, 245, 255, 0.5), 0 0 60px rgba(102, 0, 255, 0.3);
        filter: brightness(1.5) saturate(1.8);
    }

    .animate-glow {
        animation: mega-glow 3s ease-in-out infinite;
    }

    @keyframes shimmer-bright {
        0%, 100% {
            background-position: 0% 50%;
            filter: brightness(1.5) saturate(1.8) contrast(1.2);
        }
        50% {
            background-position: 100% 50%;
            filter: brightness(2) saturate(2) contrast(1.5);
        }
    }

    @keyframes rainbow-flow {
        0% {
            background-position: 0% 0%;
        }
        100% {
            background-position: 200% 0%;
        }
    }

    @keyframes mega-glow {
        0%, 100% {
            text-shadow: 
                0 0 20px rgba(236, 240, 14, 0.8),
                0 0 40px rgba(255, 196, 0, 0.6),
                0 0 60px rgba(255, 238, 0, 0.4),
                0 0 80px rgba(255, 204, 0, 0.3);
            transform: scale(1);
        }
        50% {
            text-shadow: 
                0 0 30px rgba(255, 115, 0, 1),
                0 0 60px rgba(187, 255, 0, 0.8),
                0 0 90px rgba(244, 248, 5, 0.6),
                0 0 120px rgba(235, 231, 21, 0.74);
            transform: scale(1.02);
        }
    }

    .text-gradient-ocean {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s ease-in-out infinite;
    }

    .parallax-bg {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .fade-in-up {
        animation: fadeInUp 1s ease-out;
    }

    .glow-effect {
        position: relative;
    }

    .glow-effect::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: inherit;
        background: linear-gradient(45deg, #667eea, #764ba2, #667eea);
        z-index: -1;
        filter: blur(8px);
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .glow-effect:hover::before {
        opacity: 0.7;
        animation: glow-rotate 2s linear infinite;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }

    @keyframes glow-rotate {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes animate-pulse-glow {
        0%, 100% {
            opacity: 0.25;
            transform: scale(1);
        }
        50% {
            opacity: 0.75;
            transform: scale(1.05);
        }
    }

    .animate-pulse-glow {
        animation: animate-pulse-glow 2s ease-in-out infinite;
    }

    .font-poppins {
        font-family: 'Poppins', sans-serif;
    }

    /* Floating animation for scroll indicator */
    .animate-bounce {
        animation: bounce 2s infinite, float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px) translateX(-50%);
        }
        50% {
            transform: translateY(-10px) translateX(-50%);
        }
    }

    /* Premium hover effects */
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
        filter: drop-shadow(0 20px 25px rgb(0 0 0 / 0.25));
    }

    @media (max-width: 768px) {
        .parallax-bg {
            background-attachment: scroll;
        }
    }
</style>
