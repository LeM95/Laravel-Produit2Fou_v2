<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Store a new message from contact form
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Message::create($validated);

        return redirect()->route('contact')->with('success', 'Votre message a bien ete envoye !');
    }

    /**
     * Display all messages in admin panel
     */
    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        $unreadCount = Message::where('lu', false)->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display a single message
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);

        // Mark as read
        if (!$message->lu) {
            $message->lu = true;
            $message->save();
        }

        $unreadCount = Message::where('lu', false)->count();

        return view('admin.messages.show', compact('message', 'unreadCount'));
    }

    /**
     * Delete a message
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message supprime avec succes');
    }

    /**
     * Get unread count for AJAX
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => Message::where('lu', false)->count()
        ]);
    }
}
