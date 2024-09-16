document.addEventListener('DOMContentLoaded', () => {
    const page1 = document.getElementById('page1');
    const page2 = document.getElementById('page2');
    const page3 = document.getElementById('page3');
    const page4 = document.getElementById('page4');

    const badgeInput = document.getElementById('badgeNumber');
    const phoneInput = document.getElementById('phone');
    const userDetails = document.getElementById('userDetails');
    const verifyBadgeBtn = document.getElementById('verifyBadge');
    const otpInput = document.getElementById('otp');
    const verifyOtpBtn = document.getElementById('verifyOtp');
    const submitVoteBtn = document.getElementById('submitVote');
    const resultsChart = document.getElementById('resultsChart').getContext('2d');
    let selectedVote = null;

    badgeInput.addEventListener('blur', () => {
        const badgeNumber = badgeInput.value;

        if (badgeNumber.length === 6 && /^0/.test(badgeNumber)) {
            fetch('helpers/fetch_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ badgeNumber })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('userName').value = data.user.name;
                        document.getElementById('safetySection').value = data.user.safety_section;
                        document.getElementById('department').value = data.user.department;
                        document.getElementById('phone').value = data.user.phone;
                        userDetails.classList.remove('hidden');
                    } else if (data.alreadyVoted === 'true') {
                        Swal.fire('Notice', 'You have already voted.', 'info').then(() => {
                            page1.classList.remove('active');
                            page4.classList.add('active');
                            loadChart();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            Swal.fire('Error', 'Invalid badge number format.', 'error');
        }
    });

    verifyBadgeBtn.addEventListener('click', () => {
        const badgeNumber = badgeInput.value;
        const phoneNumber = phoneInput.value;

        if (badgeNumber && !userDetails.classList.contains('hidden')) {
            verifyBadgeBtn.disabled = true;

            fetch('helpers/send_otp.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ phoneNumber })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success' && data.otp_sent) {
                        Swal.fire('Success!', 'Verified, OTP sent to your phone.', 'success');
                        setTimeout(() => {
                            page1.classList.remove('active');
                            page2.classList.add('active');
                        }, 2000);
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                });
        }
    });

    verifyOtpBtn.addEventListener('click', () => {
        verifyOtpBtn.disabled = true;
        const otpValue = otpInput.value;

        fetch('helpers/verify_otp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ otp: otpValue })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Success!', 'OTP verified.', 'success');
                    setTimeout(() => {
                        page2.classList.remove('active');
                        page3.classList.add('active');
                    }, 2000);
                } else {
                    Swal.fire('Error', 'Invalid OTP!', 'error');
                    verifyOtpBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            });
    });

    document.querySelectorAll('.vote-card').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.vote-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            selectedVote = card.getAttribute('data-value');
            card.querySelector('input[type="radio"]').checked = true;
        });
    });

    submitVoteBtn.addEventListener('click', () => {
        if (!selectedVote) {
            Swal.fire('Error', 'Please select an option to vote.', 'error');
            submitVoteBtn.disabled = false;
            return;
        }
        submitVoteBtn.disabled = true;

        fetch('helpers/submit_vote.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                vote: selectedVote
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Thank you!', 'Your vote has been submitted.', 'success');
                    setTimeout(() => {
                        page3.classList.remove('active');
                        page4.classList.add('active');
                        loadChart();
                    }, 2000);
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
            });
    });

    function loadChart() {
        fetch('helpers/get_results.php')
            .then(response => response.json())
            .then(data => {
                const resultsData = {
                    labels: ['Melcom', 'Non-stick Pans', 'China Mall', 'Ice Chest'],
                    datasets: [{
                        data: [data.award1, data.award2, data.award3, data.award4],
                        backgroundColor: ['#f20505', '#0529f2', '#0a820a', '#a65e16'],
                    }]
                };

                new Chart(resultsChart, {
                    type: 'doughnut',
                    data: resultsData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error loading results:', error);
            });
    }

    const finishBtn = document.getElementById('finishBtn');
    finishBtn.addEventListener('click', () => {
        window.location.href = 'helpers/kill.php';
    });

    page1.classList.add('active');
});