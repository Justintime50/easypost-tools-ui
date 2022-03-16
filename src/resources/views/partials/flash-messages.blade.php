<div class="container-fluid padding-0">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session()->has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif

    @if(session()->has('error'))
    <p class="alert alert-danger {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
    @endif
</div>
