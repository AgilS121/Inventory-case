<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Stok Barang - Welcome</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .welcome-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            margin: 20px;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        .welcome-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #1e40af, #1d4ed8);
            border-radius: 20px 20px 0 0;
        }

        .icon-container {
            margin-bottom: 30px;
            position: relative;
        }

        .main-icon {
            font-size: 4rem;
            color: #3b82f6;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        .floating-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .floating-icon {
            position: absolute;
            color: rgba(59, 130, 246, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        .floating-icon:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 20%; right: 15%; animation-delay: 0.5s; }
        .floating-icon:nth-child(3) { bottom: 30%; left: 10%; animation-delay: 1s; }
        .floating-icon:nth-child(4) { bottom: 20%; right: 20%; animation-delay: 1.5s; }

        h1 {
            color: #1e40af;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .subtitle {
            color: #64748b;
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .description {
            color: #64748b;
            font-size: 1rem;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .btn-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            min-width: 140px;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .features {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .feature {
            background: rgba(59, 130, 246, 0.1);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.2);
        }

        .feature i {
            color: #3b82f6;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .feature h3 {
            color: #1e40af;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .feature p {
            color: #64748b;
            font-size: 0.8rem;
            line-height: 1.4;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @media (max-width: 768px) {
            .welcome-container {
                padding: 40px 20px;
                margin: 10px;
            }

            h1 {
                font-size: 2rem;
            }

            .subtitle {
                font-size: 1.1rem;
            }

            .btn-container {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="floating-icons">
            <i class="fas fa-boxes floating-icon"></i>
            <i class="fas fa-chart-line floating-icon"></i>
            <i class="fas fa-warehouse floating-icon"></i>
            <i class="fas fa-clipboard-check floating-icon"></i>
        </div>
        
        <div class="icon-container">
            <i class="fas fa-cube main-icon"></i>
        </div>

        <h1>Dashboard Stok Barang</h1>
        <p class="subtitle">Kelola Inventori dengan Mudah & Efisien</p>
        <p class="description">
            Platform manajemen stok yang dirancang khusus untuk membantu Admin dan Operator 
            mengelola inventori secara real-time dengan akurasi tinggi dan keamanan terjamin.
        </p>

        <div class="btn-container">
            <a href="/login" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Masuk
            </a>
            <a href="/register" class="btn btn-success">
                <i class="fas fa-user-plus"></i>
                Daftar
            </a>
        </div>

        <div class="features">
            <div class="feature">
                <i class="fas fa-clock"></i>
                <h3>Real-Time</h3>
                <p>Pantau stok secara langsung</p>
            </div>
            <div class="feature">
                <i class="fas fa-shield-alt"></i>
                <h3>Aman</h3>
                <p>Data terlindungi dengan enkripsi</p>
            </div>
            <div class="feature">
                <i class="fas fa-chart-bar"></i>
                <h3>Akurat</h3>
                <p>Laporan detail dan presisi</p>
            </div>
        </div>
    </div>
</body>
</html>