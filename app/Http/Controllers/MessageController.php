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
        // Anti-bot check 1: Honeypot field (should be empty)
        if ($request->filled('website')) {
            // Bot detected - silently redirect without saving
            return redirect()->route('contact')->with('success', 'Votre message a bien ete envoye !');
        }

        // Anti-bot check 2: Time-based validation (minimum 3 seconds to fill form)
        $formTime = $request->input('form_time', 0);
        if (time() - $formTime < 3) {
            // Form submitted too fast - likely a bot
            return redirect()->route('contact')->with('error', 'Erreur: veuillez réessayer.');
        }

        // Anti-bot check 3: Math captcha validation
        $captchaAnswer = $request->input('captcha_answer');
        $captchaExpected = $request->input('captcha_expected');

        if ($captchaExpected) {
            $decoded = base64_decode($captchaExpected);
            $parts = explode('_', $decoded);
            $expectedAnswer = $parts[0] ?? null;
            $captchaTime = $parts[1] ?? 0;

            // Check if captcha is valid and not expired (5 minutes)
            if ($captchaAnswer != $expectedAnswer || (time() - $captchaTime) > 300) {
                return redirect()->route('contact')
                    ->withInput()
                    ->with('error', 'La réponse à la question de vérification est incorrecte.');
            }
        } else {
            return redirect()->route('contact')
                ->withInput()
                ->with('error', 'Erreur de vérification, veuillez réessayer.');
        }

        // Anti-bot check 4: Check for spam patterns in message
        $message = $request->input('message', '');
        $spamPatterns = [
            '/\b(viagra|cialis|casino|poker|lottery|winner|congratulations|click here|buy now)\b/i',
            '/\[url=/i',
            '/<a\s+href/i',
            '/http(s)?:\/\/[^\s]+/i', // URLs in message
        ];

        foreach ($spamPatterns as $pattern) {
            if (preg_match($pattern, $message)) {
                // Spam detected - silently redirect
                return redirect()->route('contact')->with('success', 'Votre message a bien ete envoye !');
            }
        }

        // Anti-bot check 5: Rate limiting by IP (max 3 messages per hour)
        $ip = $request->ip();
        $recentMessages = Message::where('ip_address', $ip)
            ->where('created_at', '>', now()->subHour())
            ->count();

        if ($recentMessages >= 3) {
            return redirect()->route('contact')
                ->with('error', 'Vous avez atteint la limite de messages. Veuillez réessayer plus tard.');
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'message' => 'required|string|max:5000',
        ]);

        // Add IP address for rate limiting
        $validated['ip_address'] = $ip;

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
