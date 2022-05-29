<?php
if (! isset($pageName)) {
    $pageName = '';
}
?>
<style type="text/css">
    .navbar {
        padding-left: calc(20vw - 70px);
        padding-right: calc(20vw - 70px);
    }
    .navbar .navbar-nav .nav-link {
        font-weight: 800;
        padding-left: 20px;
        margin-top: 8px;
    }
    @media screen and (min-width: 992px) {
        .navbar .navbar-nav .nav-link {
            padding-left: 5px;
            margin-top: 0;
        }
    }
    .navbar .navbar-nav .nav-link.active {
        background-color: #33A5DB;
        color: white;
        border-radius: 5px;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div
            class="collapse navbar-collapse"
            id="navbarSupportedContent"
        >
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $pageName == 'index_' ? 'active' : '' ?>" href="index_.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pageName == 'products' ? 'active' : '' ?>" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pageName == 'address_book-list' ? 'active' : '' ?>" href="address_book-list.php">Address Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pageName == 'address_book-add' ? 'active' : '' ?>" href="address_book-add.php">AB-add</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pageName == 'address_book-edit' ? 'active' : '' ?>" href="address_book-edit.php">AB-edit</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
