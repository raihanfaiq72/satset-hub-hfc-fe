<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - SatSet</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'satset-green': '#2d7a6e',
                        'satset-dark': '#246359'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen">

<div class="flex min-h-screen flex-col">

    <!-- Header -->
    <header class="fixed top-0 z-30 w-full px-5 py-4 flex items-center">
        <button onclick="window.history.back()"
            class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow">
            ←
        </button>
    </header>

    <!-- Main -->
    <main class="flex-1 pb-32">

        <!-- Banner -->
        <div class="w-full h-[220px] bg-gradient-to-br from-satset-green to-satset-dark"></div>

        <!-- Card -->
        <div class="px-5 -mt-20">
            <div class="bg-white rounded-[30px] p-6 shadow-xl">

                <!-- Foto -->
                <div class="flex flex-col items-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-2xl mb-3">
                        👤
                    </div>
                    <button class="text-sm text-satset-green font-semibold">
                        Ubah Foto
                    </button>
                </div>

                <!-- Form -->
                <form class="space-y-4">

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                        <input type="text" value="Budi Santoso"
                            class="w-full mt-1 p-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-satset-green">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Email</label>
                        <input type="email" value="budi@gmail.com"
                            class="w-full mt-1 p-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-satset-green">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">No. HP</label>
                        <input type="text" value="08123456789"
                            class="w-full mt-1 p-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-satset-green">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Bio</label>
                        <textarea rows="3"
                            class="w-full mt-1 p-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-satset-green">Pengguna aktif SatSet 🚀</textarea>
                    </div>

                </form>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <div class="fixed bottom-0 left-0 right-0 bg-white p-5 border-t">
        <button class="w-full h-14 bg-satset-green text-white font-bold rounded-2xl">
            Simpan Perubahan
        </button>
    </div>

</div>

</body>
</html>