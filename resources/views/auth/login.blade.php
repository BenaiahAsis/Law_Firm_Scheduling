<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Client Portal - Rosales Law Office</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-serif-custom { font-family: 'Playfair Display', serif; }
        .font-sans-custom { font-family: 'Inter', sans-serif; }
        
        /* OVERRIDE BROWSER AUTO-FILL COLORS */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #f8fafc inset !important;
            -webkit-text-fill-color: #0f172a !important; /* slate-900 text */
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="font-sans-custom text-slate-900 antialiased bg-slate-50 selection:bg-slate-900 selection:text-white">
    <div class="min-h-screen flex">
        
        <div class="hidden lg:flex lg:w-[60%] bg-slate-950 items-center justify-start relative overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-luminosity" style="background-image: url('{{ asset('images/library-bg.jpg') }}'); transition: transform 10s ease-out;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/60 to-slate-950/90"></div>
            
            <div class="relative z-10 p-12 lg:py-20 lg:pl-20 lg:pr-32 text-white max-w-4xl w-full flex flex-col justify-between h-full">
                
                <div class="pt-8">
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-xs font-semibold tracking-widest uppercase mb-8 text-slate-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 mr-3 animate-pulse"></span>
                        Secure Client Gateway
                    </div>
                    <h1 class="text-6xl lg:text-8xl font-serif-custom font-bold mb-6 tracking-tight leading-none">
                        Rosales Law <br><span class="text-slate-400">Office.</span>
                    </h1>
                    <div class="w-32 h-1 bg-white mb-10 opacity-20"></div>
                    <p class="text-2xl text-slate-200 leading-relaxed max-w-2xl font-light">
                        Attorney At Law &bull; Notary Public
                    </p>
                    <p class="text-lg text-slate-400 mt-3 font-medium">
                        Atty. Annie Rose B. Rosales, CPA
                    </p>
                </div>

                <div class="pb-8 mt-20">
                    <div class="flex flex-col space-y-6">
                        <div class="flex space-x-10 text-sm font-semibold text-slate-300 uppercase tracking-wider">
                            <div class="flex items-center"><svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> 256-Bit SSL Encryption</div>
                            <div class="flex items-center"><svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg> DPA Compliant</div>
                        </div>
                        <div class="border-t border-white/20 pt-6">
                            <p class="text-sm text-slate-300 leading-relaxed font-medium">
                                1st Flr., Door 16, El Court Bldg.<br>
                                Cor. Lacson & 1st St., Bacolod City
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="w-full lg:w-[40%] flex flex-col justify-center px-8 sm:px-16 py-12 bg-slate-50 relative">
            
            <div class="w-full max-w-[480px] mx-auto">
                
                <div class="mb-14">
                    <h2 class="text-4xl lg:text-5xl font-serif-custom font-bold text-slate-900 mb-4 tracking-tight">Welcome Back</h2>
                    <p class="text-base text-slate-500 font-medium leading-relaxed">Please enter your credentials to access your private case files and schedule consultations.</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-7">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5">Email Address</label>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none w-12 justify-center">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="client@example.com" class="block w-full pl-12 pr-4 py-4 bg-white border border-slate-300 rounded-xl text-base text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-all duration-200">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mt-1.5" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-slate-500 hover:text-slate-900 transition-colors" href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none w-12 justify-center">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required placeholder="••••••••••••" class="block w-full pl-12 pr-4 py-4 bg-white border border-slate-300 rounded-xl text-base text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-all duration-200">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mt-1.5" />
                    </div>

                    <div class="flex items-center pt-3">
                        <div class="flex items-center h-5">
                            <input id="remember_me" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer" name="remember">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember_me" class="font-semibold text-slate-600 cursor-pointer m-0">
                                Keep me signed in on this device
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-5 px-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all duration-200 mt-10 active:scale-[0.98]">
                        Sign In Securely
                    </button>
                </form>
                
                <div class="mt-14 text-center">
                    <p class="text-base text-slate-500 font-medium">
                        Need legal assistance? 
                        <a href="{{ route('register') }}" class="font-bold text-slate-900 hover:underline transition-colors ml-1">Request a consultation</a>
                    </p>
                </div>

            </div>
        </div>
        
    </div>
</body>
</html>