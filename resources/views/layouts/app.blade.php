<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Thanyaret System') }} - @yield('title', 'ระบบสื่อสารภายในองค์กร')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            scroll-behavior: smooth;
        }
        
        .flash-message {
            transition: opacity 1s ease-in-out;
        }
        
        .btn-hover {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-hover:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            z-index: 0;
        }
        
        .btn-hover:hover:before {
            left: 100%;
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-item:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -3px;
            left: 0;
            background-color: white;
            transition: width 0.3s ease;
        }
        
        .nav-item:hover:after {
            width: 100%;
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        
        .animated-bg {
            background: linear-gradient(-45deg, #991b1b, #b91c1c, #dc2626, #ef4444);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="animated-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-5">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center space-x-2" data-aos="fade-right">
                    <i class="fas fa-comments-alt text-3xl"></i>
                    <span>Thanyaret System</span>
                </a>
                <nav class="hidden md:flex space-x-6" data-aos="fade-left">
                    <a href="{{ route('home') }}" class="nav-item text-lg hover:text-gray-200">หน้าหลัก</a>
                    <a href="{{ route('topics.create') }}" class="nav-item text-lg hover:text-gray-200">สร้างหัวข้อใหม่</a>
                </nav>
                <button class="md:hidden text-white focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="md:hidden hidden mt-4 pb-2" id="mobile-menu">
                <a href="{{ route('home') }}" class="block py-2 text-lg hover:text-gray-200">หน้าหลัก</a>
                <a href="{{ route('topics.create') }}" class="block py-2 text-lg hover:text-gray-200">สร้างหัวข้อใหม่</a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6 flex-grow">
        @if (session('success'))
            <div id="success-message" class="flash-message mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" data-aos="fade-up">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div id="error-message" class="flash-message mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" data-aos="fade-up">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-center md:text-left">&copy; {{ date('Y') }} Thanyaret System. ขอสงวนลิขสิทธิ์ทั้งหมด</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Animation Library -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Flash messages fade out
            setTimeout(() => {
                const messages = document.querySelectorAll('.flash-message');
                messages.forEach(message => {
                    message.style.opacity = '0';
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 1000);
                });
            }, 5000);
        });
    </script>
</body>
</html> 