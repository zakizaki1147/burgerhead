<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(10);
        return view('customer', [
            'title' => 'Customer',
            'customers' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customerName' => 'required|string|max:100',
            'gender' => 'required|boolean',
            'phoneNumber' => 'required|string|max:20|unique:customers,phone_number',
            'address' => 'required|string|max:255',
        ], [
            'phoneNumber.unique' => 'Phone number already used! Please use different phone number!'
        ]);

        Customer::create([
            'customer_name' => $validated['customerName'],
            'gender' => $validated['gender'],
            'phone_number' => $validated['phoneNumber'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customerName' => 'required|string|max:100',
            'gender' => 'required|boolean',
            'phoneNumber' => 'required|string|max:20|unique:customers,phone_number,' . $id . ',customer_id',
            'address' => 'required|string|max:255',
        ], [
            'phoneNumber.unique' => 'Phone number already used! Please use different phone number!'
        ]);

        $customer = Customer::findOrFail($id);
        $customer->customer_name = $validated['customerName'];
        $customer->gender = $validated['gender'];
        $customer->phone_number = $validated['phoneNumber'];
        $customer->address = $validated['address'];
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully!');
    }
}
