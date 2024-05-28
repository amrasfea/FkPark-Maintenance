
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        ::after,
        ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        h1 {
            font-weight: 600;
            font-size: 1.5rem;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-y: auto; /* Ensure body can scroll */
            min-height: 100vh; /* Ensure body takes full height */
            margin: 0;
            padding: 0;
         
        }

        .wrapper {
            display: flex;
            height: 100vh;
        }

        .main {
            min-height: 100vh;
            width: 100%;
            overflow: auto;
            transition: all 0.35s ease-in-out;
            background-color: #fafbfe;
            flex-grow: 1; /* Ensure main takes available space */
            padding: 2rem; /* Add padding for better spacing */
            
        }

        #sidebar {
            width: 70px;
            min-width: 70px;
            height: 100%;
            z-index: 1000;
            transition: all .25s ease-in-out;
            background-color: #FFDB58;
            display: flex;
            flex-direction: column;

        }

        #sidebar.expand {
            width: 260px;
            min-width: 260px;
        }

        .toggle-btn {
            background-color: transparent;
            cursor: pointer;
            border: 0;
            padding: 1rem 1.5rem;
        }

        .toggle-btn i {
            font-size: 1.5rem;
            color: #0e2238;
        }

        .sidebar-logo {
            margin: auto 0;
            color: #0e2238;
        }

        .sidebar-logo a {
            color:#0e2238;
            font-size: 1.15rem;
            font-weight: 600;
        }

        #sidebar:not(.expand) .sidebar-logo,
        #sidebar:not(.expand) a.sidebar-link span {
            display: none;
        }

        .sidebar-nav {
            padding: 2rem 0;
            flex: 1 1 auto;
        }

        a.sidebar-link {
            padding: .625rem 1.625rem;
            color: #0e2238;
            display: block;
            font-size: 0.9rem;
            white-space: nowrap;
            border-left: 3px solid transparent;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            margin-right: .75rem;
            color: #0e2238;
        }

        a.sidebar-link:hover {
            background-color: rgba(255, 255, 255, .075);
            border-left: 3px solid #3b7ddd;
        }

        .sidebar-item {
            position: relative;
        }

        #sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
            position: absolute;
            top: 0;
            left: 70px;
            background-color: #FFDB58;
            padding: 0;
            min-width: 15rem;
            display: none;
        }

        #sidebar:not(.expand) .sidebar-item:hover .has-dropdown+.sidebar-dropdown {
            display: block;
            max-height: 15em;
            width: 100%;
            opacity: 1;
        }

        #sidebar.expand .sidebar-link[data-bs-toggle="collapse"]::after {
            border: solid;
            border-width: 0 .075rem .075rem 0;
            content: "";
            display: inline-block;
            padding: 2px;
            position: absolute;
            right: 1.5rem;
            top: 1.4rem;
            transform: rotate(-135deg);
            transition: all .2s ease-out;
        }

        #sidebar.expand .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
            transform: rotate(45deg);
            transition: all .2s ease-out;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Student</a>
                </div>
            </div>
            <ul class="sidebar-nav">
            <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Profile</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="../student/profilesection.php" class="sidebar-link">Personal</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
        data-bs-target="#vehicleDropDown" aria-expanded="false" aria-controls="expertDomainDropdown">
        <i class="lni lni-agenda"></i>
        <span>Vehicle Registration</span>
    </a>
    <ul id="vehicleDropDown" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
        <li class="sidebar-item">
            <a href="../student/vehicleRegister.php" class="sidebar-link">Apply Vehicle Registration</a>
        </li>
        <li class="sidebar-item">
            <a href="../student/statusApplication.php" class="sidebar-link">Status Application</a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
        data-bs-target="#publicationDropdown" aria-expanded="false" aria-controls="publicationDropdown">
        <i class="lni lni-layout"></i>
        <span>Parking Area</span>
    </a>
    <ul id="publicationDropdown" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
        <li class="sidebar-item">
            <a href="../student/viewPark.php" class="sidebar-link">Available Parking Spaces</a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
        data-bs-target="#SummonDropdown" aria-expanded="false" aria-controls="publicationDropdown">
        <i class="lni lni-layout"></i>
        <span>Inbox</span>
    </a>
    <ul id="SummonDropdown" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
        <li class="sidebar-item">
            <a href="../student/inboxSum.php" class="sidebar-link">Summon</a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
        data-bs-target="#progressDropdown" aria-expanded="false" aria-controls="progressDropdown">
        <i class="lni lni-popup"></i>
        <span>Book Parking</span>
    </a>
            <ul id="progressDropdown" class="sidebar-dropdown list-unstyled collapse">
                <li class="sidebar-item">
                    <a href="../student/bookForm.php" class="sidebar-link">Booking Form </a>
                </li>
                <li class="sidebar-item">
                    <a href="../student/bookList.php#" class="sidebar-link">Booking List</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
            </ul>
            <div class="sidebar-footer">
                <a href="../student/logout.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <div class="main p-3">
        <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #FAF9F5; margin-top:0%; ">

                <a class="navbar-brand" href="#" style="word-spacing:2px"> FK Park System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
               

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        
                    </ul>
                </div>
            </nav>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
        const hamBurger = document.querySelector(".toggle-btn");

        hamBurger.addEventListener("click", function () {
            document.querySelector("#sidebar").classList.toggle("expand");
        });

        
    </script>
        


