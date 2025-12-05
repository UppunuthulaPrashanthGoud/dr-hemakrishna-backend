<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahwan Automobiles Promotion Mail</title>
    <style>
      .email {
        max-width: 480px;
        margin: 1rem auto;
        border-radius: 10px;
        border-top: #d74034 2px solid;
        border-bottom: #d74034 2px solid;
        box-shadow: 0 2px 18px rgba(0, 0, 0, 0.2);
        padding: 1.5rem;
        font-family: Arial, Helvetica, sans-serif;
      }
      .email .email-head {
        border-bottom: 1px solid rgba(0, 0, 0, 0.2);
        padding-bottom: 1rem;
      }
      .email .email-head .head-img {
        max-width: 240px;
        padding: 0 0.5rem;
        display: block;
        margin: 0 auto;
        justify-content: center;
        display:flex;
      }

      .email-body .invoice-icon {
        max-width: 80px;
        margin: 1rem auto;
      }
      .email-body .invoice-icon img {
        width: 100%;
      }

      .email-body .body-text {
        padding: 2rem 0 1rem;
        text-align: center;
        font-size: 1.15rem;
      }
      .email-body .body-text.bottom-text {
        padding: 2rem 0 1rem;
        text-align: center;
        font-size: 0.8rem;
      }
      .email-body .body-text .body-greeting {
        font-weight: bold;
        margin-bottom: 1rem;
      }

      .email-body .body-table {
        text-align: left;
      }
      .email-body .body-table table {
        width: 100%;
        font-size: 1.1rem;
      }
      .email-body .body-table table .total {
        background-color: hsla(4, 67%, 52%, 0.12);
        border-radius: 8px;
        color: #d74034;
      }
      .email-body .body-table table .item {
        border-radius: 8px;
        color: #d74034;
      }
      .email-body .body-table table th,
      .email-body .body-table table td {
        padding: 10px;
      }
      .email-body .body-table table tr:first-child th {
        border-bottom: 1px solid rgba(0, 0, 0, 0.2);
      }
      .email-body .body-table table tr td:last-child {
        text-align: right;
      }
      .email-body .body-table table tr th:last-child {
        text-align: right;
      }
      .email-body .body-table table tr:last-child th:first-child {
        border-radius: 8px 0 0 8px;
      }
      .email-body .body-table table tr:last-child th:last-child {
        border-radius: 0 8px 8px 0;
      }
      .email-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.2);
      }
      .email-footer .footer-text {
        font-size: 0.8rem;
        text-align: center;
        padding-top: 1rem;
      }
      .email-footer .footer-text a {
        color: #d74034;
      }
      .booking-details ul{
        list-style: circle;
      }
    </style>

</head>
<body>
    <div class="email">
      <div class="email-head" style="justify-content: center; display: flex;">
        <div class="head-img">
          <img
            src="https://bat-oman.com/assets/front/logo/bhawan5.png"
            alt="Bahwan log"
            style="height: 100%; width: 100%;"
            
          />
        </div>
      </div>
      <div class="email-body">
        

        {!! $data['message'] !!}
        <div class="body-text bottom-text">
          Thank You for connecting in Bahwan Automobiles, We look forward to give services with
          You
        </div>
      </div>
      <div class="email-footer">
        <div class="footer-text">
          &copy; <a href="#"  target="_blank">https://bat-oman.com/</a>
        </div>
      </div>
    </div>


</body>
</html>