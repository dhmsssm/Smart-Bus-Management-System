<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBus - Login</title>

    <!-- Bootstrap 5.3.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #6366f1;
            --accent: #06b6d4;
            --dark: #0f172a;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --bg-light: #fafbff;
            --font-main: 'Plus Jakarta Sans', sans-serif;
            --font-heading: 'Outfit', sans-serif;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-main);
        }

        body {
            background-color: var(--bg-light);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: stretch;
        }

        .login-container {
            width: 100%;
            min-height: 100vh;
        }

        /* Left side - visual panel */
        .left-side {
            background: linear-gradient(135deg, var(--dark) 0%, #1e1b4b 60%, var(--primary) 100%);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 50px;
            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1.5px, transparent 1.5px);
            background-size: 32px 32px;
            opacity: 0.4;
        }

        /* Glowing mesh blobs in left panel */
        .left-glow-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.2) 0%, transparent 70%);
            top: -50px;
            left: -50px;
            filter: blur(50px);
            pointer-events: none;
        }

        .left-glow-2 {
            position: absolute;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            bottom: -80px;
            right: -50px;
            filter: blur(60px);
            pointer-events: none;
        }

        .left-content {
            position: relative;
            z-index: 5;
            max-width: 440px;
            text-align: center;
        }

        .logo-box {
            width: 84px;
            height: 84px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--accent) 100%);
            border-radius: 22px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2.2rem;
            margin: 0 auto 28px;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.35);
            color: white;
        }

        .left-side h2 {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 2.4rem;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
        }

        .left-side p {
            color: rgba(241, 245, 249, 0.8);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .visual-decor {
            margin-top: 40px;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--accent);
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Right side - registration form panel */
        .right-side {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            background-color: var(--bg-light);
            position: relative;
        }

        .right-glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.04) 0%, transparent 70%);
            top: 10%;
            right: 5%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 1;
        }

        .login-card {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            border-radius: 28px;
            padding: 42px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.04);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            z-index: 10;
        }

        .back-link {
            text-decoration: none;
            color: var(--slate-600);
            font-size: 0.9rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
            margin-bottom: 24px;
        }

        .back-link:hover {
            color: var(--primary);
            transform: translateX(-3px);
        }

        .login-card h3 {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 1.85rem;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .login-card .text-muted {
            font-size: 0.95rem;
            color: var(--slate-600) !important;
        }

        /* Role Selector Custom Tabs */
        .role-selector-wrapper {
            background-color: var(--slate-100);
            padding: 6px;
            border-radius: 16px;
            display: flex;
            gap: 4px;
            margin-bottom: 28px;
            border: 1px solid var(--slate-200);
        }

        .role-tab {
            flex: 1;
            border: none;
            background: transparent;
            padding: 11px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--slate-700);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .role-tab:hover {
            color: var(--primary);
        }

        .role-tab.active {
            background: #ffffff;
            color: var(--primary);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        /* Form Controls Custom Styling */
        .form-label-custom {
            font-weight: 700;
            color: var(--slate-700);
            font-size: 0.85rem;
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border-radius: 14px;
            border: 1.5px solid var(--slate-200);
            transition: var(--transition);
        }

        .input-icon-wrapper:focus-within {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .input-icon-wrapper i {
            position: absolute;
            left: 16px;
            color: var(--slate-600);
            font-size: 1.15rem;
            pointer-events: none;
            z-index: 5;
        }

        .input-icon-wrapper input {
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            padding: 13px 16px 13px 46px;
            font-weight: 600;
            color: var(--dark);
            border-radius: 14px;
            font-size: 0.95rem;
            height: 52px;
        }

        .input-icon-wrapper input::placeholder {
            color: #94a3b8;
            font-weight: 500;
        }

        /* Checkbox customization */
        .form-check-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--slate-700);
            font-size: 0.92rem;
            cursor: pointer;
        }

        .form-check-custom input {
            width: 17px;
            height: 17px;
            border-radius: 4px;
            border: 1.5px solid var(--slate-200);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            font-size: 0.92rem;
            transition: var(--transition);
        }

        .forgot-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* Login Action Button */
        .btn-submit-login {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            font-weight: 700;
            padding: 13px 24px;
            border-radius: 14px;
            width: 100%;
            height: 52px;
            border: none;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-submit-login:hover {
            color: white;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.4);
            transform: translateY(-2px);
        }

        .btn-submit-login:active {
            transform: translateY(0);
        }

        .register-helper-text {
            color: var(--slate-600);
            font-size: 0.95rem;
        }

        .register-helper-text a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
        }

        .register-helper-text a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        @media (max-width: 991.98px) {
            body {
                flex-direction: column;
            }
            .left-side {
                padding: 40px 20px;
                text-align: center;
            }
            .logo-box {
                width: 72px;
                height: 72px;
                font-size: 1.8rem;
                margin-bottom: 18px;
            }
            .visual-decor {
                margin-top: 20px;
                width: 56px;
                height: 56px;
                font-size: 1.5rem;
            }
            .right-side {
                padding: 30px 15px;
            }
            .login-card {
                padding: 30px 20px;
                border-radius: 20px;
            }
        }
    </style>
