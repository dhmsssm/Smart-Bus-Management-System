<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SmartBus - Next-Gen Transport Platform</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#F5F7FB;
        }

        .sidebar{
            position:fixed;
            left:0;
            top:0;
            width:250px;
            height:100vh;
            background:#0f172a;
            color:white;
            overflow-y:auto;
            transition:.3s;
            z-index:999;
        }

        .logo{
            padding:25px;
            font-size:24px;
            font-weight:700;
            border-bottom:1px solid rgba(255,255,255,.08);
        }

        .logo small{
            display:block;
            color:#9CA3AF;
            font-size:13px;
            margin-top:4px;
        }

        .sidebar-menu{
            margin-top:20px;
        }

        .sidebar-menu a{
            display:flex;
            align-items:center;
            gap:12px;
            color:white;
            text-decoration:none;
            padding:15px 25px;
            transition:.3s;
            border-left:4px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu .active{
            background:#1e293b;
            border-left-color:#3b82f6;
        }

        .driver-sidebar{
            display:flex;
            flex-direction:column;
            background:#0f172a;
        }

        .driver-brand{
            display:flex;
            align-items:center;
            gap:12px;
            padding:18px 22px;
            border-bottom:1px solid rgba(255,255,255,.08);
        }

        .brand-icon{
            width:38px;
            height:38px;
            border-radius:8px;
            background:#16A34A;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
        }

        .brand-title{
            color:white;
            font-size:18px;
            font-weight:700;
            line-height:1.1;
        }

        .driver-brand small{
            display:block;
            color:#9CA3AF;
            font-size:11px;
            letter-spacing:.8px;
            margin-top:2px;
        }

        .driver-section-label{
            padding:26px 22px 8px;
            color:#8B95A7;
            font-size:11px;
            letter-spacing:1.6px;
        }

        .driver-menu{
            margin-top:0;
            flex:1;
        }

        .driver-menu a{
            color:#CBD5E1;
            padding:14px 22px;
            border-left-width:3px;
        }

        .driver-menu a:hover,
        .driver-menu .active{
            color:white;
            background:#1e293b;
            border-left-color:#10b981;
            font-weight:600;
        }

        .driver-user{
            display:flex;
            align-items:center;
            gap:12px;
            padding:16px 22px;
            border-top:1px solid rgba(255,255,255,.08);
        }

        .driver-avatar{
            width:36px;
            height:36px;
            border-radius:50%;
            background:#F59E0B;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:12px;
            font-weight:700;
            flex-shrink:0;
        }

        .driver-user-name{
            min-width:0;
            flex:1;
        }

        .driver-user-name strong,
        .driver-user-name small{
            display:block;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .driver-user-name strong{
            color:white;
            font-size:13px;
        }

        .driver-user-name small{
            color:#9CA3AF;
            font-size:12px;
        }

        .driver-logout{
            color:#9CA3AF;
            text-decoration:none;
        }

        .driver-logout:hover{
            color:white;
        }

        .main{
            margin-left:250px;
            transition:.3s;
        }

        .topbar{
            min-height:75px;
            background:white;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
            padding:0 30px;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
        }

        .search-box{
            width:350px;
        }

        .search-box input{
            border-radius:30px;
        }

        .profile{
            display:flex;
            align-items:center;
            gap:15px;
            flex-shrink:0;
        }

        .avatar{
            width:45px;
            height:45px;
            border-radius:50%;
            background:#3b82f6;
            color:white;
            display:flex;
            justify-content:center;
            align-items:center;
            font-weight:bold;
        }

        .content{
            padding:30px;
        }

        .card-box{
            background:white;
            border:none;
            border-radius:12px;
            box-shadow:0 2px 12px rgba(0,0,0,.05);
            transition:.3s;
        }

        .card-box:hover{
            transform:translateY(-4px);
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }

        .sidebar-collapse .sidebar{
            width:80px;
        }

        .sidebar-collapse .main{
            margin-left:80px;
        }

        .sidebar-collapse .logo small,
        .sidebar-collapse .driver-brand small,
        .sidebar-collapse .brand-title,
        .sidebar-collapse .driver-section-label,
        .sidebar-collapse .driver-user-name,
        .sidebar-collapse .menu-text{
            display:none;
        }

        @media(max-width:992px){
            .sidebar{
                left:-250px;
            }

            .sidebar.show{
                left:0;
            }

            .main,
            .sidebar-collapse .main{
                margin-left:0;
            }

            .topbar{
                padding:15px;
            }

            .search-box{
                width:100%;
            }
        }
    </style>
</head>

<body>
@if(request()->is('admin/*'))
    @include('admin.sidebar')
@elseif(request()->is('driver/*'))
    @include('driver.sidebar')
@else
    @include('passenger.sidebar')
@endif

<div class="main">
    @if(request()->is('admin/*'))
        @include('admin.topbar')
    @elseif(request()->is('driver/*'))
        @include('driver.topbar')
    @else
        @include('passenger.topbar')
    @endif

    <div class="content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const menuToggle = document.getElementById('menuToggle');

if (menuToggle) {
    menuToggle.addEventListener('click', function () {
        document.querySelector('.sidebar').classList.toggle('show');
    });
}

const desktopToggle = document.getElementById('desktopToggle');

if (desktopToggle) {
    desktopToggle.addEventListener('click', function () {
        document.body.classList.toggle('sidebar-collapse');
    });
}
</script>
</body>
</html>
