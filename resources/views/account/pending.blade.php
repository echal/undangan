<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menunggu Persetujuan — UNDIGI</title>
  <link rel="icon" href="{{ asset('images/logo/undigi-logo.png') }}" type="image/png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Inter', sans-serif; }
    @keyframes pulse-ring {
      0%   { transform: scale(0.8); opacity: 1; }
      100% { transform: scale(1.6); opacity: 0; }
    }
    .pulse-ring {
      animation: pulse-ring 1.8s cubic-bezier(.2,.6,.4,1) infinite;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen flex items-center justify-center px-4">

  <div class="max-w-md w-full text-center">

    <!-- Icon -->
    <div class="relative inline-flex items-center justify-center mb-8">
      <span class="pulse-ring absolute w-24 h-24 rounded-full bg-indigo-200 opacity-50"></span>
      <div class="relative w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center shadow-inner">
        <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
        </svg>
      </div>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100 p-8 sm:p-10">
      <div class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold px-4 py-1.5 rounded-full mb-5">
        <span class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></span>
        Menunggu Persetujuan
      </div>

      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">
        @if(session('pending_user_name'))
          Halo, {{ session('pending_user_name') }}! 🎉
        @else
          Registrasi Berhasil! 🎉
        @endif
      </h1>
      <p class="text-gray-500 leading-relaxed mb-6">
        Akun Anda sedang menunggu persetujuan dari tim kami.<br>
        Biasanya proses ini memakan waktu <strong class="text-gray-700">1×24 jam</strong>.
      </p>

      <!-- Steps -->
      <div class="space-y-3 mb-8 text-left">
        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl">
          <div class="w-7 h-7 min-w-7 rounded-full bg-green-500 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-green-800">Akun dibuat</p>
            <p class="text-xs text-green-600">Data Anda telah tersimpan dengan aman</p>
          </div>
        </div>

        <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-xl border border-amber-200">
          <div class="w-7 h-7 min-w-7 rounded-full bg-amber-400 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5"/>
            </svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-amber-800">Menunggu review admin</p>
            <p class="text-xs text-amber-600">Tim kami sedang memproses permintaan Anda</p>
          </div>
        </div>

        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
          <div class="w-7 h-7 min-w-7 rounded-full bg-gray-200 flex items-center justify-center">
            <span class="text-gray-400 text-xs font-bold">3</span>
          </div>
          <div>
            <p class="text-sm font-semibold text-gray-400">Akses penuh</p>
            <p class="text-xs text-gray-400">Buat undangan digital impian Anda</p>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="space-y-3">
        <a href="{{ route('login') }}"
           class="block w-full py-3 px-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-purple-700 transition text-sm text-center shadow-md shadow-indigo-200">
          Cek Status (Login)
        </a>
        <a href="{{ route('landing') ?? '/' }}"
           class="block w-full py-3 px-6 text-gray-600 font-medium rounded-xl border border-gray-200 hover:bg-gray-50 transition text-sm text-center">
          Kembali ke Beranda
        </a>
      </div>
    </div>

    <p class="mt-6 text-xs text-gray-400">
      Pertanyaan? Hubungi kami di
      <a href="mailto:hello@undigi.id" class="text-indigo-500 hover:underline">hello@undigi.id</a>
    </p>

  </div>

</body>
</html>
