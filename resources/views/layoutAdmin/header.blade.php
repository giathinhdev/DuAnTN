<nav class="sidebar bg-primary">
    <ul>
        <li>
            <a class="text-dark" href="{{ route('admin.home') }}">
                <i class="fa-solid fa-house ico-side"></i> Dashboards
            </a>
        </li>
        <li>
            <a class="text-dark" href="{{ route('admin.orders.index') }}">
                <i class="fa-solid fa-cart-shopping ico-side"></i> Quản lý đơn hàng
            </a>
        </li>
        <li>
            <a class="text-dark" href="{{ route('admin.tables.index') }}">
                <i class="fa-solid fa-table ico-side"></i> Quản lý bàn
            </a>
        </li>
        <li>
            <a class="text-dark" href="{{ route('admin.categorys') }}">
                <i class="fa-solid fa-folder-open ico-side"></i> Quản lý danh mục
            </a>
        </li>
        <li>
            <a class="text-dark" href="{{ route('admin.productlist') }}">
                <i class="fa-solid fa-mug-hot ico-side"></i> Quản lý sản phẩm
            </a>
        </li>
        <li>
            <a class="text-dark" href="{{ route('admin.users.index') }}">
                <i class="fa-solid fa-user ico-side"></i> Quản lý thành viên
            </a>
        </li>
    </ul>
</nav>
