document.addEventListener('DOMContentLoaded', () => {
    const page1 = document.getElementById('page1');
    const page2 = document.getElementById('page2');
    const page3 = document.getElementById('page3');


    const badgeInput = document.getElementById('badgeNumber');
    const phoneInput = document.getElementById('phone');
    const userDetails = document.getElementById('userDetails');
    const verifyBadgeBtn = document.getElementById('verifyBadge');
    const otpInput = document.getElementById('otp');
    const verifyOtpBtn = document.getElementById('verifyOtp');
    const submitVoteBtn = document.getElementById('submitVote');
    let selectedVote = null;

    badgeInput.addEventListener('blur', () => {
        const badgeNumber = badgeInput.value;

        if (badgeNumber.length === 6 && /^0/.test(badgeNumber)) {
            fetch('fetch_user.php', {
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
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            Swal.fire('Error', 'Invalid badge number format. Must start with 0 and be 6 digits long.', 'error');
        }
    });

    verifyBadgeBtn.addEventListener('click', () => {
        const badgeNumber = badgeInput.value;
        const phoneNumber = phoneInput.value;

        if (badgeNumber && !userDetails.classList.contains('hidden')) {
            fetch('send_otp.php', {
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
        const otpValue = otpInput.value;

        fetch('verify_otp.php', {
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
            return;
        }

        fetch('submit_vote.php', {
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

    page1.classList.add('active');
});
