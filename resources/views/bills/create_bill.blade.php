@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Bill for: {{ $application->title }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bills.store', $application->id) }}" method="POST">
        @csrf
        <table class="table-bordered table" id="bill-items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Rate (&#8377;)</th>
                    <th>Quantity</th>
                    <th>Amount (&#8377;)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" name="items[0][description]" class="form-control description" required list="item-list" autocomplete="off">
                    </td>
                    <td><input type="number" step="0.01" name="items[0][rate]" class="form-control rate" required readonly></td>
                    <td><input type="number" name="items[0][quantity]" class="form-control quantity" required min="1" max="1"></td>
                    <td><input type="number" step="0.01" name="items[0][amount]" class="form-control amount" readonly></td>
                    <td>
                        <button type="button" class="btn btn-danger remove-btn">Remove</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-secondary" id="add-item">Add Item</button>
        <hr>
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <table class="table">
                    <tr>
                        <th>Subtotal:</th>
                        <td>&#8377; <span id="subtotal">0.00</span></td>
                    </tr>
                    <tr>
                        <th>GST (18%):</th>
                        <td>&#8377; <span id="gst">0.00</span></td>
                    </tr>
                    <tr>
                        <th>Grand Total:</th>
                        <td>&#8377; <span id="grand_total">0.00</span></td>
                    </tr>
                </table>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" id="generate-bill">Generate Bill</button>
    </form>
</div>

<!-- Datalist for items -->
<datalist id="item-list">
    @foreach ($inventoryItems as $item)
        <option value="{{ $item->product_name }}" data-rate="{{ $item->product_price }}" data-stock="{{ $item->product_quantity }}">
            {{ $item->product_name }}
        </option>
    @endforeach
</datalist>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let itemIndex = 1;
    let selectedItems = [];
    function recalculate() {
        let subtotal = 0;
        $('#bill-items-table tbody tr').each(function() {
            let rate = parseFloat($(this).find('.rate').val()) || 0;
            let quantity = parseInt($(this).find('.quantity').val()) || 0;
            let amount = rate * quantity;
            $(this).find('.amount').val(amount.toFixed(2));
            subtotal += amount;
        });
        let gst = subtotal * 0.18;
        let grand_total = subtotal + gst;

        $('#subtotal').text(subtotal.toFixed(2));
        $('#gst').text(gst.toFixed(2));
        $('#grand_total').text(grand_total.toFixed(2));
    }

    $('#add-item').click(function() {
        let lastRow = $('#bill-items-table tbody tr:last');
        let description = lastRow.find('.description').val();
        let rate = lastRow.find('.rate').val();
        let quantity = lastRow.find('.quantity').val();

        if (description && rate && quantity) {
            if (selectedItems.includes(description)) {
                alert('Item already selected.');
                lastRow.find('.description').val('');
                lastRow.find('.rate').val('');
                lastRow.find('.quantity').val('');
                lastRow.find('.amount').val('');
                return;
            }
            selectedItems.push(description);
            let newRow = `
                <tr>
                    <td>
                        <input type="text" name="items[${itemIndex}][description]" class="form-control description" required list="item-list" autocomplete="off">
                    </td>
                    <td><input type="number" step="0.01" name="items[${itemIndex}][rate]" class="form-control rate" required readonly></td>
                    <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" required min="1" max="1"></td>
                    <td><input type="number" step="0.01" name="items[${itemIndex}][amount]" class="form-control amount" readonly></td>
                    <td>
                        <button type="button" class="btn btn-danger remove-btn">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </td>
                </tr>
            `;
            $('#bill-items-table tbody').append(newRow);
            itemIndex++;
        } else {
            alert('Please fill in all fields before adding a new item.');
        }
    });

    $(document).on('click', '.remove-btn', function() {
        $(this).closest('tr').remove();
        selectedItems = selectedItems.filter(item => item !== $(this).closest('tr').find('.description').val());
        recalculate();
    });

    $(document).on('input', '.rate, .quantity', function() {
        recalculate();
    });

    $(document).on('input', '.description', function() {
        let description = $(this).val();
        let option = $('#item-list option').filter(function() {
            return $(this).val() === description;
        });

        let rate = option.data('rate');
        let stock = option.data('stock');

        if (rate !== undefined && stock !== undefined) {
            $(this).closest('tr').find('.rate').val(rate);
            $(this).closest('tr').find('.quantity').attr('max', stock);
            recalculate();
        }
    });

    $('#generate-bill').click(function(e) {
        let items = [];
        $('#bill-items-table tbody tr').each(function() {
            let description = $(this).find('.description').val();
            let rate = parseFloat($(this).find('.rate').val()) || 0;
            let quantity = parseInt($(this).find('.quantity').val()) || 0;
            let amount = rate * quantity;
            items.push({
                description: description,
                rate: rate,
                quantity: quantity,
                amount: amount,
            });
        });

        let duplicates = items.filter((item, index, self) =>
            index !== self.findIndex((t) => (
                t.description === item.description &&
                t.rate === item.rate &&
                t.quantity === item.quantity &&
                t.amount === item.amount
            )));
        if (duplicates.length > 0) {
            alert('Duplicate items found.');
            e.preventDefault();
        }
    });

    recalculate();
</script>
@endsection

