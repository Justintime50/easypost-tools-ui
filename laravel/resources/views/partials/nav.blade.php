<nav class="nav">
    @if (Route::has('login'))
        <div class="top-left links">
            <a href="/">EasyPost UI</a>
        </div>
        <div class="top-right links">
            @auth
                <a href="{{ url('/account') }}">account</a>
                <a href="https://www.easypost.com/docs/api" target="_blank">API Docs</a>
                <a class="nav-link" href="https://github.com/Justintime50/easypost-ui" target="_blank">GitHub</a>

                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @else
                <a href="https://www.easypost.com/docs/api" target="_blank">API Docs</a>
                <a href="https://github.com/Justintime50/easypost-ui" target="_blank">GitHub</a>
            @endauth
        </div>
    @endif
</nav>
