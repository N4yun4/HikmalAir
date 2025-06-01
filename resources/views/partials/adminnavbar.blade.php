
<nav class="admin-navbar">
    <div>
        <strong>Admin Panel</strong>
    </div>
    <div>
        @auth('admin')
            <span>
                <i class="bi bi-person-circle"></i> {{ Auth::guard('admin')->user()->usr_admin }}
            </span>

            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline !important;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @endauth
    </div>
</nav>
