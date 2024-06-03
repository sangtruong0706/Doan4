<ul id="account-panel" class="nav nav-pills flex-column" >
    <li class="nav-item">
        <a href="{{ route("account.profile") }}"  class="nav-link font-weight-bold {{ request()->routeIs('account.profile') ? 'active' : '' }}" role="tab" aria-controls="tab-login" aria-expanded="false"><i class="fas fa-user-alt"></i> My Profile</a>
    </li>
    <li class="nav-item">
        <a href="{{ route("account.address") }}"  class="nav-link font-weight-bold {{ request()->routeIs('account.address') ? 'active' : '' }}" role="tab" aria-controls="tab-login" aria-expanded="false"><i class="fas fa-location-dot"></i> Address</a>
    </li>
    <li class="nav-item">
        <a href="{{ route("account.orders") }}"  class="nav-link font-weight-bold {{ request()->routeIs('account.orders') ? 'active' : '' }} {{ request()->routeIs('account.orderDetails') ? 'active' : '' }}" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-shopping-bag"></i>My Orders</a>
    </li>
    <li class="nav-item">
        <a href="{{ route("account.wishlist") }}"  class="nav-link font-weight-bold {{ request()->routeIs('account.wishlist') ? 'active' : '' }}" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-heart"></i> Wishlist</a>
    </li>
    <li class="nav-item">
        <a href="{{ route("account.showChangePasswordForm") }}"  class="nav-link font-weight-bold {{ request()->routeIs('account.showChangePasswordForm') ? 'active' : '' }}" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-lock"></i> Change Password</a>
    </li>
    <li class="nav-item">
        <a href="{{ route("account.logout") }}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </li>
</ul>
