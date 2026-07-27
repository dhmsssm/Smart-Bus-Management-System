<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BusLink - Smart Bus Management System</title>
    
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
            --accent-hover: #0891b2;
            --success: #10b981;
            --success-dark: #059669;
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

        html {
            scroll-behavior: smooth;
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
            overflow-x: hidden;
            position: relative;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Ambient Background Glows */
        .ambient-glow-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.08) 0%, rgba(6, 182, 212, 0.03) 70%, transparent 100%);
            top: -100px;
            left: -150px;
            filter: blur(80px);
            z-index: -2;
            pointer-events: none;
        }

        .ambient-glow-2 {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, rgba(79, 70, 229, 0.02) 80%, transparent 100%);
            top: 400px;
            right: -200px;
            filter: blur(100px);
            z-index: -2;
            pointer-events: none;
        }

        .ambient-glow-3 {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.05) 0%, rgba(79, 70, 229, 0.04) 70%, transparent 100%);
            bottom: 200px;
            left: -100px;
            filter: blur(100px);
            z-index: -2;
            pointer-events: none;
        }

        /* Floating Vector Circles */
        .decor-circle {
            position: absolute;
            border-radius: 50%;
            z-index: -1;
            pointer-events: none;
            animation: float-slow 10s ease-in-out infinite;
        }

        .decor-circle-1 {
            width: 80px;
            height: 80px;
            background: rgba(6, 182, 212, 0.05);
            border: 1.5px solid rgba(6, 182, 212, 0.15);
            top: 15%;
            left: 5%;
        }

        .decor-circle-2 {
            width: 50px;
            height: 50px;
            background: rgba(79, 70, 229, 0.04);
            border: 1.5px solid rgba(79, 70, 229, 0.12);
            bottom: 20%;
            left: 45%;
            animation-delay: 2.5s;
        }

        .decor-circle-3 {
            width: 65px;
            height: 65px;
            background: rgba(16, 185, 129, 0.04);
            border: 1.5px solid rgba(16, 185, 129, 0.12);
            top: 50%;
            right: 40%;
            animation-delay: 4s;
        }

        @keyframes float-slow {
            0%, 100% { transform: translateY(0) rotate(0deg) scale(1); }
            50% { transform: translateY(-20px) rotate(180deg) scale(1.08); }
        }

        /* Navbar Styling */
        .navbar {
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            transition: var(--transition);
        }

        .navbar-brand {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 1.6rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-brand i {
            font-size: 1.8rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            font-weight: 600;
            color: var(--slate-700) !important;
            padding: 0.5rem 1.2rem !important;
            border-radius: 99px;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background-color: rgba(79, 70, 229, 0.06);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #ffffff;
            font-weight: 700;
            padding: 0.65rem 1.8rem;
            border-radius: 99px;
            transition: var(--transition);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
            border: none;
        }

        .btn-login:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        /* Hero Section */
        .hero-section {
            min-height: 720px;
            padding: 6.5rem 2rem 6rem;
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(90deg, rgba(250, 252, 255, 0.96) 0%, rgba(250, 252, 255, 0.88) 42%, rgba(250, 252, 255, 0.58) 68%, rgba(250, 252, 255, 0.18) 100%),
                url('{{ asset('images/modern_city_bg.jpg') }}') 70% center / cover no-repeat;
            isolation: isolate;
        }

        .hero-section .row {
            min-height: 520px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(250, 251, 255, 0.08) 56%, rgba(250, 251, 255, 0.72) 100%),
                radial-gradient(circle at 14% 24%, rgba(6, 182, 212, 0.12), transparent 30%),
                radial-gradient(circle at 40% 18%, rgba(79, 70, 229, 0.08), transparent 28%);
            z-index: -1;
            pointer-events: none;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            inset: auto 0 0;
            height: 180px;
            background: linear-gradient(180deg, transparent 0%, var(--bg-light) 100%);
            z-index: -1;
            pointer-events: none;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.88);
            color: var(--primary);
            font-weight: 700;
            font-size: 0.78rem;
            padding: 0.48rem 1.15rem;
            border-radius: 99px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.4rem;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            border: 1px solid rgba(79, 70, 229, 0.16);
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.07);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .hero-badge i {
            font-size: 1rem;
            color: var(--accent);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        .hero-title {
            font-size: 3.6rem;
            line-height: 1.12;
            color: var(--dark);
            margin-bottom: 1.25rem;
            font-weight: 800;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.65);
        }

        .hero-title::after {
            content: '';
            display: block;
            width: 74px;
            height: 4px;
            margin-top: 1.2rem;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--success), var(--accent), var(--primary-light));
            box-shadow: 0 8px 20px rgba(6, 182, 212, 0.18);
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-description {
            font-size: 1.08rem;
            color: #334155;
            line-height: 1.65;
            margin-bottom: 2rem;
            max-width: 540px;
            font-weight: 500;
        }

        .btn-get-started {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            color: white;
            font-weight: 700;
            padding: 0.9rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: 0 10px 24px rgba(16, 185, 129, 0.24);
            border: none;
            min-height: 52px;
        }

        .btn-get-started:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.45);
            filter: brightness(1.05);
        }

        .btn-search-outline {
            background-color: rgba(255, 255, 255, 0.86);
            color: var(--primary);
            font-weight: 700;
            padding: 0.9rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            border: 2px solid rgba(79, 70, 229, 0.18);
            transition: var(--transition);
            margin-left: 1.2rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            min-height: 52px;
        }

        .btn-search-outline:hover {
            background-color: rgba(79, 70, 229, 0.05);
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        /* Mouse Wheel Scroll Down Indicator */
        .scroll-down-wrapper {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 15;
        }

        .scroll-down-mouse {
            display: block;
            width: 24px;
            height: 38px;
            border: 2px solid rgba(255, 255, 255, 0.82);
            border-radius: 12px;
            position: relative;
            opacity: 0.86;
            transition: var(--transition);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.18);
        }

        .scroll-down-mouse:hover {
            opacity: 1;
            border-color: var(--primary);
        }

        .scroll-wheel {
            display: block;
            width: 4px;
            height: 8px;
            background-color: var(--primary-light);
            border-radius: 2px;
            position: absolute;
            left: 50%;
            top: 6px;
            transform: translateX(-50%);
            animation: scroll-wheel-anim 1.6s infinite ease-in-out;
        }

        @keyframes scroll-wheel-anim {
            0% { top: 6px; opacity: 1; }
            50% { top: 18px; opacity: 0; }
            100% { top: 6px; opacity: 1; }
        }

        /* Live Tracking Card Widget */
        .hero-visual-column {
            position: relative;
        }

        .hero-visual-column::before {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            right: 46px;
            top: -24px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.2), transparent 68%);
            filter: blur(6px);
            z-index: 0;
            pointer-events: none;
        }

        .tracking-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 16px;
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.9);
            padding: 18px;
            max-width: 430px;
            margin-top: 0;
            margin-left: auto;
            position: relative;
            z-index: 2;
            overflow: hidden;
            transition: var(--transition);
        }

        .tracking-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.1);
        }

        .tracking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .tracking-title {
            font-size: 1rem;
            color: var(--dark);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tracking-title i {
            color: var(--success);
            font-size: 1.2rem;
            animation: pulse-icon 2s infinite;
        }

        @keyframes pulse-icon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .tracking-status {
            background-color: rgba(16, 185, 129, 0.12);
            color: var(--success-dark);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 99px;
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .tracking-status::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            background-color: var(--success);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.6); opacity: 0.3; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Simple live tracking preview */
        .map-viewport {
            height: 142px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.18), rgba(15, 23, 42, 0.1)),
                url('https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?auto=format&fit=crop&w=1000&q=80') center / cover no-repeat;
            border-radius: 14px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.95);
            margin-bottom: 16px;
        }

        .map-grid-pattern {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(255, 255, 255, 0.58), rgba(255, 255, 255, 0.12)),
                repeating-linear-gradient(0deg, rgba(15, 23, 42, 0.04) 0 1px, transparent 1px 34px),
                repeating-linear-gradient(90deg, rgba(15, 23, 42, 0.04) 0 1px, transparent 1px 34px);
            opacity: 1;
        }

        .route-line {
            position: absolute;
            width: 70%;
            height: 5px;
            background: linear-gradient(90deg, var(--success) 0%, var(--accent) 100%);
            top: 54%;
            left: 15%;
            transform: translateY(-50%) rotate(-7deg);
            border-radius: 99px;
            box-shadow: 0 8px 20px rgba(6, 182, 212, 0.24);
        }

        .animated-bus-indicator {
            position: absolute;
            width: 36px;
            height: 36px;
            background: #ffffff;
            border: 2px solid #ffffff;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.2);
            top: 54%;
            left: 50%;
            transform: translate(-50%, -55%);
            animation: travelOnRoute 13s infinite ease-in-out alternate;
            z-index: 2;
        }

        @keyframes travelOnRoute {
            0% { left: 18%; transform: translate(-50%, -42%) rotate(-7deg); }
            100% { left: 82%; transform: translate(-50%, -68%) rotate(-7deg); }
        }

        .tracking-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            text-align: center;
            border-top: 1px solid rgba(226, 232, 240, 0.6);
            padding-top: 14px;
        }

        .stat-item label {
            display: block;
            font-size: 0.68rem;
            color: var(--slate-600);
            margin-bottom: 4px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .stat-item span {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--dark);
        }

        .stat-item.highlight span {
            color: var(--success);
        }

        /* Floating Search Widget Layout */
        .search-outer-container {
            margin-top: -4rem;
            position: relative;
            z-index: 20;
            padding: 0 2rem;
        }

        .search-card-wrapper {
            background: rgba(255, 255, 255, 0.96);
            border-radius: 18px;
            box-shadow: 0 18px 46px rgba(15, 23, 42, 0.11);
            border: 1px solid rgba(226, 232, 240, 0.72);
            padding: 2rem;
            max-width: 1100px;
            margin: 0 auto;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            position: relative;
            overflow: hidden;
        }

        .search-card-wrapper::before {
            content: '';
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent), var(--success));
        }

        .search-card-wrapper h4 {
            font-size: 1.25rem;
            color: var(--dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
        }

        .search-card-wrapper h4 i {
            color: var(--primary);
            font-size: 1.4rem;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
            background: #f8fafc;
            border-radius: 12px;
            border: 1.5px solid rgba(226, 232, 240, 0.9);
            transition: var(--transition);
        }

        .input-group-custom:focus-within {
            background: #ffffff;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .input-group-custom i {
            position: absolute;
            left: 16px;
            color: var(--slate-600);
            font-size: 1.15rem;
            pointer-events: none;
            z-index: 5;
        }

        .input-group-custom select,
        .input-group-custom input {
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            padding: 13px 16px 13px 46px;
            font-weight: 600;
            color: var(--dark);
            appearance: none;
            -webkit-appearance: none;
            border-radius: 12px;
            font-size: 0.95rem;
        }

        .input-group-custom select {
            cursor: pointer;
        }

        /* Custom Arrow for select */
        .select-arrow-icon {
            position: absolute;
            right: 16px;
            pointer-events: none;
            color: var(--slate-600);
            font-size: 0.9rem !important;
        }

        .form-label-custom {
            font-weight: 700;
            color: var(--slate-700);
            font-size: 0.85rem;
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Locations Swap Button */
        .btn-swap-locations {
            position: absolute;
            right: -19px;
            top: 36px;
            width: 38px;
            height: 38px;
            background-color: #ffffff;
            border: 2px solid rgba(226, 232, 240, 0.9);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }

        .btn-swap-locations:hover {
            border-color: var(--primary-light);
            background-color: var(--slate-100);
            color: var(--primary-hover);
        }

        .btn-swap-locations:active {
            transform: scale(0.92);
        }

        /* Quick Date Selectors */
        .date-shortcuts {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .btn-date-shortcut {
            background: transparent;
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: var(--slate-600);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 99px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-date-shortcut:hover, .btn-date-shortcut.active {
            background: rgba(79, 70, 229, 0.08);
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .btn-search-submit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            font-weight: 700;
            padding: 14px 24px;
            border-radius: 14px;
            width: 100%;
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

        .btn-search-submit:hover {
            color: white;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.45);
            transform: translateY(-2px);
            filter: brightness(1.05);
        }

        /* Stats Strip */
        .stats-strip {
            background: linear-gradient(180deg, #ffffff 0%, rgba(248, 250, 252, 0.6) 100%);
            border-top: 1px solid rgba(226, 232, 240, 0.8);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            padding: 5rem 2rem;
            margin-top: 4rem;
            position: relative;
        }

        .stat-box {
            text-align: center;
            padding: 2.5rem 1.8rem;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: var(--transition);
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
        }

        .stat-box:hover {
            transform: translateY(-8px);
            background: #ffffff;
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.08);
            border-color: rgba(79, 70, 229, 0.18);
        }

        .stat-box h2 {
            font-size: 3.2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
            font-weight: 800;
        }

        .stat-box p {
            color: var(--slate-600);
            font-weight: 700;
            font-size: 0.88rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 0;
        }

        /* Partner Operators Showcase row */
        .operators-strip {
            background-color: #ffffff;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .operators-strip p {
            color: var(--slate-600);
            font-weight: 700;
            letter-spacing: 2px;
        }

        .operators-logo-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 40px;
        }

        .operator-logo {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--slate-600);
            opacity: 0.45;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            user-select: none;
        }

        .operator-logo:hover {
            opacity: 0.85;
            color: var(--primary-light);
        }

        /* How It Works Section */
        .how-it-works {
            padding: 7rem 2rem;
            background-color: rgba(248, 250, 252, 0.6);
            position: relative;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .step-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 50px 30px 40px;
            position: relative;
            transition: var(--transition);
            height: 100%;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.01);
        }

        .step-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(79, 70, 229, 0.08);
            border-color: rgba(79, 70, 229, 0.15);
        }

        .step-number {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            font-size: 0.95rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .step-card h5 {
            font-size: 1.25rem;
            color: var(--dark);
            margin-bottom: 12px;
            font-weight: 700;
        }

        .step-card p {
            color: var(--slate-600);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* Features Section */
        .features-section {
            padding: 7rem 2rem;
            background-color: #ffffff;
            position: relative;
        }

        .section-header {
            text-align: center;
            max-width: 650px;
            margin: 0 auto 5rem;
        }

        .section-header h2 {
            font-size: 2.6rem;
            color: var(--dark);
            margin-bottom: 16px;
            font-weight: 800;
        }

        .section-header p {
            color: var(--slate-600);
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .feature-card {
            background-color: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 35px;
            transition: var(--transition);
            height: 100%;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(79, 70, 229, 0.08);
            border-color: rgba(79, 70, 229, 0.18);
        }

        .feature-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            font-size: 1.8rem;
            transition: var(--transition);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .feature-card:hover .feature-icon-wrapper {
            transform: scale(1.1) rotate(6deg);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        }

        .feature-icon-blue {
            background-color: rgba(79, 70, 229, 0.08);
            color: var(--primary);
        }

        .feature-icon-green {
            background-color: rgba(16, 185, 129, 0.08);
            color: var(--success);
        }

        .feature-icon-amber {
            background-color: rgba(245, 158, 11, 0.08);
            color: #d97706;
        }

        .feature-card h5 {
            font-size: 1.35rem;
            margin-bottom: 14px;
            color: var(--dark);
            font-weight: 700;
        }

        .feature-card p {
            color: var(--slate-600);
            font-size: 0.98rem;
            line-height: 1.65;
            margin-bottom: 0;
        }

        /* Roles Dashboard Section */
        .roles-section {
            padding: 7rem 2rem;
            background-color: rgba(248, 250, 252, 0.6);
            position: relative;
        }

        .role-card {
            background: #ffffff;
            border-radius: 28px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 40px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            transition: var(--transition);
        }

        .role-card.passenger::before { background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%); }
        .role-card.driver::before { background: linear-gradient(90deg, var(--success) 0%, var(--success-dark) 100%); }
        .role-card.admin::before { background: linear-gradient(90deg, #6366f1 0%, #a855f7 100%); }

        .role-card.passenger:hover {
            transform: translateY(-8px);
            border-color: rgba(79, 70, 229, 0.3);
            box-shadow: 0 25px 50px rgba(79, 70, 229, 0.08);
        }
        
        .role-card.driver:hover {
            transform: translateY(-8px);
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 25px 50px rgba(16, 185, 129, 0.08);
        }
        
        .role-card.admin:hover {
            transform: translateY(-8px);
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 25px 50px rgba(99, 102, 241, 0.08);
        }

        .role-header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 28px;
        }

        .role-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            transition: var(--transition);
        }

        .role-card:hover .role-icon {
            transform: scale(1.08);
        }

        .passenger .role-icon { background-color: rgba(79, 70, 229, 0.08); color: var(--primary); }
        .driver .role-icon { background-color: rgba(16, 185, 129, 0.08); color: var(--success); }
        .admin .role-icon { background-color: rgba(99, 102, 241, 0.08); color: #6366f1; }

        .role-title h4 {
            font-size: 1.4rem;
            margin-bottom: 3px;
            color: var(--dark);
            font-weight: 800;
        }

        .role-title p {
            color: var(--slate-600);
            font-size: 0.85rem;
            margin-bottom: 0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-features {
            list-style: none;
            padding-left: 0;
            margin-bottom: 35px;
            flex-grow: 1;
        }

        .role-features li {
            font-size: 0.98rem;
            color: var(--slate-700);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .role-features li i {
            font-size: 1.25rem;
        }

        .passenger .role-features li i { color: var(--primary); }
        .driver .role-features li i { color: var(--success); }
        .admin .role-features li i { color: #6366f1; }

        .role-btn {
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 14px;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            font-size: 0.95rem;
        }

        .passenger .role-btn {
            color: var(--primary);
            border: 2px solid rgba(79, 70, 229, 0.3);
            background: transparent;
        }
        .passenger .role-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
        }

        .driver .role-btn {
            color: white;
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }
        .driver .role-btn:hover {
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);
            transform: translateY(-1.5px);
            color: white;
        }

        .admin .role-btn {
            color: white;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.2);
        }
        .admin .role-btn:hover {
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
            transform: translateY(-1.5px);
            color: white;
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 7rem 2rem;
            background-color: #ffffff;
            position: relative;
        }
        .testimonial-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 2.5rem 2rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .testimonial-card:hover {
            border-color: rgba(16, 185, 129, 0.2);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.05);
            transform: translateY(-5px);
        }
        .testimonial-stars {
            color: #fbbf24;
            font-size: 1.1rem;
            margin-bottom: 1.25rem;
        }
        .testimonial-text {
            color: var(--slate-600);
            font-size: 1rem;
            line-height: 1.7;
            font-style: italic;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }
        .testimonial-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            font-family: var(--font-heading);
            border: 1px solid rgba(79, 70, 229, 0.15);
        }
        .testimonial-info h5 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--dark);
        }
        .testimonial-info p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--success);
            font-weight: 600;
        }

        /* CTA Section */
        .cta-section {
            padding: 7.5rem 2rem;
            margin: 0 2rem 5rem;
            border-radius: 36px;
            background: linear-gradient(135deg, var(--dark) 0%, #1e1b4b 60%, var(--primary) 100%);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(79, 70, 229, 0.15);
            transition: var(--transition);
        }

        .cta-section:hover {
            transform: scale(1.005);
            box-shadow: 0 35px 80px rgba(79, 70, 229, 0.25);
        }

        .cta-grid {
            position: absolute;
        .cta-glow {
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.25) 0%, transparent 70%);
            bottom: -150px;
            right: -100px;
            filter: blur(50px);
            pointer-events: none;
        }

        .cta-content {
            position: relative;
            z-index: 5;
            max-width: 750px;
            margin: 0 auto;
        }

        .cta-content h2 {
            font-size: 2.8rem;
            margin-bottom: 1.4rem;
            font-weight: 800;
        }

        .cta-content p {
            color: rgba(241, 245, 249, 0.85);
            font-size: 1.2rem;
            line-height: 1.7;
            margin-bottom: 2.8rem;
        }

        .btn-register-now {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            color: white;
            font-weight: 700;
            padding: 1rem 2.6rem;
            border-radius: 14px;
            font-size: 1.05rem;
            border: none;
            transition: var(--transition);
            box-shadow: 0 4px 18px rgba(16, 185, 129, 0.3);
            margin-right: 14px;
        }

        .btn-register-now:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
        }

        .btn-login-white {
            background-color: transparent;
            color: white;
            font-weight: 700;
            padding: 1rem 2.6rem;
            border-radius: 14px;
            font-size: 1.05rem;
            border: 2px solid rgba(255, 255, 255, 0.4);
            transition: var(--transition);
        }

        .btn-login-white:hover {
            background-color: white;
            color: var(--dark);
            border-color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.15);
        }

        /* Back to top floating button */
        .btn-back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px;
            height: 48px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            cursor: pointer;
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .btn-back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .btn-back-to-top:hover {
            background-color: var(--primary-hover);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.45);
        }

        /* Footer bottom */
        .footer-bottom {
            padding: 2.5rem 2rem;
            background-color: var(--dark);
            color: #94a3b8;
            font-size: 0.95rem;
            text-align: center;
            border-top: 1px solid #1e293b;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* About Section Styles */
        .about-section {
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }
        .about-image-card {
            transition: var(--transition);
        }
        .about-image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.12) !important;
        }

        /* How It Works Steps Flex */
        .steps-flex-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
            margin-top: 3rem;
        }
        .step-card-wrapper {
            flex: 1 1 200px;
            max-width: 220px;
        }
        @media (max-width: 767.98px) {
            .step-card-wrapper {
                max-width: 100%;
                width: 100%;
            }
        }

        /* Contact Section Styles */
        .contact-card {
            transition: var(--transition);
        }
        .contact-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08) !important;
            border-color: rgba(79, 70, 229, 0.15) !important;
        }
        .contact-icon {
            transition: var(--transition);
        }
        .contact-card:hover .contact-icon {
            transform: scale(1.1);
        }

        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.8rem;
            }
            .hero-title::after {
                margin-left: auto;
                margin-right: auto;
            }
            .hero-section {
                min-height: auto;
                padding-top: 5rem;
                padding-bottom: 4.5rem;
                text-align: center;
                background:
                    linear-gradient(180deg, rgba(248, 250, 252, 0.92) 0%, rgba(248, 250, 252, 0.78) 56%, rgba(248, 250, 252, 0.54) 100%),
                    url('{{ asset('images/modern_city_bg.jpg') }}') center / cover no-repeat;
            }
            .hero-section .row {
                min-height: auto;
            }
            .hero-description {
                margin-left: auto;
                margin-right: auto;
            }
            .btn-search-outline {
                margin-left: 0;
                margin-top: 1rem;
                display: block;
                width: 100%;
            }
            .btn-get-started {
                display: block;
                width: 100%;
            }
            .tracking-card {
                margin-top: 0;
                max-width: 100%;
            }
            .search-outer-container {
                margin-top: 0;
                padding-top: 2rem;
            }
            .btn-swap-locations {
                right: 20px;
                top: auto;
                bottom: -19px;
                transform: rotate(90deg);
            }
            .btn-swap-locations:hover {
                transform: rotate(270deg);
            }
            .stat-box {
                margin-bottom: 2rem;
            }
            .operators-logo-container {
                gap: 20px;
            }
            .cta-section {
                margin: 0 1rem 3rem;
                border-radius: 24px;
                padding: 4rem 1.5rem;
            }
            .cta-content h2 {
                font-size: 2.2rem;
            }
            .btn-register-now {
                margin-right: 0;
                margin-bottom: 1rem;
                display: block;
                width: 100%;
            }
            .btn-login-white {
                display: block;
                width: 100%;
            }
            .btn-back-to-top {
                bottom: 20px;
                right: 20px;
                width: 42px;
                height: 42px;
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glow Background Blobs -->
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>
    <div class="ambient-glow-3"></div>

    <!-- Floating Decor Circles -->
    <div class="decor-circle decor-circle-1"></div>
    <div class="decor-circle decor-circle-2"></div>
    <div class="decor-circle decor-circle-3"></div>

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid max-width-container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-bus-front-fill"></i> BusLink
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    @auth
                        <div class="dropdown">
                            <a class="btn btn-login dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="border-radius: 16px;">
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item py-2.5 px-3 rounded-3" href="/admin/dashboard"><i class="bi bi-speedometer2 me-2"></i> Admin Dashboard</a></li>
                                @elseif(Auth::user()->role === 'driver')
                                    <li><a class="dropdown-item py-2.5 px-3 rounded-3" href="/driver/dashboard"><i class="bi bi-speedometer2 me-2"></i> Driver Dashboard</a></li>
                                @else
                                    <li><a class="dropdown-item py-2.5 px-3 rounded-3" href="/passenger/dashboard"><i class="bi bi-speedometer2 me-2"></i> Passenger Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider my-1.5 opacity-50"></li>
                                <li><a class="dropdown-item py-2.5 px-3 rounded-3 text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="/login" class="nav-link me-3 fw-bold">Login</a>
                        <a href="/register" class="btn btn-login d-flex align-items-center gap-2">
                            <i class="bi bi-person-plus-fill"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 px-lg-5">
                    <span class="hero-badge">
                        <i class="bi bi-bus-front"></i> Travel Smarter with BusLink
                    </span>
                    <h1 class="hero-title">Travel Smarter<br>with <span>BusLink</span></h1>
                    <p class="hero-description">Find buses, book seats, and track your journey in real time with our Smart Bus Management System.</p>
                    
                    <div class="d-sm-flex">
                        <a href="/register" class="btn btn-get-started d-inline-flex align-items-center gap-2">
                            <i class="bi bi-rocket-takeoff-fill"></i> Get Started
                        </a>
                        <a href="/login" class="btn btn-search-outline d-inline-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-6 px-lg-5 mt-5 mt-lg-0 text-center hero-visual-column">
                    <!-- Live Tracking Widget -->
                    <div class="tracking-card text-start">
                        <div class="tracking-header">
                            <div class="tracking-title">
                                <i class="bi bi-geo-alt-fill"></i> Live Tracking
                            </div>
                            <span class="tracking-status">Active</span>
                        </div>
                        
                        <div class="map-viewport">
                            <div class="map-grid-pattern"></div>
                            <div class="route-line"></div>
                            <div class="animated-bus-indicator">
                                <i class="bi bi-bus-front-fill"></i>
                            </div>
                        </div>
                        
                        <div class="tracking-stats">
                            <div class="stat-item">
                                <label>Bus</label>
                                <span>SB-1042</span>
                            </div>
                            <div class="stat-item highlight">
                                <label>ETA</label>
                                <span>12 min</span>
                            </div>
                            <div class="stat-item">
                                <label>Speed</label>
                                <span>42 km/h</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-down-wrapper d-none d-lg-block">
            <a href="#search" class="scroll-down-mouse">
                <span class="scroll-wheel"></span>
            </a>
        </div>
    </section>

    <!-- Floating Search Section -->
    <div class="search-outer-container" id="search">
        <div class="search-card-wrapper">
            <h4><i class="bi bi-search"></i> Find & Book Available Buses</h4>
            
            <form method="POST" action="/search-buses">
                @csrf
                <div class="row g-4 align-items-end">
                    <div class="col-lg-4 position-relative">
                        <label for="departure" class="form-label-custom">Departure Location</label>
                        <div class="input-group-custom">
                            <i class="bi bi-geo-alt"></i>
                            <select name="from" id="departure" required>
                                <option value="" disabled selected>Select origin location</option>
                                @foreach($startLocations as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down select-arrow-icon"></i>
                        </div>
                        <button type="button" class="btn-swap-locations" id="btnSwapLocations" title="Swap Locations">
                            <i class="bi bi-arrow-left-right"></i>
                        </button>
                    </div>
                    
                    <div class="col-lg-4">
                        <label for="destination" class="form-label-custom">Destination Location</label>
                        <div class="input-group-custom">
                            <i class="bi bi-geo-fill"></i>
                            <select name="to" id="destination" required>
                                <option value="" disabled selected>Select destination location</option>
                                @foreach($endLocations as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down select-arrow-icon"></i>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <label for="travel_date" class="form-label-custom">Travel Date</label>
                        <div class="input-group-custom">
                            <i class="bi bi-calendar3"></i>
                            <input type="date" id="travel_date" name="travel_date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="date-shortcuts">
                            <button type="button" class="btn-date-shortcut active" id="btnToday">Today</button>
                            <button type="button" class="btn-date-shortcut" id="btnTomorrow">Tomorrow</button>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-search-submit" style="margin-bottom: 2px;">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Key Stats Strip -->
    <section class="stats-strip">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-box">
                        <i class="bi bi-bus-front mb-3 d-block" style="font-size: 1.8rem; color: var(--primary);"></i>
                        <h2>{{ $busesCount }}</h2>
                        <p>Buses</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-box">
                        <i class="bi bi-compass mb-3 d-block" style="font-size: 1.8rem; color: var(--success);"></i>
                        <h2>{{ $routesCount }}</h2>
                        <p>Routes</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-box">
                        <i class="bi bi-person-badge mb-3 d-block" style="font-size: 1.8rem; color: var(--accent);"></i>
                        <h2>{{ $driversCount }}</h2>
                        <p>Drivers</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-box">
                        <i class="bi bi-people mb-3 d-block" style="font-size: 1.8rem; color: var(--primary-light);"></i>
                        <h2>{{ $passengersCount }}</h2>
                        <p>Passengers</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section py-5" id="about">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 pe-lg-5">
                    <span class="hero-badge" style="margin-bottom: 1rem;">
                        <i class="bi bi-info-circle-fill"></i> About BusLink
                    </span>
                    <h2 class="section-title mb-4" style="font-size: 2.5rem; font-weight: 800; color: var(--dark);">Smarter Transit for a <br><span>Connected Tomorrow</span></h2>
                    <p class="about-description mb-4" style="color: var(--slate-600); font-size: 1.05rem; line-height: 1.7;">
                        BusLink is a next-generation Smart Bus Management System designed to bridge the gap between bus operators, drivers, and passengers. By using advanced GPS tracking, real-time seat reservation layouts, and a seamless dashboard for administrators, we guarantee an effortless and efficient travel experience for everyone.
                    </p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-round bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border-radius: 50%; font-size: 1.3rem;">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Save Time</h6>
                                    <small class="text-muted">No queue lines, book in seconds</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-round bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border-radius: 50%; font-size: 1.3rem;">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">100% Secure</h6>
                                    <small class="text-muted">Safe booking & verification</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                    <div class="about-image-card" style="border-radius: 24px; overflow: hidden; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 20px 45px rgba(15, 23, 42, 0.04);">
                        <img src="{{ asset('images/modern_city_bg.jpg') }}" alt="BusLink Cityscape" style="width: 100%; height: 320px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted Operators Partner Showcase -->
    <div class="operators-strip text-center py-5">
        <p class="text-uppercase text-muted small fw-bold mb-4" style="letter-spacing: 2px;">In Partnership With Top Operators</p>
        <div class="container operators-logo-container">
            <div class="operator-logo"><i class="bi bi-compass"></i> WayFinder</div>
            <div class="operator-logo"><i class="bi bi-cursor"></i> RouteExpress</div>
            <div class="operator-logo"><i class="bi bi-globe2"></i> CityTransit</div>
            <div class="operator-logo"><i class="bi bi-lightning-charge"></i> QuickRide</div>
        </div>
    </div>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-header text-center">
                <h2>How It Works</h2>
                <p>Getting your ticket and traveling is quick and effortless. Follow these simple steps.</p>
            </div>
            
            <div class="steps-flex-container d-flex flex-wrap justify-content-center gap-4">
                <div class="step-card-wrapper">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <i class="bi bi-person-plus-fill mb-3 d-block" style="font-size: 2.2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        <h5>Register</h5>
                        <p>Create a secure passenger account on our portal to start booking.</p>
                    </div>
                </div>
                <div class="step-card-wrapper">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <i class="bi bi-search mb-3 d-block" style="font-size: 2.2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        <h5>Search Bus</h5>
                        <p>Select your origin, destination, date, and browse available routes.</p>
                    </div>
                </div>
                <div class="step-card-wrapper">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <i class="bi bi-layout-three-columns mb-3 d-block" style="font-size: 2.2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        <h5>Book Seat</h5>
                        <p>Choose your preferred seat from the layout and book instantly.</p>
                    </div>
                </div>
                <div class="step-card-wrapper">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <i class="bi bi-geo-alt-fill mb-3 d-block" style="font-size: 2.2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        <h5>Track Live</h5>
                        <p>Track your bus location in real-time as it arrives at your stop.</p>
                    </div>
                </div>
                <div class="step-card-wrapper">
                    <div class="step-card">
                        <div class="step-number">5</div>
                        <i class="bi bi-bus-front mb-3 d-block" style="font-size: 2.2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        <h5>Travel</h5>
                        <p>Board the bus, verify your booking ticket, and enjoy your comfortable ride.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Our Features</h2>
                <p>Everything you need for a comfortable and well-managed journey with BusLink.</p>
            </div>
            
            <div class="row g-4">
                <!-- Feature 1: Search Bus -->
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper feature-icon-blue">
                            <i class="bi bi-search"></i>
                        </div>
                        <h5>Search Bus</h5>
                        <p>Easily search for available buses between different cities, check dates, schedules, and compare details instantly.</p>
                    </div>
                </div>
                
                <!-- Feature 2: Live Tracking -->
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper feature-icon-green">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h5>Live Tracking</h5>
                        <p>Track your assigned bus in real-time, view live locations, and get accurate arrival predictions on the map.</p>
                    </div>
                </div>
                
                <!-- Feature 3: Seat Booking -->
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper feature-icon-amber">
                            <i class="bi bi-ticket-perforated"></i>
                        </div>
                        <h5>Seat Booking</h5>
                        <p>View interactive bus seat layouts, choose your preferred window or aisle seats, and book instantly.</p>
                    </div>
                </div>

                <!-- Feature 4: Notifications -->
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper feature-icon-blue">
                            <i class="bi bi-bell"></i>
                        </div>
                        <h5>Notifications</h5>
                        <p>Get instant email or SMS updates on trip status, booking confirmations, schedules, and driver assignments.</p>
                    </div>
                </div>

                <!-- Feature 5: Driver Dashboard -->
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper feature-icon-green">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <h5>Driver Dashboard</h5>
                        <p>A simple interface for drivers to share live location, view passengers, and manage schedule updates.</p>
                    </div>
                </div>

                <!-- Feature 6: Admin Dashboard -->
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper feature-icon-amber">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h5>Admin Dashboard</h5>
                        <p>Complete web portal to manage routes, buses, schedules, driver assignments, bookings, and user accounts.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Role Dashboards Section -->
    <section class="roles-section" id="services">
        <div class="container">
            <div class="section-header">
                <h2>Built for Every Role</h2>
                <p>Tailored dashboards for passengers, drivers, and administrators to maximize utility for all users.</p>
            </div>
            
            <div class="row g-4">
                <!-- Passenger Dashboard Card -->
                <div class="col-lg-4">
                    <div class="role-card passenger">
                        <div class="role-header">
                            <div class="role-icon">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="role-title">
                                <h4>Passenger</h4>
                                <p>Travel with ease</p>
                            </div>
                        </div>
                        <ul class="role-features">
                            <li><i class="bi bi-check-circle-fill"></i> Search & compare buses</li>
                            <li><i class="bi bi-check-circle-fill"></i> Book seats online</li>
                            <li><i class="bi bi-check-circle-fill"></i> Track buses live</li>
                            <li><i class="bi bi-check-circle-fill"></i> View booking history</li>
                            <li><i class="bi bi-check-circle-fill"></i> Receive notifications</li>
                        </ul>
                        @auth
                            <a href="/passenger/dashboard" class="role-btn">Passenger Dashboard &rarr;</a>
                        @else
                            <a href="/login?role=passenger" class="role-btn">Passenger Dashboard &rarr;</a>
                        @endauth
                    </div>
                </div>
                
                <!-- Driver Dashboard Card -->
                <div class="col-lg-4">
                    <div class="role-card driver">
                        <div class="role-header">
                            <div class="role-icon">
                                <i class="bi bi-card-list"></i>
                            </div>
                            <div class="role-title">
                                <h4>Driver</h4>
                                <p>Manage your trips</p>
                            </div>
                        </div>
                        <ul class="role-features">
                            <li><i class="bi bi-check-circle-fill"></i> View assigned trips</li>
                            <li><i class="bi bi-check-circle-fill"></i> Update trip status</li>
                            <li><i class="bi bi-check-circle-fill"></i> Share live location</li>
                            <li><i class="bi bi-check-circle-fill"></i> Receive schedule updates</li>
                        </ul>
                        @auth
                            <a href="/driver/dashboard" class="role-btn">Driver Dashboard &rarr;</a>
                        @else
                            <a href="/login?role=driver" class="role-btn">Driver Dashboard &rarr;</a>
                        @endauth
                    </div>
                </div>
                
                <!-- Administrator Dashboard Card -->
                <div class="col-lg-4">
                    <div class="role-card admin">
                        <div class="role-header">
                            <div class="role-icon">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <div class="role-title">
                                <h4>Admin</h4>
                                <p>Full system control</p>
                            </div>
                        </div>
                        <ul class="role-features">
                            <li><i class="bi bi-check-circle-fill"></i> Manage buses & routes</li>
                            <li><i class="bi bi-check-circle-fill"></i> Manage schedules & drivers</li>
                            <li><i class="bi bi-check-circle-fill"></i> Manage passengers</li>
                            <li><i class="bi bi-check-circle-fill"></i> View analytics & reports</li>
                        </ul>
                        @auth
                            <a href="/admin/dashboard" class="role-btn">Admin Dashboard &rarr;</a>
                        @else
                            <a href="/login?role=admin" class="role-btn">Admin Dashboard &rarr;</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="testimonials-section" id="reviews">
        <div class="container max-width-container">
            <div class="section-header text-center">
                <h2>What Our Passengers Say</h2>
                <p>Read reviews and experiences from thousands of commuters using BusLink daily.</p>
            </div>
            
            <div class="row g-4 justify-content-center mt-3">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div>
                            <div class="testimonial-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">
                                "Booking seats through BusLink is incredibly convenient. The live tracking feature is a game-changer! I no longer have to wait at the bus stop for hours."
                            </p>
                        </div>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar">SP</div>
                            <div class="testimonial-info">
                                <h5>Sanduni Perera</h5>
                                <p>Passenger (Colombo - Galle)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div>
                            <div class="testimonial-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">
                                "I love the cashless booking and the simple interface. The drivers are professional, and the buses are always on time. Highly recommended!"
                            </p>
                        </div>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar">AS</div>
                            <div class="testimonial-info">
                                <h5>Amara Silva</h5>
                                <p>Passenger (Kandy - Colombo)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div>
                            <div class="testimonial-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p class="testimonial-text">
                                "The support team is very responsive. I had a query regarding cancellations and they resolved it in minutes. Excellent customer service!"
                            </p>
                        </div>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar">TB</div>
                            <div class="testimonial-info">
                                <h5>Thisara Bandara</h5>
                                <p>Passenger (Negombo - Ella)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section py-5" id="contact" style="background-color: rgba(248, 250, 252, 0.6); border-top: 1px solid rgba(226, 232, 240, 0.5); border-bottom: 1px solid rgba(226, 232, 240, 0.5);">
        <div class="container py-4">
            <div class="section-header text-center">
                <h2>Contact Us</h2>
                <p>Have questions or need assistance? Reach out to our support team anytime.</p>
            </div>
            
            <div class="row g-4 justify-content-center mt-3">
                <div class="col-md-4 col-sm-6">
                    <div class="contact-card text-center p-4 bg-white rounded-4 shadow-sm border border-light-subtle h-100">
                        <div class="contact-icon bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.6rem;">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Our Address</h5>
                        <p class="text-muted mb-0">120 street, Smart City, colombo</p>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <div class="contact-card text-center p-4 bg-white rounded-4 shadow-sm border border-light-subtle h-100">
                        <div class="contact-icon bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.6rem;">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Phone Number</h5>
                        <p class="text-muted mb-0">+94 788508456<br>+94 742859361</p>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-12">
                    <div class="contact-card text-center p-4 bg-white rounded-4 shadow-sm border border-light-subtle h-100">
                        <div class="contact-icon bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.6rem;">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Email Address</h5>
                        <p class="text-muted mb-0">support@buslink.com<br>info@buslink.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Call to Action -->
    <section class="cta-section">
        <div class="cta-grid"></div>
        <div class="cta-glow"></div>
        <div class="cta-content">
            <h2>Ready to Transform Your Bus Operations?</h2>
            <p>Join thousands of operators using BusLink to deliver exceptional passenger experiences, boost bookings, and run seamless bus fleets.</p>
            
            <div class="d-sm-flex justify-content-center">
                <a href="/register" class="btn btn-register-now d-inline-flex align-items-center gap-2 mb-3 mb-sm-0">
                    <i class="bi bi-person-plus-fill"></i> Register Now
                </a>
                <a href="/login" class="btn btn-login-white d-inline-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            </div>
        </div>
    </section>

    <!-- Floating Back to Top Button -->
    <button type="button" class="btn-back-to-top" id="btnBackToTop" title="Back to Top">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container text-center">
            &copy; {{ date('Y') }} BusLink Platform. All rights reserved.
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript Handlers for User-Friendly Actions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Swap Locations Action
            const btnSwap = document.getElementById('btnSwapLocations');
            const departureSelect = document.getElementById('departure');
            const destinationSelect = document.getElementById('destination');

            if (btnSwap && departureSelect && destinationSelect) {
                btnSwap.addEventListener('click', function() {
                    const tempVal = departureSelect.value;
                    departureSelect.value = destinationSelect.value;
                    destinationSelect.value = tempVal;
                    
                    // Animate the icon swap
                    const icon = btnSwap.querySelector('i');
                    icon.style.transition = 'transform 0.4s ease';
                    icon.style.transform = icon.style.transform === 'rotate(180deg)' ? 'rotate(0deg)' : 'rotate(180deg)';
                });
            }

            // Quick Date Shortcuts Action
            const btnToday = document.getElementById('btnToday');
            const btnTomorrow = document.getElementById('btnTomorrow');
            const travelDateInput = document.getElementById('travel_date');

            const formatDate = (date) => {
                const yyyy = date.getFullYear();
                const mm = String(date.getMonth() + 1).padStart(2, '0');
                const dd = String(date.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            };

            if (travelDateInput) {
                const todayStr = formatDate(new Date());
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const tomorrowStr = formatDate(tomorrow);

                const updatePills = () => {
                    const currentVal = travelDateInput.value;
                    if (currentVal === todayStr) {
                        btnToday?.classList.add('active');
                        btnTomorrow?.classList.remove('active');
                    } else if (currentVal === tomorrowStr) {
                        btnTomorrow?.classList.add('active');
                        btnToday?.classList.remove('active');
                    } else {
                        btnToday?.classList.remove('active');
                        btnTomorrow?.classList.remove('active');
                    }
                };

                travelDateInput.addEventListener('change', updatePills);
                updatePills(); // Initial call

                if (btnToday) {
                    btnToday.addEventListener('click', function(e) {
                        e.preventDefault();
                        travelDateInput.value = todayStr;
                        updatePills();
                    });
                }

                if (btnTomorrow) {
                    btnTomorrow.addEventListener('click', function(e) {
                        e.preventDefault();
                        travelDateInput.value = tomorrowStr;
                        updatePills();
                    });
                }
            }

            // Back To Top Floating Action Button
            const btnBackToTop = document.getElementById('btnBackToTop');
            if (btnBackToTop) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 400) {
                        btnBackToTop.classList.add('show');
                    } else {
                        btnBackToTop.classList.remove('show');
                    }
                });

                btnBackToTop.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        });
    </script>

    <!-- Chatbot Component -->
    <x-chatbot />

</body>
</html>
