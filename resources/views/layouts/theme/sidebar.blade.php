<div class="sidebar-wrapper sidebar-theme">
    <nav id="compactSidebar">
        <ul class="menu-categories">

            {{-- @can('view_categories') --}}
                <li>
                    <a href="{{ route('home') }}" class="menu-toggle" data-active="true">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span>CATEGORÍAS</span>
                        </div>
                    </a>
                </li>
            {{-- @endcan --}}

            {{-- @can('view_products') --}}
                <li>
                    <a href="{{ route('home') }}" class="menu-toggle" data-active="false">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                            </div>
                            <span>PRODUCTOS</span>
                        </div>
                    </a>
                </li>
           {{--  @endcan --}}

            {{-- @can('sales') --}}
                <li>
                    <a href="{{ route('home') }}" class="menu-toggle" data-active="false">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </div>
                            <span>VENTAS</span>
                        </div>
                    </a>
                </li>
            {{-- @endcan --}}

            {{-- @can('view_roles') --}}
                <li>
                    <a href="{{ route('home') }}" class="menu-toggle" data-active="false">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
                                </svg>
                            </div>
                            <span>ROLES</span>
                        </div>
                    </a>
                </li>
            {{-- @endcan --}}

            {{-- @can('view_users') --}}
                <li>
                    <a href="{{ route('home') }}" class="menu-toggle" data-active="false">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <span>USUARIOS</span>
                        </div>
                    </a>
                </li>
            {{-- @endcan --}}

            {{-- @can('view_denominations') --}}
                <li>
                    <a href="{{ route('home') }}" class="menu-toggle" data-active="false">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <rect x="9" y="9" width="6" height="6"></rect>
                                </svg>
                            </div>
                            <span>MONEDAS</span>
                        </div>
                    </a>
                </li>
            {{-- @endcan --}}

            {{-- @can('cashout') --}}
                <li>
                    <a href="{{ route('home') }}" class="menu-toggle" data-active="false">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <span>ARQUEOS</span>
                        </div>
                    </a>
                </li>
            {{-- @endcan --}}

            {{-- @can('reports') --}}
                <li>
                    <a href="{{ route('home') }}" class="menu-toggle" data-active="false">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                            </div>
                            <span>REPORTES</span>
                        </div>
                    </a>
                </li>
            {{-- @endcan --}}
        </ul>
    </nav>
</div>
