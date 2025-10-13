<x-layouts.fullpage>

    @if ($errors->any())
        <div class="mb-4">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="md:max-w-lg mx-auto" method="POST" action="{{ route('login') }}">
        @csrf
        <label class="block mb-4">
            <p class="mb-2 text-gray-900 font-semibold leading-normal">Email Address *</p>
            <input
                class="px-4 py-3.5 w-full text-gray-400 font-medium placeholder-gray-400 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-indigo-300"
                id="signInInput1-1" type="email" name="email" placeholder="Enter email address">
        </label>
        <label class="block mb-5">
            <p class="mb-2 text-gray-900 font-semibold leading-normal">Password *</p>
            <input
                class="px-4 py-3.5 w-full text-gray-400 font-medium placeholder-gray-400 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-indigo-300"
                id="signInInput1-2" type="password" name="password" placeholder="********">
        </label>
        <div class="flex flex-wrap justify-between -m-2 mb-4">
            <div class="w-auto p-2">
                <div class="flex items-center">
                    <input class="w-4 h-4" id="default-checkbox" type="checkbox" value="">
                    <label class="ml-2 text-sm text-gray-900 font-medium" for="default-checkbox">Remember
                        Me</label>
                </div>
            </div>
            <div class="w-auto p-2"><a class="text-sm text-indigo-600 hover:text-indigo-700 font-medium"
                    href="#">Forgot Password?</a></div>
        </div>
        <button
            class="mb-9 py-4 px-9 w-full text-white font-semibold border border-indigo-700 rounded-xl shadow-4xl focus:ring focus:ring-indigo-300 bg-indigo-600 hover:bg-indigo-700 transition ease-in-out duration-200">Sign
            In</button>
        <p class="mb-5 text-sm text-gray-500 font-medium text-center">Non hai un account?</p>
        <div class="flex flex-wrap justify-center -m-2">
            <div class="w-auto p-2">
                <button
                    class="flex items-center p-4 bg-white hover:bg-gray-50 border rounded-lg transition ease-in-out duration-200">

                    <span class="font-semibold leading-normal">Registrati</span>
                </button>
            </div>
        </div>
    </form>

</x-layouts.fullpage>
