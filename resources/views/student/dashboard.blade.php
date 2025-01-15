<!DOCTYPE html>
<html>
<head>
    <title>UNIARCHIVE</title>
    <!-- Link to the CSS -->
    <link rel="stylesheet" href="{{ asset('css/Student.FrontPage.css') }}">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('assets/UNIARCHIVE.HEADER.png') }}" alt="UNIARCHIVE Logo" class="logo">

        <div class="search-container">
            <input type="text" placeholder="Find book..." class="search-bar" id="search-input">
            <button class="search-btn" onclick="searchBook()">Search</button>
            <button class="clear-btn" onclick="clearSearch()">✖</button>
        </div>

        <div class="header-icons">
            <form method="POST" action="{{ route('student.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Log out</button>
            </form>
        </div>
    </div>

    <script>
        function searchBook() {
            const searchQuery = document.getElementById("search-input").value.toLowerCase();
            const listItems = document.querySelectorAll('#list li');
            let resultsFound = false;

            listItems.forEach(item => {
                const itemTitle = item.querySelector('.title').textContent.toLowerCase();

                if (itemTitle.includes(searchQuery)) {
                    item.style.display = 'block'; // Show matching item
                    resultsFound = true;
                } else {
                    item.style.display = 'none'; // Hide non-matching item
                }
            });

            if (!resultsFound) {
                alert("No matching results found.");
            }
        }

        function clearSearch() {
            document.getElementById("search-input").value = "";
            const listItems = document.querySelectorAll('#list li');
            listItems.forEach(item => {
                item.style.display = 'block';
            });
        }
    </script>

    <!-- Title Bar -->
    <div class="title-bar">
        <span id="current-date"></span>
        <span id="current-time"></span>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString('en-US');
            const time = now.toLocaleTimeString('en-US');
            document.getElementById('current-date').textContent = date;
            document.getElementById('current-time').textContent = time;
        }
        setInterval(updateDateTime, 1000);
        window.onload = updateDateTime;
    </script>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Home Button -->
        <button onclick="window.location.href='{{ route('student.dashboard') }}';">Home</button>

        <!-- Library Button -->
        <button onclick="window.location.href='{{ route('student.library') }}';">Library</button>
    </div>

    <!-- Main Content -->
    <div class="add-container">
        <div id="item-list">
            <ul id="list">
                <!-- Items will appear here -->
            </ul>
        </div>
    </div>
    <!-- Details Container -->
    <div id="details-container">
        <h3 id="details-title"></h3>
        <p id="details-researcher"></p>
        <p id="details-date"></p>
        <p id="details-category"></p>
        <p id="details-year"></p>
        <p id="details-status"></p>
        <p id="details-abstract"></p> <!-- Abstract details -->
        <button id="close-button" onclick="hideDetails()">Close</button>
        <button id="reserve-button" onclick="reserveBook()">Reserve Book</button> <!-- Reserve Book button -->
    </div>

        <!-- Reservation Form Container -->
        <div id="reservation-form-container">
            <h2>Add Reservation</h2>
            <form>
                <label for="reservation-title">Title of Book:</label>
                <input type="text" id="reservation-title" readonly><br><br>

                <label for="reservation-name">Name:</label>
                <input type="text" id="reservation-name"><br><br>

                <label for="reservation-section">Year & Section:</label>
                <input type="text" id="reservation-section"><br><br>

                <label for="reservation-program">Program:</label>
                <input type="text" id="reservation-program"><br><br>

                <label for="reservation-contact">Contact Number:</label>
                <input type="text" id="reservation-contact"><br><br>

                <label for="reservation-email">E-mail:</label>
                <input type="email" id="reservation-email"><br><br>

                <label for="reservation-datetime-reserve">Date and Time will Reserve:</label>
                <input type="datetime-local" id="reservation-datetime-reserve"><br><br>

                <label for="reservation-datetime-return">Date and Time will Return:</label>
                <input type="datetime-local" id="reservation-datetime-return"><br><br>

                <button type="button" onclick="closeReservationForm()">Cancel</button>
                <button type="button" onclick="confirmReservation()">Confirm</button>

            </form>
        </div>

    <script>
        const items = [
        {
            title: "Research on Quantum Mechanics",
            researcher: "Dr. John Doe",
            date: "2023-02-15",
            category: "Science",
            year: "2023",
            status: "AVAILABLE",
            abstract: "This research explores the fundamental principles of quantum mechanics and their applications in modern physics."
        },
        {
            title: "Machine Learning Fundamentals",
            researcher: "Dr. Jane Smith",
            date: "2022-11-20",
            category: "Technology",
            year: "2022",
            status: "RESERVED",
            abstract: "An introductory guide to machine learning techniques and their real-world implementations."
        }
    ];

        window.onload = function() {
            const list = document.getElementById('list');

            items.forEach(item => {
                const newItem = document.createElement("li");
                newItem.setAttribute("data-category", item.category);
                newItem.setAttribute("data-year", item.year);

                newItem.innerHTML = `
                    <div class="title">${item.title}</div>
                    <div class="details">${item.researcher}<br>${item.date}</div>
                    <div class="status ${item.status.toLowerCase()}">${item.status}</div>
                `;

                newItem.querySelector('.title').addEventListener('click', () => {
                    document.getElementById('details-title').textContent = item.title;
                    document.getElementById('details-researcher').textContent = `Researcher: ${item.researcher}`;
                    document.getElementById('details-date').textContent = `Date: ${item.date}`;
                    document.getElementById('details-category').textContent = `Category: ${item.category}`;
                    document.getElementById('details-year').textContent = `Year: ${item.year}`;
                    document.getElementById('details-status').textContent = `Status: ${item.status}`;
                    document.getElementById('details-abstract').textContent = `Abstract: ${item.abstract}`;
                    document.getElementById('details-container').style.display = 'block';
                });

                list.appendChild(newItem);
            });

            document.getElementById('item-list').style.display = 'block';
        };

        function hideDetails() {
            document.getElementById('details-container').style.display = 'none';
        }

        function reserveBook() {
            const title = document.getElementById('details-title').textContent;
            document.getElementById('reservation-title').value = title; // Set title in the form
            document.getElementById('reservation-form-container').style.display = 'block'; // Show reservation form
        }

        function closeReservationForm() {
            document.getElementById('reservation-form-container').style.display = 'none'; // Hide reservation form
        }

        function confirmReservation() {
            const title = document.getElementById('reservation-title').value;
            const name = document.getElementById('reservation-name').value;
            const section = document.getElementById('reservation-section').value;
            const program = document.getElementById('reservation-program').value;
            const contact = document.getElementById('reservation-contact').value;
            const email = document.getElementById('reservation-email').value;
            const datetimeReserve = document.getElementById('reservation-datetime-reserve').value;
            const datetimeReturn = document.getElementById('reservation-datetime-return').value;

            if (name && section && program && contact && email && datetimeReserve && datetimeReturn) {
                alert(`Reservation confirmed for "${title}".\nName: ${name}\nProgram: ${program}`);
                closeReservationForm();
            } else {
                alert("Please fill in all fields.");
            }
        }

    </script>


    <!-- Filter -->
    <div class="filter">
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" placeholder="Enter category"><br><br>

        <label for="year">Year:</label>
        <input type="number" id="year" name="year" placeholder="Enter year"><br><br>

        <button type="button" onclick="loadData()">Filter</button>
    </div>

    <script>
        function loadData() {
            const category = document.getElementById('category').value.toLowerCase();
            const year = document.getElementById('year').value;

            const listItems = document.querySelectorAll('#list li');
            let resultsFound = false;

            listItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category').toLowerCase();
                const itemYear = item.getAttribute('data-year');

                if (
                    (!category || itemCategory.includes(category)) &&
                    (!year || itemYear === year)
                ) {
                    item.style.display = 'block';
                    resultsFound = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (!resultsFound) {
                alert("No matching results found.");
            }
        }
    </script>
</body>
</html>
