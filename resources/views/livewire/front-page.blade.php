<div class="sm:divide-y sm:divide-PinkLavender" x-data="{
    show: false
}">
    <nav class="bg-PrussianBlue px-3 py-2 flex justify-between items-center shadow-lg">
        <div class="flex items-center">
            <div class="sm:hidden">
                <button class="block h-8 mr-3 text-Champagne items-center hover:text-DarkChestnut" @click="show = !show">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                        <path x-show="show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
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
            <ul class="text-md text-Champagne sm:flex sm:text-left">
                @foreach ($topLinks as $topLink)
                    <a href="{{ url('/' . $topLink->slug) }}">
                        <li class="cursor-pointer px-4 py-3 hover:text-MediumCarmine hover:font-bold">
                            {{ $topLink->label }}</li>
                    </a>
                @endforeach
            </ul>
        </div>
    </nav>
    <div class="sm:flex sm:min-h-screen">
        <aside class="bg-PrussianBlue divide-y divide-dashed divide-PinkLavender sm:w-4/12 md:w-3/12 lg:w-2/12">
            {{-- Desktop Web View --}}
            <ul class="hidden text-Champagne sm:block sm:pl-5 sm:text-left">
                @foreach ($sidebarLinks as $sidebarLink)
                    <a href="{{ url('/' . $sidebarLink->slug) }}">
                        <li class="cursor-pointer px-4 py-3 hover:text-MediumCarmine hover:font-bold">
                            {{ $sidebarLink->label }}</li>
                    </a>
                @endforeach
            </ul>
            {{-- Mobile Web View --}}
            <div x-show='show' class="pb-3 divide-y divide-PinkLavender block sm:hidden">
                <ul class="text-md text-Champagne">
                    @foreach ($sidebarLinks as $sidebarLink)
                        <a href="{{ url('/' . $sidebarLink->slug) }}">
                            <li class="cursor-pointer px-4 py-3 hover:text-MediumCarmine hover:font-bold">
                                {{ $sidebarLink->label }}</li>
                        </a>
                    @endforeach
                </ul>
                {{-- Top Navigation Mobile Web View --}}
                @guest
                    <ul class="text-md text-Champagne">
                        <a href="{{ url('/login') }}">
                            <li class="cursor-pointer px-4 py-3 hover:text-MediumCarmine hover:font-bold">Login</li>
                        </a>
                    </ul>
                @endguest
            </div>
        </aside>
        <main class="p-14 min-h-screen sm:w-8/12 md:w-9/12 lg:w-10/12">
            <section class="divide-y divide-DarkChestnut ">
                <h1 class="text-3xl font-bold text-PrussianBlue">{{ $title }}</h1>
                <article class="mt-5 text-sm md:text-base">
                    {!! $content !!}
                </article>
            </section>
        </main>
    </div>
</div>
