<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Application;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;

class BillController extends Controller
{

    public function index()
    {
        $bills = Bill::with('application')->get(); // Retrieve all bills along with their associated application data
        return view('bills.index', compact('bills'));
    }

    public function showApplications()
    {
        // Fetch all applications
        $applications = Application::all();

        // Return the view with the applications
        return view('bills.create', compact('applications'));
    }

    public function downloadPdf($application_id, $bill_id)
    {
        $application = Application::findOrFail($application_id);
        $bill = Bill::with('billItems')->findOrFail($bill_id);

        // Generate the PDF
        $pdf = FacadePdf::loadView('bills.pdf_invoice', compact('application', 'bill'));

        // Download the PDF as a file
        return $pdf->download('invoice-' . $bill_id . '.pdf');
    }


    // Show form to create bill for a specific application
    public function create($application_id)
    {
        // Retrieve the application based on the ID
        $application = Application::findOrFail($application_id);

        // Retrieve all inventory items (assuming you have an Inventory model)
        $inventoryItems = Inventory::all();

        // Pass both application and inventory items to the view
        return view('bills.create_bill', compact('application', 'inventoryItems'));
    }


    public function store(Request $request, $application_id)
    {
        $application = Application::findOrFail($application_id);

        // Validate bill items
        $request->validate([
            'items.*.description' => 'required|string',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $items = $request->input('items');
        $subtotal = 0;
        $processedItems = []; // Store each processed item separately

        // Calculate subtotal and update inventory quantities
        foreach ($items as $item) {
            // Fetch the inventory product by description
            $inventory = Inventory::where('product_name', $item['description'])->first();

            if ($inventory) {
                // Get the price and stock from the inventory
                $rate = $inventory->product_price;
                $availableQuantity = $inventory->product_quantity;

                // Ensure the quantity doesn't exceed available stock
                $quantity = min($item['quantity'], $availableQuantity);

                // Calculate the item amount
                $amount = $rate * $quantity;
                $subtotal += $amount;

                // Reduce inventory quantity after billing
                $inventory->product_quantity -= $quantity;
                $inventory->save();

                // Store the processed item details for later use
                $processedItems[] = [
                    'description' => $item['description'],
                    'rate' => $rate,
                    'quantity' => $quantity,
                    'amount' => $amount,
                ];
            }
        }

        // Calculate GST and grand total
        $gst = $subtotal * 0.18; // 18% GST
        $grand_total = $subtotal + $gst;

        // Create the main Bill
        $bill = Bill::create([
            'application_id' => $application->id,
            'subtotal' => $subtotal,
            'gst' => $gst,
            'grand_total' => $grand_total,
        ]);

        // Create Bill Items for each processed item
        foreach ($processedItems as $processedItem) {
            BillItem::create([
                'bill_id' => $bill->id,
                'description' => $processedItem['description'],
                'rate' => $processedItem['rate'],
                'quantity' => $processedItem['quantity'],
                'amount' => $processedItem['amount'],
            ]);
        }

        return redirect()->route('bills.show', [$application->id, $bill->id])->with('success', 'Bill created successfully.');
    }





    // Show the bill
    public function show($application_id, $bill_id)
    {
        $application = Application::findOrFail($application_id);
        $bill = Bill::with('billItems')->findOrFail($bill_id);

        return view('bills.show', compact('application', 'bill'));
    }

    // Additional methods like index, edit, etc., can be added as needed
}
