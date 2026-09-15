const headerHTML = `
<nav class="main-header navbar navbar-expand navbar-white navbar-light py-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item d-sm-inline-block">
            <img src="../dist/img/logo.png" class="brand-image" style="height:7vh">
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Switch Department -->
        <li class="nav-item">
            <a class="nav-link" href="../choose_department.html" data-toggle="tooltip" data-placement="top" data-html="true"
                title="Switch Department">
                <i class="fas fa-right-left"></i>
            </a>
        </li>
        <!-- User Profile -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="tooltip" data-placement="top" data-html="true"
                title="Logged in as Admin">
                <i class="fas fa-user"></i>
            </a>
        </li>
        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link" href="../index.html" role="button" data-toggle="tooltip" data-placement="top"
                title="Logout">
                <i class="fas fa-right-from-bracket"></i>
            </a>
        </li>
    </ul>
</nav>
`;

document.getElementById("header-container").innerHTML = headerHTML;