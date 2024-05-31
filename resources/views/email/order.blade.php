<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
    <h1>Thank for your order!!</h1>
    <p>Your order ID is: #{{ $mailData['order']->id }}</p>
    <h1 class="h5 mb-3">Shipping Address</h1>
    <address>
       <strong>{{ $mailData['order']->first_name.' '.$mailData['order']->last_name }}</strong><br>
       {{ $mailData['order']->province->name}}<br>
       {{ $mailData['order']->district->name }}<br>
       {{ $mailData['order']->ward->name }}<br>
       {{ $mailData['order']->address }}<br>
       Phone: {{ $mailData['order']->phone }}<br>
       Email: {{ $mailData['order']->email }} <br>
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
          @foreach ($mailData['order']->items as $orderItem)
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
              <td>{{ number_format($mailData['order']->subtotal, 0, ',', '.') }} vnđ</td>
           </tr>
           <tr>
              <th colspan="5" align="right">Shipping:</th>
              <td>{{ number_format($mailData['order']->shipping, 0, ',', '.') }} vnđ</td>
           </tr>
           <tr>
              <th colspan="5" align="right">Discount:</th>
              <td>{{ number_format($mailData['order']->discount, 0, ',', '.') }} vnđ</td>
           </tr>
           <tr>
              <th colspan="5" align="right">Grand Total:</th>
              <td>{{ number_format($mailData['order']->grand_total, 0, ',', '.') }} vnđ</td>
           </tr>
        </tbody>
     </table>
</body>
</html>
