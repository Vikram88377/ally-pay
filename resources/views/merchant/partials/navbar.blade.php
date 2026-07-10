<nav class="navbar navbar-light bg-light px-4">
    <div>
        <span class="navbar-brand mb-0 h1">
            Merchant Dashboard
        </span>

        <small class="text-muted">
            {{ auth()->user()->merchant->business_name }}
        </small>
    </div>

    <form method="POST"
          action="{{ route('merchant.logout') }}">
        @csrf

        <button class="btn btn-danger btn-sm">
            Logout
        </button>
    </form>
</nav>