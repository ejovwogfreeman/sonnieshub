<?php

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $userId = $user['user_id'];
}

?>

<div class="dashboard-container">
    <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h3></h3>
            <button id="closeBtn" class="close-btn">&times;</button>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="#dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M3.76 16h12.48A7.998 7.998 0 0 0 10 3a7.998 7.998 0 0 0-6.24 13M10 4c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1M6 6c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1m8 0c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1m-5.37 5.55L12 7v6c0 1.1-.9 2-2 2s-2-.9-2-2c0-.57.24-1.08.63-1.45M4 10c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1m12 0c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1m-5 3c0-.55-.45-1-1-1s-1 .45-1 1s.45 1 1 1s1-.45 1-1" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#orders">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 2048 2048">
                        <path fill="currentColor" d="m2029 1453l-557 558l-269-270l90-90l179 178l467-466zM1024 640H640V512h384zm0 256H640V768h384zm-384 128h384v128H640zM512 640H384V512h128zm0 256H384V768h128zm-128 128h128v128H384zm768-384V128H256v1792h896v128H128V0h1115l549 549v731l-128 128V640zm128-128h293l-293-293z" />
                    </svg>
                    <span>Orders</span>
                </a>
            </li>
            <?php if ($user['is_admin'] === 'true') : ?>
                <li>
                    <a href="#admin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 32 32">
                            <path fill="currentColor" d="M12 4a5 5 0 1 1-5 5a5 5 0 0 1 5-5m0-2a7 7 0 1 0 7 7a7 7 0 0 0-7-7m10 28h-2v-5a5 5 0 0 0-5-5H9a5 5 0 0 0-5 5v5H2v-5a7 7 0 0 1 7-7h6a7 7 0 0 1 7 7zm3-13.82l-2.59-2.59L21 15l4 4l7-7l-1.41-1.41z" />
                        </svg>
                        <span>Admin</span>
                    </a>
                </li>
                <li>
                    <a href="#users">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3s-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 3-1.34 3-3S9.66 5 8 5S5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm-8 0c-.29 0-.62.02-.97.05C7.63 13.86 9 15.03 9 16.5V19H2v-2.5c0-1.47 1.37-2.64 3.97-3.45c-.35-.03-.68-.05-.97-.05z" />
                        </svg>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="#products">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48">
                            <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                <path d="M44 14L24 4L4 14v20l20 10l20-10z" />
                                <path stroke-linecap="round" d="m4 14l20 10m0 20V24m20-10L24 24M34 9L14 19" />
                            </g>
                        </svg>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="#blogs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48">
                            <path fill="currentColor" d="M14.25 4A6.25 6.25 0 0 0 8 10.25v27.5A6.25 6.25 0 0 0 14.25 44h24.5a1.25 1.25 0 1 0 0-2.5h-24.5a3.75 3.75 0 0 1-3.675-3H37.75A2.25 2.25 0 0 0 40 36.25v-26A6.25 6.25 0 0 0 33.75 4zM37.5 36h-27V10.25a3.75 3.75 0 0 1 3.75-3.75h19.5a3.75 3.75 0 0 1 3.75 3.75zM16.25 10A2.25 2.25 0 0 0 14 12.25v4.5A2.25 2.25 0 0 0 16.25 19h15.5A2.25 2.25 0 0 0 34 16.75v-4.5A2.25 2.25 0 0 0 31.75 10zm.25 6.5v-4h15v4z" />
                        </svg>
                        <span>Blogs</span>
                    </a>
                </li>
                <li>
                    <a href="#upload-product">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 15 15">
                            <path fill="currentColor" fill-rule="evenodd" d="M7.818 1.182a.45.45 0 0 0-.636 0l-3 3a.45.45 0 1 0 .636.636L7.05 2.586V9.5a.45.45 0 1 0 .9 0V2.586l2.232 2.232a.45.45 0 1 0 .636-.636zM2.5 10a.5.5 0 0 1 .5.5V12c0 .554.446 1 .996 1h7.005A.999.999 0 0 0 12 12v-1.5a.5.5 0 1 1 1 0V12a2 2 0 0 1-1.999 2H3.996A1.997 1.997 0 0 1 2 12v-1.5a.5.5 0 0 1 .5-.5" clip-rule="evenodd" />
                        </svg>
                        <span>Upload Product</span>
                    </a>
                </li>
                <li>
                    <a href="#create-blog">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 21 21">
                            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 4.5H5.5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V11" />
                                <path d="M17.5 3.467a1.462 1.462 0 0 1-.017 2.05L10.5 12.5l-3 1l1-3l6.987-7.046a1.409 1.409 0 0 1 1.885-.104zm-2 2.033l.953 1" />
                            </g>
                        </svg>
                        <span>Create Blog</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="#profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" />
                    </svg>
                    <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="#settings">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m9.25 22l-.4-3.2q-.325-.125-.612-.3t-.563-.375L4.7 19.375l-2.75-4.75l2.575-1.95Q4.5 12.5 4.5 12.338v-.675q0-.163.025-.338L1.95 9.375l2.75-4.75l2.975 1.25q.275-.2.575-.375t.6-.3l.4-3.2h5.5l.4 3.2q.325.125.613.3t.562.375l2.975-1.25l2.75 4.75l-2.575 1.95q.025.175.025.338v.674q0 .163-.05.338l2.575 1.95l-2.75 4.75l-2.95-1.25q-.275.2-.575.375t-.6.3l-.4 3.2zM11 20h1.975l.35-2.65q.775-.2 1.438-.587t1.212-.938l2.475 1.025l.975-1.7l-2.15-1.625q.125-.35.175-.737T17.5 12t-.05-.787t-.175-.738l2.15-1.625l-.975-1.7l-2.475 1.05q-.55-.575-1.212-.962t-1.438-.588L13 4h-1.975l-.35 2.65q-.775.2-1.437.588t-1.213.937L5.55 7.15l-.975 1.7l2.15 1.6q-.125.375-.175.75t-.05.8q0 .4.05.775t.175.75l-2.15 1.625l.975 1.7l2.475-1.05q.55.575 1.213.963t1.437.587zm1.05-4.5q1.45 0 2.475-1.025T15.55 12t-1.025-2.475T12.05 8.5q-1.475 0-2.488 1.025T8.55 12t1.013 2.475T12.05 15.5M12 12" />
                    </svg>
                    <span>Settings</span>
                </a>
            </li>
            <li>
                <a href="#change-password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M16.75 8.5a1.25 1.25 0 1 0 0-2.5a1.25 1.25 0 0 0 0 2.5" />
                        <path fill="currentColor" d="M15.75 0a8.25 8.25 0 1 1-2.541 16.101l-1.636 1.636a1.74 1.74 0 0 1-1.237.513H9.25a.25.25 0 0 0-.25.25v1.448a.88.88 0 0 1-.256.619l-.214.213a.75.75 0 0 1-.545.22H5.25a.25.25 0 0 0-.25.25v1A1.75 1.75 0 0 1 3.25 24h-1.5A1.75 1.75 0 0 1 0 22.25v-2.836c0-.464.185-.908.513-1.236l7.386-7.388A8.25 8.25 0 0 1 15.75 0M9 8.25a6.7 6.7 0 0 0 .463 2.462a.75.75 0 0 1-.168.804l-7.722 7.721a.25.25 0 0 0-.073.177v2.836c0 .138.112.25.25.25h1.5a.25.25 0 0 0 .25-.25v-1c0-.966.784-1.75 1.75-1.75H7.5v-1c0-.966.784-1.75 1.75-1.75h1.086a.25.25 0 0 0 .177-.073l1.971-1.972a.75.75 0 0 1 .804-.168A6.75 6.75 0 1 0 9 8.25" />
                    </svg>
                    <span>Change Password</span>
                </a>
            </li>
        </ul>
    </aside>
    <div id="overlay" class="overlay"></div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .dashboard-container {
        display: flex;
        height: 100vh;
    }

    .sidebar {
        width: 250px;
        background-color: #333;
        color: #fff;
        position: fixed;
        top: 0;
        left: -250px;
        height: 100%;
        transition: left 0.3s;
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar-header {
        padding: 10px;
        background: #444;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-menu {
        list-style-type: none;
        padding: 0;
        margin: 0;
        flex: 1;
    }

    .sidebar-menu li a {
        color: #fff;
        text-decoration: none;
        padding: 20px;
        display: flex;
        align-items: center;
    }

    .sidebar-menu li a span {
        margin-bottom: -5px;
        margin-left: 5px;
    }

    .sidebar-menu li a:hover {
        background: #555;
    }

    .close-btn {
        background: none;
        border: none;
        color: #fff;
        font-size: 30px;
        cursor: pointer;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 900;
    }

    .overlay.show {
        display: block;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f4f4f4;
        padding: 10px;
    }

    .menu-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }

    main {
        padding: 20px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
            left: -200px;
        }

        .content {
            margin-left: 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar() {
            sidebar.style.left = '0';
            overlay.classList.add('show');
        }

        function closeSidebar() {
            sidebar.style.left = '-250px';
            overlay.classList.remove('show');
        }

        menuBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.style.left = '0';
                overlay.classList.remove('show');
            } else {
                sidebar.style.left = '-250px';
                overlay.classList.remove('show');
            }
        });
    });
</script>