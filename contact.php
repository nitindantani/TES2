<?php session_start(); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Contact us</h4>
            </div>
            <div class="card-body">

                <form action="sendmail.php" method="post">

                    <div class="mb-3">
                        <label for="fullname">Full Name</label>
                        <input type="text" name="full_name" required class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="email_address">Email Address</label>
                        <input type="email" name="email" id="email_address" required class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" required class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" rows="3" required class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submitContact" class="btn btn-primary">Send mail</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        var messageText = "<?= $_SESSION['status'] ?? ''; ?>";
            <?php unset($_SESSION['status']); ?>
        }
    </script>
    
</body>
</html>