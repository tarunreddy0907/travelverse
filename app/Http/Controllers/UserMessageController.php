<?php

namespace App\Http\Controllers;

use App\Models\usermessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsermessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.contactUs');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {
            $rules = [
                'user_name' => 'required|string', 
                'email' => 'required|email', 
                'subject' => 'required|string', 
                'discription' => 'nullable|string', 
            ];
    
            $validator = Validator::make($request->all(),  $rules);
            //to show messages | check validate
            if ($validator->fails()) {
                return redirect()->route('contactUs')->withErrors($validator)->withInput();
            }
    
            //to store data code here
            // 1. connect with the model
            $user_messages = new usermessage();
    
            //set the attribute
            $user_messages->user_name = $request->user_name;
            $user_messages->email = $request->email;
            $user_messages->subject = $request->subject;
            $user_messages->discription = $request->discription;
            $user_messages->save();
            
            // Process the validated data, such as saving it to the database
            return redirect()->route('contactUs')->with('success', 'message successfully Send');
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(usermessage $usermessage)
    {
        $user_messages = usermessage::orderBy('created_at','DESC')->get();
        return view('admin.message', compact('user_messages')); // Pass data to the view
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usermessage = usermessage::findOrFail($id);
        $usermessage->delete();

        return redirect()->route('admin.message')->with('success', 'message Delete');
    }
}
