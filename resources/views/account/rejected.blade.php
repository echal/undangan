<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pendaftaran Ditolak — UNDIGI</title>
  <link rel="icon" href="{{ asset('images/logo/undigi-logo.png') }}" type="image/png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Inter', sans-serif; }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%       { transform: translateX(-4px); }
      40%       { transform: translateX(4px); }
      60%       { transform: translateX(-4px); }
      80%       { transform: translateX(4px); }
    }
    .shake { animation: shake 0.5s ease 0.3s both; }
  </style>
</head>
<body class="bg-gradient-to-br from-red-50 via-white to-rose-50 min-h-screen flex items-center justify-center px-4">

  <div class="max-w-md w-full text-center">

    <!-- Icon -->
    <div class="relative inline-flex items-center justify-center mb-8">
      <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center shadow-inner shake">
        <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
        </svg>
      </div>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-xl shadow-red-100 p-8 sm:p-10">
      <div class="inline-flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 text-xs font-bold px-4 py-1.5 rounded-full mb-5">
        <span class="w-2 h-2 bg-red-400 rounded-full"></span>
        Pendaftaran Ditolak
      </div>

      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">
        Maaf, Akun Ditolak
      </h1>
      <p class="text-gray-500 leading-relaxed mb-6">
        Pendaftaran akun Anda tidak dapat kami setujui saat ini.<br>
        Silakan baca alasan di bawah dan hubungi kami jika ada pertanyaan.
      </p>

      @if(session('rejection_reason') || (isset($user) && $user->rejection_reason))
      <!-- Rejection Reason Box -->
      <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 text-left">
        <div class="flex items-start gap-3">
          <div class="w-5 h-5 rounded-full bg-red-200 flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div>
            <p class="text-xs font-bold text-red-700 mb-1">Alasan Penolakan</p>
            <p class="text-sm text-red-800 leading-relaxed">
              {{ session('rejection_reason') ?? ($user->rejection_reason ?? '-') }}
            </p>
          </div>
        </div>
      </div>
      @else
      <!-- Generic message if no reason stored -->
      <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 mb-6 text-left">
        <p class="text-sm text-gray-600 leading-relaxed">
          Tidak ada keterangan alasan yang diberikan. Silakan hubungi kami langsung untuk informasi lebih lanjut.
        </p>
      </div>
      @endif

      <!-- Steps (all grayed out) -->
      <div class="space-y-3 mb-8 text-left">
        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl">
          <div class="w-7 h-7 min-w-7 rounded-full bg-green-500 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-green-800">Akun dibuat</p>
            <p class="text-xs text-green-600">Data Anda telah tersimpan</p>
          </div>
        </div>

        <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl border border-red-200">
          <div class="w-7 h-7 min-w-7 rounded-full bg-red-400 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-red-800">Review admin — Ditolak</p>
            <p class="text-xs text-red-600">Pendaftaran tidak memenuhi persyaratan</p>
          </div>
        </div>

        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
          <div class="w-7 h-7 min-w-7 rounded-full bg-gray-200 flex items-center justify-center">
            <span class="text-gray-400 text-xs font-bold">3</span>
          </div>
          <div>
            <p class="text-sm font-semibold text-gray-400">Akses penuh</p>
            <p class="text-xs text-gray-400">Tidak tersedia saat ini</p>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="space-y-3">
        <a href="mailto:hello@undigi.id?subject=Permohonan%20Review%20Akun&body=Halo%20tim%20UNDIGI%2C%20saya%20ingin%20mengajukan%20permohonan%20review%20ulang%20untuk%20pendaftaran%20akun%20saya."
           class="block w-full py-3 px-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-purple-700 transition text-sm text-center shadow-md shadow-indigo-200">
          Ajukan Banding via Email
        </a>
        <a href="{{ route('register') }}"
           class="block w-full py-3 px-6 text-gray-600 font-medium rounded-xl border border-gray-200 hover:bg-gray-50 transition text-sm text-center">
          Daftar dengan Akun Baru
        </a>
        <a href="{{ route('landing') ?? '/' }}"
           class="block w-full py-3 px-6 text-gray-400 font-medium rounded-xl hover:bg-gray-50 transition text-sm text-center">
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
