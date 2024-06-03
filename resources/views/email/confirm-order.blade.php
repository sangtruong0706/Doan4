<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
    <h1>You have received a confirmation order email</h1>
    <p>Orders are shipped by: {{ $mailConf['shipper_name'] }}</p>
    <p> Order ID is: #{{ $mailConf['order']->id }}</p>
    <h1 class="h5 mb-3">Shipping Address</h1>
    <address>
       <strong>{{ $mailConf['order']->first_name.' '.$mailConf['order']->last_name }}</strong><br>
       {{ $mailConf['order']->province->name}}<br>
       {{ $mailConf['order']->district->name }}<br>
       {{ $mailConf['order']->ward->name }}<br>
       {{ $mailConf['order']->address }}<br>
       Phone: {{ $mailConf['order']->phone }}<br>
       Email: {{ $mailConf['order']->email }} <br>
    </address>
    <h2>Products</h2>
    <table cellpadding="3" cellspacing="3" border="0">
        <thead>
           <tr style="background: #ccc">
              <th>Product</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Size</th>
              <th>Color</th>
              <th>Total</th>
           </tr>
        </thead>
        <tbody>
          @foreach ($mailConf['order']->items as $orderItem)
              <tr>
                  <td>{{ $orderItem->name }}</td>
                  <td>{{ $orderItem->price }}</td>
                  <td>{{ $orderItem->qty }}</td>
                  <td>{{ $orderItem->size }}</td>
                  <td>{{ $orderItem->color }}</td>
                  <td>{{ $orderItem->total }}</td>
              </tr>
          @endforeach
           <tr>
              <th colspan="5" align="right">Subtotal:</th>
              <td>{{ number_format($mailConf['order']->subtotal, 0, ',', '.') }} vnđ</td>
           </tr>
           <tr>
              <th colspan="5" align="right">Shipping:</th>
              <td>{{ number_format($mailConf['order']->shipping, 0, ',', '.') }} vnđ</td>
           </tr>
           <tr>
              <th colspan="5" align="right">Discount:</th>
              <td>{{ number_format($mailConf['order']->discount, 0, ',', '.') }} vnđ</td>
           </tr>
           <tr>
              <th colspan="5" align="right">Grand Total:</th>
              <td>{{ number_format($mailConf['order']->grand_total, 0, ',', '.') }} vnđ</td>
           </tr>
        </tbody>
     </table>
</body>
</html>
