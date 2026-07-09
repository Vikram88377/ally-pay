<nav class="navbar navbar-light bg-light px-4">
    <span class="navbar-brand mb-0 h1">Admin Dashboard</span>

    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="btn btn-danger btn-sm">Logout</button>
    </form>
</nav>