<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Thanyaret System') }} - @yield('title', 'Internal Communication System')</title>
    
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
        
        /* ควบคุม z-index และตำแหน่งของปุ่มและเมนู */
        .topic-button {
            position: relative;
            z-index: 10; /* ลด z-index ลงเพื่อไม่ให้บังส่วนอื่น */
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
        
        /* Improved: Styles for dropdown menu */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }

        .nav-dropdown-content {
            display: none; /* ค่าเริ่มต้นคือซ่อน */
            position: absolute;
            background-color: white;
            min-width: 220px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.15);
            z-index: 1000; /* ลด z-index ลงจาก 9999 เพื่อให้เหมาะสมกับลำดับชั้น */
            border-radius: 8px;
            top: 100%;
            right: 0;
            margin-top: 12px;
            overflow: hidden;
        }
        
        /* เพิ่ม CSS เฉพาะสำหรับเมนู Topic */
        .nav-dropdown.topic-dropdown .nav-dropdown-content {
            left: 0;
            right: auto;
        }
        
        /* Style สำหรับ form ที่อยู่ใน dropdown เพื่อป้องกันการซ้อนทับกัน */
        .nav-dropdown-content form {
            position: static;
            width: 100%;
        }
        
        .nav-dropdown-content form .dropdown-item {
            width: 100%;
        }

        /* Up arrow */
        .nav-dropdown-content::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 24px;
            width: 16px;
            height: 16px;
            background-color: white;
            transform: rotate(45deg);
            border-left: 1px solid rgba(0, 0, 0, 0.05);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        /* เพิ่ม CSS เฉพาะสำหรับลูกศรของเมนู Topic */
        .nav-dropdown.topic-dropdown .nav-dropdown-content::before {
            left: 24px;
            right: auto;
        }
        
        .dropdown-item {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f9f9f9;
        }
        
        /* Improved styles for mobile menu */
        .mobile-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 24px;
        }
        
        .mobile-submenu.open {
            max-height: 300px;
        }
        
        .mobile-menu-item {
            padding: 12px 0;
            display: block;
            color: white;
            transition: all 0.2s ease;
        }
        
        .mobile-menu-item:hover {
            color: #f3f4f6;
        }
        
        .mobile-dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            color: white;
            padding: 12px 0;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
        }
        
        .mobile-dropdown-toggle i.dropdown-arrow {
            transition: transform 0.3s ease;
        }
        
        .mobile-dropdown-toggle.active i.dropdown-arrow {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="animated-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-5">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center space-x-2" data-aos="fade-right">
                    <i class="fas fa-comments text-3xl"></i>
                    <span>Thanyaret System</span>
                </a>
                <nav class="hidden md:flex space-x-6" data-aos="fade-left">
                    <a href="{{ route('home') }}" class="nav-item text-lg hover:text-gray-200">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="{{ route('topics.index') }}" class="nav-item text-lg hover:text-gray-200">
                        <i class="fas fa-list-alt mr-1"></i> Topic List
                    </a>
                    
                    @auth
                        <div class="nav-dropdown topic-dropdown">
                            <a href="#" class="nav-item text-lg hover:text-gray-200 flex items-center dropdown-toggle">
                                <i class="fas fa-th-large mr-1"></i> Manage Topic <i class="fas fa-chevron-down ml-1 text-sm"></i>
                            </a>
                            <div class="nav-dropdown-content">
                                <a href="{{ route('topics.create') }}" class="dropdown-item hover:bg-red-50">
                                    <i class="fas fa-plus-circle mr-2 text-red-600"></i> Create New Topic
                                </a>
                                <a href="{{ route('topics.index') }}?sort=latest" class="dropdown-item hover:bg-blue-50">
                                    <i class="fas fa-clock mr-2 text-blue-600"></i> Latest Topic
                                </a>
                                <a href="{{ route('topics.index') }}?sort=popular" class="dropdown-item hover:bg-green-50">
                                    <i class="fas fa-fire mr-2 text-green-600"></i> Popular Topic
                                </a>
                            </div>
                        </div>
                        
                        <!-- Dropdown for user -->
                        <div class="nav-dropdown">
                            <a href="#" class="nav-item text-lg hover:text-gray-200 flex items-center dropdown-toggle">
                                <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name }} <i class="fas fa-chevron-down ml-1 text-sm"></i>
                            </a>
                            <div class="nav-dropdown-content">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item hover:bg-purple-50">
                                        <i class="fas fa-user-shield mr-2 text-purple-600"></i> Admin Dashboard
                                    </a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item hover:bg-red-50 w-full text-left">
                                        <i class="fas fa-sign-out-alt mr-2 text-red-600"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-item text-lg hover:text-gray-200">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="nav-item text-lg hover:text-gray-200">
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </a>
                    @endauth
                </nav>
                <button class="md:hidden text-white focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="md:hidden hidden mt-4 pb-2" id="mobile-menu">
                <a href="{{ route('home') }}" class="mobile-menu-item">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="{{ route('topics.index') }}" class="mobile-menu-item">
                    <i class="fas fa-list-alt mr-2"></i> Topic List
                </a>
                
                @auth
                    <!-- New mobile menu -->
                    <div>
                        <button class="mobile-dropdown-toggle" id="mobile-manage-toggle">
                            <span>
                                <i class="fas fa-th-large mr-2"></i> Manage Topic
                            </span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </button>
                        <div class="mobile-submenu" id="mobile-manage-submenu">
                            <a href="{{ route('topics.create') }}" class="mobile-menu-item">
                                <i class="fas fa-plus-circle mr-2 text-red-300"></i> Create New Topic
                            </a>
                            <a href="{{ route('topics.index') }}?sort=latest" class="mobile-menu-item">
                                <i class="fas fa-clock mr-2 text-blue-300"></i> Latest Topic
                            </a>
                            <a href="{{ route('topics.index') }}?sort=popular" class="mobile-menu-item">
                                <i class="fas fa-fire mr-2 text-green-300"></i> Popular Topic
                            </a>
                        </div>
                    </div>
                    
                    <!-- User menu on mobile -->
                    <div>
                        <button class="mobile-dropdown-toggle" id="mobile-user-toggle">
                            <span>
                                <i class="fas fa-user-circle mr-2"></i> {{ Auth::user()->name }}
                            </span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </button>
                        <div class="mobile-submenu" id="mobile-user-submenu">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="mobile-menu-item">
                                    <i class="fas fa-user-shield mr-2 text-purple-300"></i> Admin Dashboard
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="mobile-menu-item text-left w-full">
                                    <i class="fas fa-sign-out-alt mr-2 text-red-300"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="mobile-menu-item">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="mobile-menu-item">
                        <i class="fas fa-user-plus mr-2"></i> Register
                    </a>
                @endauth
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
                    <p class="text-center md:text-left">&copy; {{ date('Y') }} Thanyaret System. All rights reserved.</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Powered by Thanyaret Internal Communication System</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Animation Library -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
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
            
            // Mobile submenu toggles
            const submenuToggles = document.querySelectorAll('.mobile-dropdown-toggle');
            
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const submenu = this.nextElementSibling;
                    submenu.classList.toggle('open');
                    this.classList.toggle('active');
                });
            });
            
            // แก้ไขปัญหา dropdown ซ้อนทับกัน
            // ทำให้ dropdown แสดงเมื่อคลิกแทนที่จะ hover เพื่อป้องกันการซ้อนทับ
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            const dropdownContents = document.querySelectorAll('.nav-dropdown-content');
            
            // เมื่อคลิกที่ dropdown toggle
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const content = this.nextElementSibling;
                    
                    // ปิด dropdown อื่นๆ ที่อาจเปิดอยู่
                    dropdownContents.forEach(item => {
                        if (item !== content) {
                            item.style.display = 'none';
                        }
                    });
                    
                    // Toggle dropdown ที่คลิก
                    if (content.style.display === 'block') {
                        content.style.display = 'none';
                    } else {
                        content.style.display = 'block';
                    }
                });
            });
            
            // เมื่อคลิกที่พื้นที่อื่นๆ ของหน้าจอ ให้ปิด dropdown ทั้งหมด
            document.addEventListener('click', function() {
                dropdownContents.forEach(content => {
                    content.style.display = 'none';
                });
            });
            
            // ป้องกันการปิด dropdown เมื่อคลิกที่เนื้อหาภายใน dropdown
            dropdownContents.forEach(content => {
                content.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
            
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