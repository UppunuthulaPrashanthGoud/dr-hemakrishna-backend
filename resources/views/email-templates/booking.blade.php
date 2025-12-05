<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahwan Automobiles Booking details</title>
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


      .stamp {
  transform: rotate(12deg);
	color: #555;
	font-size: 3rem;
	font-weight: 700;
	border: 0.25rem solid #555;
	display: inline-block;
	padding: 0.25rem 1rem;
	text-transform: uppercase;
	border-radius: 1rem;
	font-family: 'Courier';
	-webkit-mask-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/8399/grunge.png');
  -webkit-mask-size: 944px 604px;
  mix-blend-mode: multiply;
}

.is-nope {
  color: #D23;
  border: 0.5rem double #D23;
  transform: rotate(3deg);
	-webkit-mask-position: 2rem 3rem;
  font-size: 2rem;  
}


.is-approved {
	color: #0A9928;
	border: 0.5rem solid #0A9928;
	-webkit-mask-position: 13rem 6rem;
	transform: rotate(-14deg);
  border-radius: 0;
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
        <div class="body-text">
          <div class="body-greeting">
            Hi,{{$data['firstname']}} {{$data['lastname']}}!
          </div>
          Your order has been {{$data['result']}}!
          @if($data['result']=='failed' || $data['result']=='cancelled')
          <span class="stamp is-nope">{{$data['result']}}</span>
          @else
          <span class="stamp is-approved"}>{{$data['result']}}</span>
          @endif
        </div>
        <div class="booking-details">
          <div class="row">
            <div class="col-md-4">
              <ul>
                <li>Date : {{$data['date']}}</li>
                <li>Make : {{$data['make']}}</li>
                <li>Plate No : {{$data['plate_number']}}</li>
              </ul>
            </div>
            <div class="col-md-4">
              <ul>
                <li>TimeSlot : {{$data['timeslot']}}</li>
                <li>Model : {{$data['model']}}</li>
                <li>Plate Code : {{$data['plate_code']}}</li>
              </ul>
            </div>
            <div class="col-md-4">
              <ul>
                <li>Location : {{$data['location']}}</li>
                <li>Model Year : {{$data['model_year']}}</li>
                <li>State : {{$data['state']}}</li>
                <li>Payment status : {{$data['result']}}</li>
              </ul>
            </div>
          </div>
          <li>Description : {{$data['description']}}</li>
        </div>
        <div class="body-table" style="justify-content: center; display: flex;">
          <table style="justify-content: center; display: flex;">
            <tr class="item">
              <th>Item</th>
              <th>Amount</th>
            </tr>
            @php
                $package=json_decode($data['package'], true);
                $addons=json_decode($data['extra_packages'], true);

            @endphp
            <tr>
              <td>{{$package['name']}}</td>
              <td><span style="font-size:12px">OMR &nbsp;</span>{{$package['price']}}</td>
            </tr>
            @foreach($addons as $addon)
            <tr>
              <td>{{$addon['name']}}</td>
              <td><span style="font-size:12px">OMR &nbsp;</span>{{$addon['price']}}</td>
            </tr>
            @endforeach
            <tr>
              <td>TAX</td>
              <td><span style="font-size:12px">OMR &nbsp;</span>{{$data['tax']}}</td>
            </tr>
            <tr class="total">
              <th>Total</th>
              <th><span style="font-size:12px">OMR &nbsp;</span>{{$data['total_with_tax']}}</th>
            </tr>
          </table>
        </div>
        <div class="body-text bottom-text">
          Thank You for ordered in Bahwan Automobiles, We look forward to give services with
          You &#708;_&#708;
        </div>
      </div>
      <div class="email-footer">
        <div class="footer-text">
          &copy; <a href="#"  target="_blank">bat-oman.com</a>
        </div>
      </div>
    </div>


</body>
</html>