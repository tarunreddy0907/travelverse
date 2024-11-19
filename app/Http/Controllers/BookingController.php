<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function showLoginView()
    {
        return view('auth.login');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $bookings = Booking::withUserAndPackage()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('profile.booking', compact('bookings'));
    }

    // Admin function to show all bookings
    public function showAllBookingData()
    {
        $pendingCountReservation = Booking::where('reservation_status', 'pending')->count();
        $conformCountReservation = Booking::where('reservation_status', 'Conform')->count();
        $rejectedCountReservation = Booking::where('reservation_status', 'Reject')->count();
        $allReservation = Booking::whereIn('reservation_status', ['pending', 'Conform', 'Reject'])->count();

        $pendingCountPayment = Booking::where('payment_status', 'pending')->count();
        $conformCountPayment = Booking::where('payment_status', 'Success')
            ->where('reservation_status', 'pending')
            ->count();
        $rejectedCountPayment = Booking::where('payment_status', 'Reject')->count();

        $bookings = Booking::withUserAndPackage()
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.bookingDetails', compact(
            'bookings', 'pendingCountReservation', 'conformCountReservation', 'rejectedCountReservation',
            'pendingCountPayment', 'conformCountPayment', 'rejectedCountPayment', 'allReservation'
        ));
    }

    // Admin function to show booking details for a single user
    public function showOneUserBookingDataAll($id)
    {
        $bookings = Booking::withUserAndPackage(['user', 'package'])
            ->where('id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.adminBookingDetailsPage', compact('bookings'));
    }

    /**
     * Display the invoice message.
     */
    public function indexInvoice()
    {
        $userId = Auth::id();
        $bookings = Booking::withUserAndPackage()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('profile.invoice', compact('bookings'));
    }

    // Show user invoice details
    public function invoiceDetails($id)
    {
        $booking = Booking::withUserAndPackage(['user', 'package'])
            ->where('id', $id)
            ->orderBy('created_at', 'DESC')
            ->first();

        return view('profile.profileInvoiceDetails', compact('booking'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'date' => 'required|date',
            'number_of_adult' => 'required|integer',
            'number_of_child' => 'required|integer',
            'pick_up_location' => 'required|string',
            'pick_up_location_details' => 'required|string',
            'total_fee' => 'required|numeric',
            'package_id' => 'required|integer' // Ensure package_id is required
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('user.packagePage', ['TravelPackage' => $request->package_id])
                             ->withErrors($validator)
                             ->withInput();
        }

        // Store data
        $bookings = new Booking();
        $userId = Auth::id();

        $bookings->user_id = $userId;
        $bookings->package_id = $request->package_id;
        $bookings->date = $request->date;
        $bookings->number_of_adult = $request->number_of_adult;
        $bookings->number_of_child = $request->number_of_child;
        $bookings->pick_up_location = $request->pick_up_location;
        $bookings->pick_up_location_details = $request->pick_up_location_details;
        $bookings->total_fee = $request->total_fee;
        $bookings->save();

        return redirect()->route('profile.Booking')->with('success', 'Travel Package Booking successfully');
    }

    // User payment receipt upload
    public function paymentReceiptImage(Request $request, $id)
    {
        $rules = [
            'payment_receipt' => 'nullable|image|mimes:jpeg,svg,png,jpg,webp|max:10240'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('profile.profileInvoiceDetails', ['id' => $id])
                             ->withErrors($validator)
                             ->withInput();
        }

        $booking = Booking::find($id);
        $booking->payment_status = 'Success';
        $booking->save();

        if ($request->hasFile('payment_receipt')) {
            $payment_receipt = $request->file('payment_receipt');
            $ext = $payment_receipt->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $payment_receipt->move(public_path('image/uploads/payment-recipt'), $imageName);
            $booking->payment_receipt = $imageName;
            $booking->save();
        }

        return redirect()->route('profile.showInvoiceDetails', ['id' => $id])->with('success', 'Payment has been made successfully');
    }

    // Admin function to accept payment receipt and confirm booking
    public function paymentReceiptImageAccept(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->payment_status = 'Success';
        $booking->reservation_status = 'Conform';
        $booking->save();

        return redirect()->route('admin.showOneUserBookingDataAll', ['id' => $id])->with('success', 'Booking confirmed');
    }

    // Admin function to reject payment receipt and booking
    public function paymentReceiptImageReject(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->payment_status = 'Reject';
        $booking->reservation_status = 'Reject';
        $booking->save();

        return redirect()->route('admin.showOneUserBookingDataAll', ['id' => $id])->with('success', 'Booking Rejected');
    }
}
