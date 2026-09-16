<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="PM Industries ERP - Enterprise Resource Planning System for managing sales, purchases, inventory, production, accounts, customers, suppliers and business operations.">
    <meta name="keywords"
        content="PM Industries ERP, RCC Pipe ERP, Hume Pipe ERP, Manufacturing ERP, Production Management, Inventory Management, Sales Management, Purchase Management, Accounting ERP, Nagpur">

    <!-- Page Title & logo -->
    <title>Choose Company | PM Industries ERP</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/dist/img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/dist/img/logo.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Inter, "Segoe UI", Arial, sans-serif
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at 10% 15%, rgba(230, 126, 34, .16), transparent 30%), radial-gradient(circle at 90% 85%, rgba(52, 73, 94, .45), transparent 35%), linear-gradient(135deg, #101820 0%, #17202A 45%, #263746 100%)
        }

        body::before {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .045);
            top: -270px;
            left: -200px;
            pointer-events: none
        }

        body::after {
            content: "";
            position: absolute;
            width: 680px;
            height: 680px;
            border-radius: 50%;
            border: 1px solid rgba(230, 126, 34, .07);
            bottom: -390px;
            right: -270px;
            pointer-events: none
        }

        .card {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 5;
            padding: 34px 32px 28px;
            color: #F8F9FA;
            background: rgba(255, 255, 255, .085);
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 22px;
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, .42), inset 0 1px 0 rgba(255, 255, 255, .07)
        }

        .logo {
            width: 105px;
            height: 105px;
            margin: 0 auto 15px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .96);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .22)
        }

        .logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain
        }

        h1 {
            text-align: center;
            color: #FFF;
            font-size: 27px;
            line-height: 1.25;
            font-weight: 750;
            letter-spacing: -.5px;
            margin-bottom: 8px
        }

        .brand-line {
            width: 45px;
            height: 3px;
            margin: 0 auto 11px;
            border-radius: 5px;
            background: #E67E22
        }

        .input {
            position: relative;
            width: 100%;
            margin-bottom: 15px
        }

        .input>i:first-child {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #AEBBC7;
            font-size: 14px;
            z-index: 2;
            pointer-events: none
        }

        .input input,
        .input select {
            width: 100%;
            height: 48px;
            padding: 0 45px;
            color: #FFF;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, .10);
            border-radius: 11px;
            outline: none;
            background: rgba(255, 255, 255, .10);
            transition: border-color .25s ease, background .25s ease, box-shadow .25s ease
        }

        .input input::placeholder {
            color: #AAB7C4;
            opacity: 1
        }

        .input input:focus,
        .input select:focus {
            border-color: rgba(230, 126, 34, .75);
            background: rgba(255, 255, 255, .14);
            box-shadow: 0 0 0 3px rgba(230, 126, 34, .12)
        }

        .input select {
            padding-right: 42px;
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer
        }

        .input select option {
            color: #212529;
            background: #FFF
        }

        .company-input::after {
            content: "\f078";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #AEBBC7;
            font-size: 11px;
            pointer-events: none
        }

        .eye {
            position: absolute;
            left: auto !important;
            right: 15px;
            top: 50% !important;
            transform: translateY(-50%);
            color: #AEBBC7;
            cursor: pointer;
            pointer-events: auto !important;
            transition: color .2s ease
        }

        .eye:hover {
            color: #F5B041
        }

        .btn {
            width: 100%;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 11px;
            color: #FFF;
            background: linear-gradient(135deg, #E67E22, #CA6F1E);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .4px;
            cursor: pointer;
            transition: transform .25s ease, box-shadow .25s ease, opacity .25s ease;
            box-shadow: 0 8px 18px rgba(230, 126, 34, .20)
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(230, 126, 34, .30)
        }

        .btn:active {
            transform: translateY(0)
        }

        .btn:disabled {
            opacity: .75;
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 5px 12px rgba(230, 126, 34, .12)
        }

        .secure-login {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 15px;
            color: #94A3B8;
            font-size: 11px
        }

        .secure-login i {
            color: #7FB069;
            font-size: 11px
        }

        .footer {
            text-align: center;
            color: #8E9BA7;
            font-size: 11px;
            line-height: 1.7;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, .08)
        }

        .footer strong {
            color: #DCE3E8;
            font-weight: 600
        }

        .footer a {
            color: #DCE3E8;
            text-decoration: none;
            transition: color .2s ease
        }

        .footer a:hover {
            color: #F5B041
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #FFF;
            -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, .10) inset;
            transition: background-color 5000s ease-in-out 0s
        }

        @media(max-width:576px) {
            body {
                padding: 15px
            }

            .card {
                padding: 28px 20px 22px;
                border-radius: 18px
            }

            .logo {
                width: 90px;
                height: 90px;
                border-radius: 15px;
                padding: 8px
            }

            h1 {
                font-size: 24px
            }

            .input input,
            .input select {
                height: 47px
            }

            .btn {
                height: 47px
            }
        }

        @media(max-width:360px) {
            .card {
                padding: 24px 16px 20px
            }

            .logo {
                width: 80px;
                height: 80px
            }

            h1 {
                font-size: 22px
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="logo">
            <img src="{{ asset('assets/dist/img/logo.png') }}" alt="PM Industries Logo">
        </div>

        <h1>PM Industries ERP</h1>
        <div class="brand-line"></div>

        <form action="{{ Route('selectComp') }}" method="POST" id="loginForm">
            @csrf

            <div class="input company-input">
                <i class="fas fa-building"></i>
                <select name="company_id" id="company_id" required>
                    <option value="" selected disabled>Choose Comopany</option>
                    @forelse($comp as $c)
                        <option value="{{ $c['code'].'|'.$c['name'] }}">{{ $c['name'] }}</option>
                    @empty
                        <option>No comopany available</option>
                    @endforelse
                </select>
            </div>

            <div class="input fyear-input">
                <i class="fas fa-calendar-days"></i>
                <select name="company_year" id="company_id" required>
                    <option value="3">2026-2027</option>
                    <option value="2">2025-2026</option>
                    <option value="1">2024-2025</option>
                </select>
            </div>

            <button type="submit" class="btn" id="loginBtn">
                <i class="fa-solid fa-right-to-bracket"></i>&nbsp; LOGIN TO ERP
            </button>
        </form>

        <div class="secure-login">
            <i class="fa-solid fa-shield-halved"></i>
            Secure &amp; Authorized Access Only
        </div>

        <div class="footer">
            Copyright &copy;
            <script>document.write(new Date().getFullYear());</script>
            <a href="https://cementpipenagpur.com/" target="_blank" rel="noopener noreferrer"><b>PM Industries</b></a> |
            Powered by
            <a href="https://abatechcal.com" target="_blank" rel="noopener noreferrer"><b>Abatech Solutions</b></a>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function checkCompany() {
                $('#loginBtn').prop('disabled', $('#company_id').val() === '');
            }
            $('#company_id').on('change', checkCompany);
            checkCompany();
        });

        document.getElementById("loginForm").addEventListener("submit", function (e) {
            const company = document.getElementById("company_id");
            const btn = document.getElementById("loginBtn");

            if (!company.value) {
                e.preventDefault();
                company.focus();
                return false;
            }

            if (btn.disabled) {
                e.preventDefault();
                return false;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>&nbsp; Signing In...';
        });
    </script>
</body>

</html>