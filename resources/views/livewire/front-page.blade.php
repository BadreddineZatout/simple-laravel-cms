<div>
    <nav class="bg-PrussianBlue px-3 py-2 flex justify-between items-center shadow-lg">
        <div class="flex items-center">
            <div class="sm:hidden">
                <button class="block h-8 mr-3 text-Champagne items-center hover:text-DarkChestnut">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="h-12 flex items-center">
                <a href="{{ url('/') }}" class="w-full">
                    <img class="h-8" src="{{ url('/img/logo.svg') }}">
                </a>
            </div>
        </div>

        <div class='sm:flex justify-end hidden'>
            {{-- Top Navigation --}}
            <ul class="text-md text-Champagne">
                <a>
                    <li class="cursor-pointer px-4 py-3 hover:text-MediumCarmine hover:font-bold">Login</li>
                </a>
            </ul>
        </div>
    </nav>
    <div>
        <aside>

        </aside>
    </div>
    <main>
        <section>
            <h1>{{ $title }}</h1>
            <article>
                {!! $content !!}
            </article>
        </section>
    </main>
</div>
