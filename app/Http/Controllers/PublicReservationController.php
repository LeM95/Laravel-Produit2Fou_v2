<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationPhoto;
use App\Models\DateBloquee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PublicReservationController extends Controller
{
    /**
     * Display the public booking page with calendar
     */
    public function index()
    {
        return view('booking.index');
    }

    /**
     * Get reserved dates for calendar (AJAX)
     */
    public function getReservedDates()
    {
        $reservations = Reservation::whereIn('statut', ['confirme', 'en_attente'])
            ->where('date_reservation', '>=', now()->startOfDay())
            ->get(['date_reservation', 'statut']);

        $events = $reservations->map(function ($r) {
            return [
                'title' => 'Indisponible',
                'start' => $r->date_reservation->format('Y-m-d'),
                'allDay' => true,
                'backgroundColor' => $r->statut === 'confirme' ? '#dc3545' : '#ffc107',
                'borderColor' => $r->statut === 'confirme' ? '#dc3545' : '#ffc107',
                'classNames' => ['unavailable-date'],
            ];
        });

        // Add blocked dates
        $datesBloquees = DateBloquee::where('date', '>=', now()->startOfDay())->get();
        $blockedEvents = $datesBloquees->map(function ($d) {
            return [
                'title' => 'Indisponible',
                'start' => $d->date->format('Y-m-d'),
                'allDay' => true,
                'backgroundColor' => '#dc3545',
                'borderColor' => '#dc3545',
                'classNames' => ['unavailable-date'],
            ];
        });

        return response()->json($events->merge($blockedEvents));
    }

    /**
     * Check if a specific date is available
     */
    public function checkDate(Request $request)
    {
        $date = $request->input('date');

        // Check reservations
        $reservationExists = Reservation::whereIn('statut', ['confirme', 'en_attente'])
            ->whereDate('date_reservation', $date)
            ->exists();

        // Check blocked dates
        $blockedExists = DateBloquee::whereDate('date', $date)->exists();

        return response()->json([
            'available' => !$reservationExists && !$blockedExists,
            'date' => $date
        ]);
    }

    /**
     * Create Stripe checkout session and redirect to payment
     */
    public function createCheckout(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:500',
            'ville' => 'required|string|max:255',
            'type_mur' => 'required|string|in:platre,beton,brique,parpaing,placo,pierre,autre',
            'photo_mur' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'photo_prises' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        // Check if date is still available (reservations)
        $reservationExists = Reservation::whereIn('statut', ['confirme', 'en_attente'])
            ->whereDate('date_reservation', $validated['date'])
            ->exists();

        // Check if date is blocked
        $blockedExists = DateBloquee::whereDate('date', $validated['date'])->exists();

        if ($reservationExists || $blockedExists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cette date n\'est plus disponible. Veuillez en choisir une autre.');
        }

        // Initialize Stripe (use env() directly as fallback)
        $stripeSecret = config('services.stripe.secret') ?: env('STRIPE_SECRET');
        Stripe::setApiKey($stripeSecret);

        try {
            // Create a pending reservation first
            $reservation = Reservation::create([
                'date_reservation' => $validated['date'],
                'client_nom' => $validated['nom'],
                'client_telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'],
                'ville' => $validated['ville'],
                'type_mur' => $validated['type_mur'],
                'statut' => 'en_attente',
                'acompte' => false,
                'prix' => 100,
            ]);

            // Upload and save photos
            if ($request->hasFile('photo_mur')) {
                $photoMurPath = $request->file('photo_mur')->store('reservations', 'public');
                ReservationPhoto::create([
                    'reservation_id' => $reservation->id,
                    'chemin_photo' => $photoMurPath,
                ]);
            }

            if ($request->hasFile('photo_prises')) {
                $photoPrisesPath = $request->file('photo_prises')->store('reservations', 'public');
                ReservationPhoto::create([
                    'reservation_id' => $reservation->id,
                    'chemin_photo' => $photoPrisesPath,
                ]);
            }

            // Create Stripe Checkout Session
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Reservation Produit2Fou - ' . date('d/m/Y', strtotime($validated['date'])),
                            'description' => 'Acompte de reservation pour le ' . date('d/m/Y', strtotime($validated['date'])),
                        ],
                        'unit_amount' => 10000, // 100 EUR in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('booking.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('booking.cancel') . '?reservation_id=' . $reservation->id,
                'metadata' => [
                    'reservation_id' => (string) $reservation->id,
                ],
            ]);

            // Store session ID on reservation
            $reservation->update(['description' => 'stripe_session:' . $session->id]);

            return redirect($session->url);

        } catch (\Exception $e) {
            // If something fails, delete the pending reservation
            if (isset($reservation)) {
                $reservation->delete();
            }

            // Log the error for debugging
            Log::error('Stripe checkout error: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la creation du paiement: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('booking.index')
                ->with('error', 'Session de paiement invalide.');
        }

        try {
            $stripeSecret = config('services.stripe.secret') ?: env('STRIPE_SECRET');
            Stripe::setApiKey($stripeSecret);
            $session = StripeSession::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $reservationId = $session->metadata->reservation_id;
                $reservation = Reservation::find($reservationId);

                if ($reservation) {
                    $reservation->update([
                        'statut' => 'confirme',
                        'acompte' => true,
                        'description' => 'Paiement Stripe: ' . $session->payment_intent,
                    ]);

                    return view('booking.success', [
                        'reservation' => $reservation,
                        'date' => $reservation->date_reservation->format('d/m/Y'),
                    ]);
                }
            }

            return redirect()->route('booking.index')
                ->with('error', 'Le paiement n\'a pas ete confirme.');

        } catch (\Exception $e) {
            return redirect()->route('booking.index')
                ->with('error', 'Erreur lors de la verification du paiement.');
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancel(Request $request)
    {
        $reservationId = $request->query('reservation_id');

        if ($reservationId) {
            $reservation = Reservation::where('id', $reservationId)
                ->where('statut', 'en_attente')
                ->first();

            if ($reservation) {
                $reservation->delete();
            }
        }

        return redirect()->route('booking.index')
            ->with('info', 'Le paiement a ete annule. Vous pouvez reessayer quand vous le souhaitez.');
    }

    /**
     * Stripe webhook to handle payment events
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            if ($webhookSecret) {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sigHeader, $webhookSecret
                );
            } else {
                $event = json_decode($payload);
            }

            // Handle the event
            switch ($event->type ?? $event['type'] ?? null) {
                case 'checkout.session.completed':
                    $session = $event->data->object ?? $event['data']['object'];
                    $this->handleSuccessfulPayment($session);
                    break;

                case 'checkout.session.expired':
                    $session = $event->data->object ?? $event['data']['object'];
                    $this->handleExpiredSession($session);
                    break;
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function handleSuccessfulPayment($session)
    {
        $reservationId = $session->metadata->reservation_id ?? $session['metadata']['reservation_id'] ?? null;

        if ($reservationId) {
            $reservation = Reservation::find($reservationId);
            if ($reservation && $reservation->statut === 'en_attente') {
                $reservation->update([
                    'statut' => 'confirme',
                    'acompte' => true,
                    'description' => 'Paiement Stripe: ' . ($session->payment_intent ?? $session['payment_intent']),
                ]);
            }
        }
    }

    private function handleExpiredSession($session)
    {
        $reservationId = $session->metadata->reservation_id ?? $session['metadata']['reservation_id'] ?? null;

        if ($reservationId) {
            $reservation = Reservation::find($reservationId);
            if ($reservation && $reservation->statut === 'en_attente') {
                $reservation->delete();
            }
        }
    }
}
