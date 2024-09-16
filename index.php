<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logo/favicon.ico">
    <title>Safety Awards Voting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/loader.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">

        <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
            <h3 class="m-0" style="text-align:center;">Safety Milestone Awards</h3>
            <img class="img-fluid rounded mx-auto my-4" loading="lazy" src="./assets/images/logo/logo.png" width="80"
                height="50" alt="VALCO Logo">
        </div>

        <div id="page1" class="page">
            <h2 class="mb-4 text-center">Enter Badge Number</h2>
            <form id="formPage1">
                <div class="mb-3">
                    <label for="badgeNumber" class="form-label">Badge Number:</label>
                    <input type="text" id="badgeNumber" class="form-control" maxlength="6" required pattern="^0\d{5}$"
                        placeholder="Enter your badge number">
                </div>
                <div id="userDetails" class="hidden">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" id="userName" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Safety Section:</label>
                        <input type="text" id="safetySection" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department:</label>
                        <input type="text" id="department" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone:</label>
                        <input type="text" id="phone" class="form-control" name="phoneNumber" readonly>
                        <div class="form-text">An OTP will be sent to this phone number.</div>
                    </div>
                </div>
                <button type="button" id="verifyBadge" class="btn btn-danger w-100">Verify</button>
            </form>
        </div>

        <div id="page2" class="page hidden">
            <h2 class="mb-4 text-center">Enter OTP</h2>
            <form id="formPage2">
                <div class="mb-3">
                    <label for="otp" class="form-label">OTP:</label>
                    <input type="text" id="otp" class="form-control" maxlength="6" required placeholder="Enter OTP">
                </div>
                <button type="button" id="verifyOtp" class="btn btn-danger w-100">Verify OTP</button>
            </form>
        </div>

        <div id="page3" class="page hidden">
            <h2 class="mb-4 text-center">Cast Your Vote</h2>

            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card vote-card" data-value="award1">
                            <img src="assets/images/awards/award1.png" class="card-img-top" alt="Award 1">
                            <div class="card-body">
                                <p class="card-text">MELCOM voucher (GHS 550)</p>
                                <p class="card-text">Commemorative Souvenir (VALCO Branded 480ML Liquid Flask)</p>
                            </div>
                            <input type="radio" name="vote" value="award1" hidden>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card vote-card" data-value="award2">
                            <img src="assets/images/awards/award2.png" alt="Award 2">
                            <div class="card-body">
                                <p class="card-text">Non-stick Sauce Pan (3 pieces)</p>
                                <p class="card-text">Commemorative Souvenir (VALCO Branded 480ML Liquid Flask)</p>
                            </div>
                            <input type="radio" name="vote" value="award2" hidden>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card vote-card" data-value="award3">
                            <img src="assets/images/awards/award3.png" alt="Award 3">
                            <div class="card-body">
                                <p class="card-text">China Mall Voucher (GHS 550)</p>
                                <p class="card-text">Commemorative Souvenir (VALCO Branded 480ML Liquid Flask)</p>
                            </div>
                            <input type="radio" name="vote" value="award3" hidden>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card vote-card" data-value="award4">
                            <img src="assets/images/awards/award4.png" alt="Award 4">
                            <div class="card-body">
                                <p class="card-text">28 Quart Ice Chest</p>
                                <p class="card-text">Commemorative Souvenir (VALCO Branded 480ML Liquid Flask)</p>
                            </div>
                            <input type="radio" name="vote" value="award4" hidden>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="submitVote" class="btn btn-danger w-100 mt-4">Submit Vote</button>
        </div>

        <div id="page4" class="page hidden">
            <h2 class="mb-4 text-center">Thank You for Voting!</h2>
            <p class="text-center">Here are the current voting results:</p>
            <canvas id="resultsChart" width="400" height="400"></canvas>
            <button type="button" id="finishBtn" class="btn btn-danger w-100 mt-4">Finish</button>
        </div>

        <footer>
            <div class="text-center text-md-start">
                &copy; Volta Aluminium Company - 2024. All Rights Reserved.
            </div>
        </footer>

        <div id="loader" class="loader-container">
            <div class="loader"></div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/loader.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>