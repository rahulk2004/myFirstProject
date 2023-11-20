<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krishna Clinic</title>
    <style>

        footer {
            margin-top:5%;
            bottom:0;
            width:100%;
            position:fixed;
            background-color: #34495e;
            color: #ecf0f1;
            text-align: center;
            padding: 10px 0;
        }

        .footer-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .footer-col {
            flex-basis: calc(33.33% - 40px);
            text-align: center;
            padding: 5px;
        }

        .footer-icon img {
            margin-bottom: 10px;
            width: 50px;
        }

        .contact-info {
            font-size: 15px;
        }

        .copyright {
            background-color: #2c3e50;
            padding: 5px 0;
        }

        .copyright-text {
            font-size: 15px;
        }

        .copyright strong {
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer">
            <div class="footer-row">
                <div class="footer-col">
                    <div class="footer-icon">
                        <img src="images/phone-call.png" alt="Phone Icon">
                    </div>
                    <div class="contact-info">
                        <p>Telephone: +91-8980073845</p>
                    </div>
                </div>

                <div class="footer-col">
                    <div class="footer-icon">
                        <img src="images/map.png" alt="Map Icon">
                    </div>
                    <div class="contact-info">
                        <p>710-B, Tran Khunyo,</p>
                        <p>Gondal, 360311</p>
                    </div>
                </div>

                <div class="footer-col">
                    <div class="footer-icon">
                        <img src="images/mail.png" alt="Mail Icon">
                    </div>
                    <div class="contact-info">
                        <p>Email: krishnahospital@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <p class="copyright-text">© All rights reserved by <strong>Kanara Heet</strong> & <strong>Kanara Rahul</strong></p>
        </div>
    </footer>
</body>
</html>
