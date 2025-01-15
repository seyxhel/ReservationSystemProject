<!DOCTYPE html>
<html>
<head>
    <title>UNIARCHIVE</title>
    <link rel="stylesheet" href="{{ asset('css/Student.LibraryPage.css') }}">
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
            <button class="profile" onclick="window.location.href='Student.ProfilePage.html';">👤</button>
            <button class="logout-btn" onclick="handleLogout()">Log out</button>
        </div>
    </div>

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
            <button onclick="window.location.href='Student.FrontPage.html';">Home</button>
            <button onclick="window.location.href='Student.LibraryPage.html';">Library</button>
        </div>

        <div class="buttons">
        <button class="add-btn" onclick="addItem()">Add Reservation</button>
    </div>

    <script>
      // JavaScript functions for the Add, Edit, and Delete buttons
      function addItem() {
        // Display the reservation form
        document.getElementById("reservation-form-container").style.display = "block";
      }

      // Function to confirm the reservation
      function confirmReservation() {
        const returnDate = document.getElementById("reservation-datetime-return").value;
        const currentDate = new Date();

        // Set initial book status
        let bookStatus = document.getElementById("reservation-status").value;

        // Check if the return date has passed to determine if the book is overdue
        if (new Date(returnDate) < currentDate) {
          bookStatus = "Overdue";
        }

        // Close the form after confirmation
        closeReservationForm();
      }

        // Function to automatically set the book status based on title
      function updateBookStatus() {
        const title = document.getElementById("reservation-title").value.trim(); // Get the title and remove leading/trailing spaces
        const statusField = document.getElementById("reservation-status");

        // If title is empty, set status to blank
        if (title === "") {
            statusField.value = ""; // Keep status field empty
        } else {
            // Send an asynchronous request to the backend to check the book's status
            //PWede to baguhin as example lang to gpt hehe
            fetch(`http://localhost:3000/book-status?title=${encodeURIComponent(title)}`)
                .then(response => response.json())
                .then(data => {
                    // Assuming the response contains a status property
                    const bookStatus = data.status;

                    // Update the book status based on the backend response
                    if (bookStatus) {
                        statusField.value = bookStatus; // Set the status from backend
                    } else {
                        statusField.value = "Not Available"; // Default status if no response
                    }
                })
                .catch(error => {
                    console.error("Error fetching book status:", error);
                    statusField.value = "Not Available"; // Default in case of error
                });
        }
      }

  </script>

        <!-- Reservation Form (Initially hidden) -->
    <div id="reservation-form-container" style="display: none;">
        <h2>Add Reservation</h2>
        <form>
        <label for="reservation-title">Title of Book:</label>
        <input type="text" id="reservation-title" oninput="updateBookStatus()"><br><br>

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

        <!-- Book Status (text box for status, will be read-only) -->
        <label for="reservation-status">Book Status:</label>
        <input type="text" id="reservation-status" readonly><br><br>

        <button type="button" onclick="closeReservationForm()">Cancel</button>
        <button type="button" onclick="confirmReservation()">Confirm</button>
        </form>
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

        function handleLogout() {
            const confirmation = confirm("Are you sure you want to logout?");
            if (confirmation) {
                window.location.href = "Student.WelcomePage.html";
            }
        }

        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString('en-US');
            const time = now.toLocaleTimeString('en-US');
            document.getElementById('current-date').textContent = date;
            document.getElementById('current-time').textContent = time;
        }
        setInterval(updateDateTime, 1000);
        window.onload = updateDateTime;

        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
        }

        function editItem(button) {
            const row = button.closest('tr');
            const title = row.cells[0].textContent;
            const author = row.cells[1].textContent;
            const status = row.cells[2].textContent;
            const reserveDate = row.cells[3].textContent;
            const returnDate = row.cells[4].textContent;

            document.getElementById("reservation-title").value = title;
            document.getElementById("reservation-name").value = author;
            document.getElementById("reservation-status").value = status;
            document.getElementById("reservation-datetime-reserve").value = reserveDate;
            document.getElementById("reservation-datetime-return").value = returnDate;

            document.getElementById("reservation-form-container").style.display = "block";
        }

        function deleteItem(button) {
            const row = button.closest('tr');
            const confirmation = confirm("Are you sure you want to delete this item?");
            if (confirmation) {
                row.remove();
            }
        }
    </script>

    <!-- Right-side tabs -->
    <div class="right-tabs">
        <button onclick="showTab('tab1')">All</button>
        <button onclick="showTab('tab2')">Reserved</button>
        <button onclick="showTab('tab3')">Overdue</button>
    </div>

    <!-- Table Section -->
    <div id="tab1" class="tab-content active">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Reservation Date</th>
                    <th>Return Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Book Title 1</td>
                    <td>Author 1</td>
                    <td>Available</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button class="view-btn" onclick="viewDetails(this)">View</button>
                        <button class="edit-btn" onclick="editItem(this)">Edit</button>
                        <button class="delete-btn" onclick="deleteItem(this)">Delete</button>
                        <button class="return-btn" onclick="markAsReturned(this)">Return</button>
                    </td>
                </tr>
                <tr>
                    <td>Book Title 2</td>
                    <td>Author 2</td>
                    <td>Reserved</td>
                    <td>2025-01-11 10:00 AM</td>
                    <td>2025-01-18 10:00 AM</td>
                    <td>
                        <button class="view-btn" onclick="viewDetails(this)">View</button>
                        <button class="edit-btn" onclick="editItem(this)">Edit</button>
                        <button class="delete-btn" onclick="deleteItem(this)">Delete</button>
                        <button class="return-btn" onclick="markAsReturned(this)">Return</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Details Container -->
    <div id="details-container" style="display: none;">
        <h3 id="details-title">Book Title</h3>
        <p id="details-author">Author: </p>
        <p id="details-status">Status: </p>
        <p id="details-reserve-date">Reservation Date: </p>
        <p id="details-return-date">Return Date: </p>
        <p id="details-abstract">Abstract: </p> <!-- Added Abstract field -->
        <button onclick="hideDetails()">Close</button>
    </div>

    <script>
        function viewDetails(button) {
            const row = button.closest('tr');
            const title = row.cells[0].textContent;
            const author = row.cells[1].textContent;
            const status = row.cells[2].textContent;
            const reserveDate = row.cells[3].textContent;
            const returnDate = row.cells[4].textContent;

            // Mocked abstract for demonstration; replace with actual data retrieval
            const abstract = "This is a sample abstract of the book. Replace this with the actual abstract data.";

            document.getElementById('details-title').textContent = title;
            document.getElementById('details-author').textContent = `Author: ${author}`;
            document.getElementById('details-status').textContent = `Status: ${status}`;
            document.getElementById('details-reserve-date').textContent = `Reservation Date: ${reserveDate}`;
            document.getElementById('details-return-date').textContent = `Return Date: ${returnDate}`;
            document.getElementById('details-abstract').textContent = `Abstract: ${abstract}`; // Populate abstract
            document.getElementById('details-container').style.display = 'block';
        }

        function hideDetails() {
            document.getElementById('details-container').style.display = 'none';
        }

        function editItem(button) {
            const row = button.closest('tr');
            const title = row.cells[0].textContent;
            const author = row.cells[1].textContent;
            const status = row.cells[2].textContent;
            const reserveDate = row.cells[3].textContent;
            const returnDate = row.cells[4].textContent;

            // If you're storing the name in a hidden attribute like data-name, use that instead
            const name = row.dataset.name || ""; // This will get the 'name' stored in data-name attribute of the row

            // Convert the reserve and return dates into a format that datetime-local can handle
            const formattedReserveDate = formatDateForInput(reserveDate);
            const formattedReturnDate = formatDateForInput(returnDate);

            // Set the values in the reservation form
            document.getElementById("reservation-title").value = title;
            document.getElementById("reservation-name").value = name; // Use the correct name from the row
            document.getElementById("reservation-status").value = status;
            document.getElementById("reservation-datetime-reserve").value = formattedReserveDate;
            document.getElementById("reservation-datetime-return").value = formattedReturnDate;

            // Show the reservation form
            document.getElementById("reservation-form-container").style.display = "block";
        }

        // Helper function to format date into a format that <input type="datetime-local"> can accept
        function formatDateForInput(dateStr) {
            const date = new Date(dateStr);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is zero-indexed
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        function deleteItem(button) {
            const confirmation = confirm("Are you sure you want to delete this reservation?");
            if (confirmation) {
                button.closest('tr').remove();
            }
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

        <!-- Reserved Tab -->
    <div id="tab2" class="tab-content">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Reservation Date</th>
                    <th>Return Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Book Title 2</td>
                    <td>Author 2</td>
                    <td>Reserved</td>
                    <td>2025-01-11 10:00 AM</td>
                    <td>2025-01-18 10:00 AM</td>
                    <td>
                        <button class="view-btn" onclick="viewDetails(this)">View</button>
                        <button class="edit-btn" onclick="editItem(this)">Edit</button>
                        <button class="delete-btn" onclick="deleteItem(this)">Delete</button>
                        <button class="return-btn" onclick="markAsReturned(this)">Return</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Overdue Tab -->
    <div id="tab3" class="tab-content">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Reservation Date</th>
                    <th>Return Date</th>
                    <th>Overdue Days</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Book Title 3</td>
                    <td>Author 3</td>
                    <td>Overdue</td>
                    <td>2024-12-30 09:00 AM</td>
                    <td>2025-01-05 09:00 AM</td>
                    <td class="overdue-days">0</td> <!-- Placeholder for overdue days -->
                    <td>
                        <button class="view-btn" onclick="viewDetails(this)">View</button>
                        <button class="edit-btn" onclick="editItem(this)">Edit</button>
                        <button class="delete-btn" onclick="deleteItem(this)">Delete</button>
                        <button class="return-btn" onclick="markAsReturned(this)">Return</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function calculateOverdueDays() {
            const today = new Date();
            document.querySelectorAll("#tab3 tbody tr").forEach(row => {
                const returnDateStr = row.cells[4].textContent.trim(); // Extract Return Date
                const overdueDaysCell = row.querySelector('.overdue-days'); // Overdue days cell

                if (returnDateStr) {
                    const returnDate = new Date(returnDateStr); // Convert to Date object
                    const overdueTime = today - returnDate; // Time difference in milliseconds
                    const overdueDays = Math.floor(overdueTime / (1000 * 60 * 60 * 24)); // Convert to days

                    if (overdueDays > 0) {
                        overdueDaysCell.textContent = overdueDays; // Display days overdue
                    } else {
                        overdueDaysCell.textContent = 0; // No overdue days
                    }
                }
            });
        }

        // Call the function on page load
        window.onload = function () {
            updateDateTime(); // Retain any previous functionality
            calculateOverdueDays(); // Calculate overdue days
        };

    </script>
</body>
</html>
