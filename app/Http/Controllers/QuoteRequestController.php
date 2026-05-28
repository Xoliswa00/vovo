<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    // Guest: show quote form
    public function create()
    {
        return view('logistics.quotes.create');
    }

    // Guest: submit quote
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'       => 'required|string|max:255',
            'client_email'      => 'required|email',
            'client_phone'      => 'nullable|string|max:20',
            'origin'            => 'required|string|max:255',
            'destination'       => 'required|string|max:255',
            'cargo_description' => 'required|string',
            'weight_kg'         => 'nullable|integer|min:0',
            'preferred_date'    => 'nullable|date|after_or_equal:today',
        ]);

        QuoteRequest::create($validated);

        return redirect()->route('quote.create')->with('success', 'Your quote request has been received. We\'ll be in touch soon!');
    }

    // Admin: list all quote requests
    public function index(Request $request)
    {
        $status = $request->query('status');
        $quotes = QuoteRequest::when($status, fn($q) => $q->where('status', $status))
            ->latest()->paginate(20);

        return view('logistics.quotes.index', compact('quotes', 'status'));
    }

    // Admin: view a quote request
    public function show(QuoteRequest $quoteRequest)
    {
        return view('logistics.quotes.show', compact('quoteRequest'));
    }

    // Admin: update status / add quote price
    public function update(Request $request, QuoteRequest $quoteRequest)
    {
        $validated = $request->validate([
            'status'       => 'required|in:pending,quoted,accepted,rejected',
            'quoted_price' => 'nullable|numeric|min:0',
            'admin_notes'  => 'nullable|string',
        ]);

        $quoteRequest->update($validated);

        return redirect()->route('quote-requests.show', $quoteRequest)->with('success', 'Quote request updated.');
    }

    public function destroy(QuoteRequest $quoteRequest)
    {
        $quoteRequest->delete();
        return redirect()->route('quote-requests.index')->with('success', 'Quote request deleted.');
    }
}
