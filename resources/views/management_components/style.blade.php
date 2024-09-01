<style>
    /* General Styles */
    .black-font {
        color: black;
    }
    .theme-color-font-light{
        color: #664E88;
    }
    .theme-color-font-dark{
        color: #3D426B;
    }
    .theme-bg-color-light{
        background-color: #664E88;
        color: white;
    }
    .theme-bg-color-dark{
        background-color: #3D426B;
        color: white;
    }
    .btn-theme{
        background-color:#3D426B;
        border-color:#3D426B;
        color: #fff;
    }
    .btn-theme:hover {
        background-color: #664E88;
        border-color: #3D426B;
        color: #fff;
    }
    .btn-theme-outline{
        background-color:#fff;
        border-color:#3D426B;
        color: #3D426B;
    }
    /* End of General Styles*/
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
    .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 48px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.1);
        background-color: #3D426B;
        
    }
    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: 0.5rem;
        overflow-y: auto;
    }
    .nav-link {
        padding: 10px;
        font-weight: 500;
        border-left: 3px solid transparent;
        transition: background-color 0.3s;
        color: #fff;
    }
    .nav-link:hover {
        background-color: #664E88;
        color: #BD86D2;
    }
    .nav-link.active {
        color: #BD86D2;
        border-left-color: #664E88;
    }
    .main-content {
        margin-left: 230px; /* Adjust this value based on sidebar width */
        transition: margin-left 0.3s;
    }
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            padding: 48px 0;
            position: static;
        }
        .main-content {
            margin-left: 0;
        }
    }
    /* User Info Dropdown */
    .user-info {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color:#3D426B;
    }

    .user-info i {
        margin-right: 10px;
        color:#3D426B;
    }
    .user-details{
        margin-left: 30px;
        font-weight: bold;
    }
    .top-bar {
        background-color: #3D426B;
        color: #fff;
        padding: 10px;
        position: relative;
    }
    .profile-info {
        position: absolute;
        top: 40px;
        right: 10px;
        display: none;
        width: 250px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
        padding: 10px;
        z-index: 1000;
    }
    .profile-info.active {
        display: block;
    }
    /* Nav and Tabs */
    .nav-tabs .nav-item .nav-link{
        color: black;
    }
    .nav-tabs .nav-item .nav-link.active{
        color: #fff !important;
        background-color: #3D426B !important;
    }
    .nav-tabs .nav-item .nav-link:hover{
        color: #fff !important;
        background-color: #BD86D2 !important;
    }
    /* Table */
    .table-btn i {
        color: #BD86D2;
    }

    /* Table Pagination */
    .page-item .page-link{
        color: #3D426B !important;
    }

    .page-item .page-link:hover{
        color: #fff !important;
        background-color: #BD86D2 !important;
    }
    .page-item.active .page-link{
        color: #fff !important;
        background-color: #3D426B !important;
    }
</style>