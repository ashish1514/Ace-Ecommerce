<flux:header class="hidden lg:flex items-center justify-end w-full px-4 py-2 border-b border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
    <div class="dropdown d-none d-lg-block">
        <button class=" dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="d-inline-block rounded-circle bg-secondary text-white text-center me-2" style="width: 32px; height: 32px; line-height: 32px; font-weight: bold;">
                {{ auth()->user()->initials() }}
            </span>
            <span class="d-none d-xl-inline">{{ auth()->user()->name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown" style="min-width: 220px;">
            <li class="px-3 py-2">
                <div class="d-flex align-items-center">
                    <span class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                        {{ auth()->user()->initials() }}
                    </span>
                    <div class="flex-grow-1">
                        <div class="fw-semibold text-truncate">{{ auth()->user()->name }}</div>
                        <div class="text-muted small text-truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.switch.back') }}">
                    <i class="bi bi-person me-2"></i> {{ __('Switch Back to Admin') }}
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('users.edit', ['id' => auth()->user()->id]) }}">
                    <i class="bi bi-person-circle me-2"></i> {{ __('Profile') }}
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center">
                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Log Out') }}
                    </button>
                </form>
            </li>
        </ul>
    </div>
</flux:header>