<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
  <style>
    /* Include the same styles you used for the regular invoice */
    .invoice-box {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border: 1px solid #eee;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
      font-size: 16px;
      line-height: 24px;
      font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
      color: #555;
    }
    .invoice-box table {
      width: 100%;
      line-height: inherit;
      text-align: left;
      border-collapse: collapse;
    }
    .invoice-box table td {
      padding: 5px;
      vertical-align: top;
    }
    .invoice-box table tr.heading td {
      background: #eee;
      border-bottom: 1px solid #ddd;
      font-weight: bold;
    }
    .invoice-box table tr.item td {
      border-bottom: 1px solid #eee;
    }
    .invoice-box table tr.total td:nth-child(4) {
      border-top: 2px solid #eee;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
      <tr class="top">
        <td colspan="4">
          <table>
            <tr>
              <td>
                <h2>Raushan Edibles Wholesale</h2>
                Buyer: {{ $application->title }}<br>
                Created: {{ $bill->created_at->format('d-m-Y') }}
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr class="heading">
        <td>Description</td>
        <td>Rate (Rs.)</td>
        <td>Quantity</td>
        <td>Amount (Rs.)</td>
      </tr>

      @foreach ($bill->billItems as $item)
        <tr class="item">
          <td>{{ $item->description }}</td>
          <td>{{ number_format($item->rate, 2) }}</td>
          <td>{{ $item->quantity }}</td>
          <td>{{ number_format($item->amount, 2) }}</td>
        </tr>
      @endforeach

      <tr class="total">
        <td colspan="3" class="text-end">Subtotal:</td>
        <td>Rs. {{ number_format($bill->subtotal, 2) }}</td>
      </tr>
      <tr class="total">
        <td colspan="3" class="text-end">GST (18%):</td>
        <td> Rs. {{ number_format($bill->gst, 2) }}</td>
      </tr>
      <tr class="total">
        <td colspan="3" class="text-end">Grand Total:</td>
        <td>Rs. {{ number_format($bill->grand_total, 2) }}</td>
      </tr>
    </table>
  </div>
</body>
</html>