</head>
<body>

    @php
        $activeRole = old('role', $selectedRole ?? 'passenger');
    @endphp

    <div class="container-fluid p-0">
        <div class="row g-0 login-container">
            
            <!-- Left Side Panel (Visual) -->
            <div class="col-lg-5 left-side">
                <div class="left-glow-1"></div>
                <div class="left-glow-2"></div>
                
                <div class="left-content">
                    <div class="logo-box">
                        <i class="bi bi-bus-front-fill"></i>
                    </div>
                    
                    <h2>SmartBus</h2>
                    <p>Next-Gen Transport & Fleet Management Platform</p>
                    
                    <div class="visual-decor">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    
                    <p class="mt-4 opacity-75 small">
                        Track buses in real-time, manage schedules, buy tickets instantly, and travel smarter with SmartBus.
                    </p>
                </div>
            </div>

            <!-- Right Side Panel (Form) -->
            <div class="col-lg-7 right-side">
                <div class="right-glow"></div>
                
                <div class="login-card">
                    
                    <!-- Back Link -->
                    <a href="/" class="back-link">
                        <i class="bi bi-arrow-left"></i> Back to Home
                    </a>
                    
                    <h3 id="loginTitle">{{ $activeRole === 'admin' ? 'Admin Login' : 'Welcome Back' }}</h3>
                    <p class="text-muted mb-4">Log in to your SmartBus account to continue.</p>

                    <!-- Alert Success Block -->
                    @if(session('success'))
                        <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4" role="alert" style="background-color: rgba(16, 185, 129, 0.08); color: var(--success-dark);">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Alert Error Block -->
                    @if(session('error'))
                        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4" role="alert" style="background-color: rgba(239, 68, 68, 0.08); color: #dc2626;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <!-- Validation Errors Block -->
                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4" role="alert" style="background-color: rgba(239, 68, 68, 0.08); color: #dc2626;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Please check your email, password, and login type.
                        </div>
                    @endif

                    <!-- 3-Role Custom Selector Tabs -->
                    <div class="role-selector-wrapper">
                        <button type="button" class="role-tab {{ $activeRole === 'passenger' ? 'active' : '' }}" onclick="setRole('passenger', this)" id="tabPassenger">
                            <i class="bi bi-person-fill"></i> Passenger
                        </button>
                        <button type="button" class="role-tab {{ $activeRole === 'driver' ? 'active' : '' }}" onclick="setRole('driver', this)" id="tabDriver">
                            <i class="bi bi-card-list"></i> Driver
                        </button>
                        <button type="button" class="role-tab {{ $activeRole === 'admin' ? 'active' : '' }}" onclick="setRole('admin', this)" id="tabAdmin">
                            <i class="bi bi-shield-lock-fill"></i> Admin
                        </button>
                    </div>
                    
                    <form method="POST" action="/login">
                        @csrf
                        
                        <!-- Role hidden field -->
                        <input type="hidden" name="role" id="role" value="{{ $activeRole }}">
                        
                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label-custom">Email Address</label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-envelope"></i>
                                <input type="email" name="email" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label-custom">Password</label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-lock"></i>
                                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <label class="form-check-custom">
                                <input type="checkbox" name="remember">
                                Remember Me
                            </label>

                            <a href="#" class="forgot-link">
                                Forgot Password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit-login">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </form>
                    
                    <!-- Register Helper -->
                    <div class="text-center mt-4 register-helper-text">
                        Don't have an account? <a href="/register">Register Here</a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Role Selection Helper Script -->
    <script>
        function setRole(role, button) {
            document.getElementById('role').value = role;

            // Remove active classes
            document.querySelectorAll('.role-tab').forEach(btn => btn.classList.remove('active'));
            
            // Add active class
            button.classList.add('active');

            // Dynamic card title update
            const loginTitle = document.getElementById('loginTitle');
            if (role === 'admin') {
                loginTitle.innerText = 'Admin Login';
            } else {
                loginTitle.innerText = 'Welcome Back';
            }
        }
    </script>

</body>
</html>
