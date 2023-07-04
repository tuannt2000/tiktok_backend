<div class="position-fixed top-0 w-100">
    @if (Session::get('flashError'))
    <div class="alert alert-danger alert-ps" role="alert">
        {{ Session::get('flashError') }}
    </div>
    @endif

    @if (Session::get('flashSuccess'))
    <div class="alert alert-success alert-ps" role="alert">
        {{ Session::get('flashSuccess') }}
    </div>
    @endif
</div>