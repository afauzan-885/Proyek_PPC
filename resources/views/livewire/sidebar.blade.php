<ul class="sidebar-menu" >
    <li class="{{ request()->is('main_app') ? 'active current-page' : '/dashboard' }}">
        <a href="{{ route('main_app') }}"wire:navigate>
            <i class="bi bi-house"></i>
            <span class="menu-text">Dashboard</span>
        </a>
    </li>
    <li class="{{ request()->is('customer-supplier') ? 'active current-page' : '/customer-supplier' }}">
        <a href="{{ route('customer_supplier') }}"wire:navigate>
            <i class="bi bi-envelope"></i>
            <span class="menu-text">Customer Supplier</span>
        </a>
    </li>
    <li class="{{ request()->is('persediaan-barang') ? 'active current-page' : '/persediaan-barang' }}">
        <a href="{{ route('persediaan_barang') }}"wire:navigate>
            <i class="bi bi-box-seam"></i>
            <span class="menu-text">Persediaan Barang</span>
        </a>
    </li>
    <li class="{{ request()->is('po-costumer') ? 'active current-page' : '/po-costumer' }}">
        <a href="{{ route('po_costumer') }}"wire:navigate>
            <i class="bi bi-journal-text"></i>
            <span class="menu-text">PO Costumer</span>
        </a>
    </li>
    @if ($user->role === 'Admin')
        <li class="{{ request()->is('panel-admin') ? 'active btn-warning' : '' }}">
            <a href="{{ route('panel_admin') }}" wire:navigate>
                <i class="bi bi-shield-lock"></i>
                <span class="menu-text">Panel Admin</span>
            </a>
        </li>
    @endif
</ul>
