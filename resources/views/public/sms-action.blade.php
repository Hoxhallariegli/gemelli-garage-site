<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemelli Garage - Rezervimi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">GEMELLI GARAGE</h1>

        @if($status === 'confirmed')
            <div class="text-green-600 mb-6">
                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-lg font-semibold">Rezervimi u konfirmua!</p>
            </div>
            <p class="text-gray-600">Ju faleminderit që zgjodhët Gemelli Garage. Ju presim në orar!</p>
        @elseif($status === 'cancelled')
            <div class="text-red-600 mb-6">
                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <p class="text-lg font-semibold">Rezervimi u anullua.</p>
            </div>
            <p class="text-gray-600">Rezervimi juaj u fshi me sukses. Nëse ndryshoni mendje, mund të rezervoni përsëri në faqen tonë.</p>
        @else
            <div class="text-yellow-600 mb-6">
                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-semibold">Kërkesa është përpunuar më parë.</p>
            </div>
            <p class="text-gray-600">Statusi i këtij rezervimi është përditësuar tashmë.</p>
        @endif

        <div class="mt-8">
            <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">
                Shko tek Faqja Kryesore
            </a>
        </div>
    </div>
</body>
</html>
