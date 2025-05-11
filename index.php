<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist Places, Activities, and Events in Gujarat</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-qrcode/1.0/jquery.qrcode.min.js"></script>
</head>
<body>
    <header>
        <div class="logo">TicketsQR</div>
        <nav>
            <a href="about.html">About us</a>
            <a href="contact.php">Contact us</a>
            <a href="find_ticket.php">My Ticket</a>
        </nav>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search...">
            <button id="searchButton">Search</button>
        </div>
        <div class="auth-links">
            <?php if (isset($_SESSION['user_name'])): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.html">Sign In</a>
                <a href="signup.html">Sign Up</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="container">
        <h1>Explore Famous Tourist Places, Activities, and Events in Gujarat</h1>

        <!-- Tourist Places Section -->
        <h2>Tourist Places</h2>
        <div class="places" id="placesContainer">
            <div class="place-card">
                <img src="Images/kankaria-lake-ahmedabad.jpg" alt="Kankaria Lake">
                <h3>Kankaria Lake</h3>
                <p class="location">Kankaria Lake, Ahmadabad</p>
                <p>The historical Kankaria Lake having a periphery of about 2.5 Km has been the symbol of Ahmadabad's identity since almost 500 years.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Kankaria+Lake,+Ahmadabad" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Kankaria%20Lake'">Book Tickets</button>

            </div>

            <div class="place-card">
                <img src="Images/The-Statue-of-Unity-in-Gujarat-India.webp" alt="Statue of Unity">
                <h3>Statue of Unity</h3>
                <p class="location">Kevadia</p>
                <p>The world's tallest statue is located in Gujarat. The Statue of Unity depicts Indian freedom fighter and politician Sardar Vallabhbhai Patel.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Statue of Unity,+Kevadia" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Statue of Unity'">Book Tickets</button>

            </div>

            <div class="place-card">
                <img src="Images/Rani_ki_vav.jpg" alt="Rani ki vav">
                <h3>Rani ki vav</h3>
                <p class="location">Rani ki vav, Patan</p>
                <p>Rani ki vav is an intricately constructed stepwell situated in the town of Patan in Gujarat, India.</p>
                <p class="map"><a href="https://www.google.com/maps?q=patan,+Rani ki vav" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Rani ki vav'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/Tirupati Rishivan.avif" alt="Tirupati Rushivan Adventure Park">
                <h3>Tirupati Rushivan Adventure Park</h3>
                <p class="location">Tirupati Rushivan Adventure Park</p>
                <p>Tirupati Rushivan Adventure Park is a popular theme park offering thrilling rides, water slides, and replicas of world-famous monuments.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Tirupati Rushivan Adventure Park" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Tirupati Rushivan Adventure Park'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/sun-temple-modhera.jpg" alt="Modhera Sun Temple">
                <h3>Modhera Sun Temple</h3>
                <p class="location">Modhera</p>
                <p>The Sun Temple of Modhera is a Hindu temple dedicated to the solar deity Surya located at Modhera village of Mehsana district, Gujarat, India.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Becharaji,+Modhera sun temple" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Modhera Sun Temple'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/Kutch-Museum-Banner.jpg" alt="Kutch Museum">
                <h3>Kutch Museum</h3>
                <p class="location">Bhuj, Gujarat</p>
                <p>Kutch Museum, located in Bhuj, Gujarat, is the oldest museum in the state, showcasing a rich collection of Kutch’s history, culture, and tribal artifacts.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Kutch Museum,+Bhuj,+Gujarat" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Kutch Museum'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/gir-forest.jpg" alt="Gir National Park">
                <h3>Gir National Park</h3>
                <p class="location">Junagadh, Gujarat</p>
                <p>Home to the majestic Asiatic Lions, Gir is a key wildlife destination in Gujarat.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Gir+National+Park,+Gujarat" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Gir National Park'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/blackbuck-national-park.jpg" alt="Blackbuck National Park">
                <h3>Blackbuck National Park</h3>
                <p class="location">Velavadar, Gujarat</p>
                <p>Known for blackbuck antelope and unique grassland ecosystem.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Blackbuck+National+Park,+Velavadar" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Blackbuck National Park'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/indroda-nature-park.jpg" alt="Indroda Nature Park">
                <h3>Indroda Nature Park</h3>
                <p class="location">Gandhinagar, Gujarat</p>
                <p>A zoological park, botanical garden, and dinosaur museum all in one location.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Indroda+Nature+Park,+Gandhinagar" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?Indroda Nature Park'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/vansda-national-park.jpg" alt="Vansda National Park">
                <h3>Vansda National Park</h3>
                <p class="location">Navsari, Gujarat</p>
                <p>A dense forest sanctuary rich in biodiversity and a peaceful retreat into nature.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Vansda+National+Park,+Gujarat" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Vansda National Park'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/laxmi-vilas-palace.jpg" alt="Laxmi Vilas Palace">
                <h3>Laxmi Vilas Palace</h3>
                <p class="location">Vadodara, Gujarat</p>
                <p>One of the grandest palaces in India, still used as a royal residence.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Laxmi+Vilas+Palace,+Vadodara" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Laxmi Vilas Palace'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/saputara-hill-station.jpg" alt="Saputara Hill Station">
                <h3>Saputara Hill Station</h3>
                <p class="location">Dang, Gujarat</p>
                <p>Gujarat’s only hill station with panoramic views and cable car rides.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Saputara+Hill+Station,+Gujarat" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Saputara Hill Station'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/white-rann-of-kutch.jpg" alt="White Rann of Kutch">
                <h3>White Rann of Kutch</h3>
                <p class="location">Dhordo, Gujarat</p>
                <p>Salt desert famous for its Rann Utsav festival and scenic beauty.</p>
                <p class="map"><a href="https://www.google.com/maps?q=White+Rann+of+Kutch,+Dhordo" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=White Rann of Kutch'">Book Tickets</button>
            </div>

            <!-- Museums -->
            <div class="place-card">
                <img src="Images/baroda-museum.jpg" alt="Baroda Museum">
                <h3>Baroda Museum & Picture Gallery</h3>
                <p class="location">Vadodara, Gujarat</p>
                <p>A blend of Indian and European architectural styles featuring artifacts and art.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Baroda+Museum+and+Picture+Gallery" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Baroda Museum & Picture Gallery'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/sardar-patel-museum.jpg" alt="Sardar Vallabhbhai Patel Museum">
                <h3>Sardar Vallabhbhai Patel Museum</h3>
                <p class="location">Ahmedabad, Gujarat</p>
                <p>Dedicated to the life and contributions of Sardar Patel with interactive exhibits.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Sardar+Patel+National+Memorial" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Sardar Vallabhbhai Patel Museum'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/lothal-museum.jpg" alt="Lothal Museum">
                <h3>Lothal Archaeological Museum</h3>
                <p class="location">Lothal, Gujarat</p>
                <p>Exhibits tools, pottery, and seals from the ancient Harappan port town.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Lothal+Museum,+Gujarat" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Lothal Archaeological Museum'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/vintage-car-museum.jpg" alt="Auto World Vintage Car Museum">
                <h3>Auto World Vintage Car Museum</h3>
                <p class="location">Ahmedabad, Gujarat</p>
                <p>Collection of classic cars from Rolls Royce to Bentleys with ride options.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Auto+World+Vintage+Car+Museum,+Ahmedabad" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Auto World Vintage Car Museum'">Book Tickets</button>
            </div>

            <div class="place-card">
                <img src="Images/vechaar-museum.jpg" alt="Vechaar Utensils Museum">
                <h3>Vechaar Utensils Museum</h3>
                <p class="location">Ahmedabad, Gujarat</p>
                <p>Showcasing traditional Indian utensils in brass, copper, and clay.</p>
                <p class="map"><a href="https://www.google.com/maps?q=Vechaar+Utensils+Museum,+Ahmedabad" target="_blank">View on Map</a></p>
                <button class="book-btn" onclick="window.location.href='Register.php?place=Vechaar Utensils Museum'">Book Tickets</button>
            </div>
        </div>
    </div>

    <!-- Tourist Details -->
    <div id="ticketModal">
        <div id="modalContent">
            <h3>Tourist Details</h3>
            <div class="modal-buttons">
                <button id="touristDetailsButton">Tourist Details</button>
                <button id="closeModal">Close</button>
            </div>
            <div id="qrcode"></div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        // Close ticket modal
        $('#closeModal').click(function () {
            $('#ticketModal').css('display', 'none');
            $('body').css('overflow', 'auto');
            $('#qrcode').empty();
        });

        // Search filtering
        $('#searchButton').click(function () {
            const searchTerm = $('#searchInput').val().toLowerCase();
            $('.place-card').each(function () {
                const placeName = $(this).find('h3').text().toLowerCase();
                if (placeName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Optional: Enable pressing "Enter" in the search input
        $('#searchInput').keypress(function (e) {
            if (e.which === 13) {
                $('#searchButton').click();
            }
        });
    });

    // Booking function: opens Register.php with the selected place
    function bookPlace(button) {
        const placeCard = button.closest('.place-card');
        const placeName = placeCard.querySelector('h3').textContent.trim();
        window.location.href = `Register.php?place=${encodeURIComponent(placeName)}`;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'success') {
            Swal.fire({
                title: 'Thank you!',
                text: '',
                icon: 'success'
            });
        }
    </script>
</html>
