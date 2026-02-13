<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\ReservationServiceItem;
use App\Models\ReservationPhoto;
use App\Models\DateBloquee;
use App\Models\Inventaire;
use App\Models\Produits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    const PASSWORD = '@Mo45rh78*&';

    // Check if user is authenticated
    private function isAuthenticated()
    {
        return session('planning_authenticated') === true;
    }

    // Show login page (redirect to index with auth)
    public function showLogin()
    {
        return view('planning.login');
    }

    // Process login via AJAX
    public function login(Request $request)
    {
        if ($request->password === self::PASSWORD) {
            session(['planning_authenticated' => true]);

            // If AJAX request, return JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('planning.index');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'error' => 'Mot de passe incorrect']);
        }

        return back()->with('error', 'Mot de passe incorrect');
    }

    // Logout
    public function logout()
    {
        session()->forget('planning_authenticated');
        return redirect()->route('planning.index');
    }

    // Main planning page - READ-ONLY by default, no password required
    public function index()
    {
        $reservations = Reservation::with(['service', 'photos', 'produits.images'])
            ->orderBy('date_reservation', 'asc')
            ->get();

        $services = ReservationService::with('items.inventaire')->get();
        $inventaire = Inventaire::orderBy('nom')->get();
        $produits = Produits::with('images')->where('visible', true)->orderBy('ordre')->get();
        $isAdmin = $this->isAuthenticated();

        return view('planning.index', compact('reservations', 'services', 'inventaire', 'produits', 'isAdmin'));
    }

    // Check admin status via AJAX
    public function checkAuth()
    {
        return response()->json(['authenticated' => $this->isAuthenticated()]);
    }

    // Get calendar events as JSON
    public function calendarEvents()
    {
        $reservations = Reservation::with('service')->get();

        $events = $reservations->map(function($r) {
            return [
                'id' => $r->id,
                'title' => $r->client_nom . ' - ' . $r->ville,
                'start' => $r->date_reservation->format('Y-m-d'),
                'color' => $r->statut_color,
                'extendedProps' => [
                    'type' => 'reservation',
                    'statut' => $r->statut,
                    'adresse' => $r->adresse,
                    'telephone' => $r->client_telephone,
                    'service' => $r->service ? $r->service->nom : null,
                ]
            ];
        });

        // Add blocked dates
        $datesBloquees = DateBloquee::all();
        $blockedEvents = $datesBloquees->map(function($d) {
            return [
                'id' => 'blocked_' . $d->id,
                'title' => $d->raison ?: 'Bloque',
                'start' => $d->date->format('Y-m-d'),
                'backgroundColor' => '#6c757d',
                'borderColor' => '#6c757d',
                'extendedProps' => [
                    'type' => 'blocked',
                    'blockedId' => $d->id,
                    'raison' => $d->raison
                ]
            ];
        });

        return response()->json($events->merge($blockedEvents));
    }

    // Store new reservation
    public function store(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return redirect()->route('planning.login');
        }

        $request->validate([
            'date_reservation' => 'required|date',
            'client_nom' => 'required|string|max:255',
        ]);

        $data = $request->only([
            'date_reservation', 'client_nom', 'client_telephone',
            'ville', 'adresse', 'type_mur', 'prix', 'description',
            'service_id', 'statut'
        ]);

        $data['acompte'] = $request->has('acompte');

        $reservation = Reservation::create($data);

        // Handle photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reservations', 'public');
                ReservationPhoto::create([
                    'reservation_id' => $reservation->id,
                    'chemin_photo' => $path
                ]);
            }
        }

        return redirect()->back()->with('success', 'Réservation ajoutée!');
    }

    // Update reservation
    public function update(Request $request, $id)
    {
        if (!$this->isAuthenticated()) {
            return redirect()->route('planning.login');
        }

        $reservation = Reservation::findOrFail($id);

        $data = $request->only([
            'date_reservation', 'client_nom', 'client_telephone',
            'ville', 'adresse', 'type_mur', 'prix', 'description',
            'service_id', 'statut'
        ]);

        $data['acompte'] = $request->has('acompte');

        $reservation->update($data);

        // Handle new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reservations', 'public');
                ReservationPhoto::create([
                    'reservation_id' => $reservation->id,
                    'chemin_photo' => $path
                ]);
            }
        }

        return redirect()->back()->with('success', 'Réservation mise à jour!');
    }

    // Update status only (for installers)
    public function updateStatut(Request $request, $id)
    {
        if (!$this->isAuthenticated()) {
            return response()->json(['success' => false, 'error' => 'Non authentifié'], 401);
        }

        $reservation = Reservation::findOrFail($id);
        $reservation->statut = $request->statut;
        $reservation->save();

        return response()->json([
            'success' => true,
            'statut' => $reservation->statut,
            'statut_label' => $reservation->statut_label,
            'statut_color' => $reservation->statut_color
        ]);
    }

    // Delete reservation
    public function destroy($id)
    {
        if (!$this->isAuthenticated()) {
            return redirect()->route('planning.login');
        }

        $reservation = Reservation::findOrFail($id);

        // Delete photos
        foreach ($reservation->photos as $photo) {
            Storage::disk('public')->delete($photo->chemin_photo);
        }

        $reservation->delete();

        return redirect()->back()->with('success', 'Réservation supprimée!');
    }

    // Delete single photo
    public function deletePhoto($id)
    {
        if (!$this->isAuthenticated()) {
            return response()->json(['success' => false], 401);
        }

        $photo = ReservationPhoto::findOrFail($id);
        Storage::disk('public')->delete($photo->chemin_photo);
        $photo->delete();

        return response()->json(['success' => true]);
    }

    // ============ SERVICES/PACKS ============

    // Store new service/pack
    public function storeService(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return redirect()->route('planning.login');
        }

        $request->validate(['nom' => 'required|string|max:255']);

        $service = ReservationService::create([
            'nom' => $request->nom,
            'prix' => $request->prix ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Service/Pack créé!');
    }

    // Update service/pack
    public function updateService(Request $request, $id)
    {
        if (!$this->isAuthenticated()) {
            return redirect()->route('planning.login');
        }

        $service = ReservationService::findOrFail($id);
        $service->update([
            'nom' => $request->nom,
            'prix' => $request->prix ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Service/Pack mis à jour!');
    }

    // Delete service/pack
    public function destroyService($id)
    {
        if (!$this->isAuthenticated()) {
            return redirect()->route('planning.login');
        }

        ReservationService::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Service/Pack supprimé!');
    }

    // Add product to service/pack
    public function addServiceItem(Request $request, $serviceId)
    {
        if (!$this->isAuthenticated()) {
            return response()->json(['success' => false], 401);
        }

        $request->validate([
            'inventaire_id' => 'required|exists:inventaire,id',
            'quantite' => 'required|integer|min:1'
        ]);

        // Check if item already exists in this service
        $existing = ReservationServiceItem::where('service_id', $serviceId)
            ->where('inventaire_id', $request->inventaire_id)
            ->first();

        if ($existing) {
            $existing->quantite += $request->quantite;
            $existing->save();
        } else {
            ReservationServiceItem::create([
                'service_id' => $serviceId,
                'inventaire_id' => $request->inventaire_id,
                'quantite' => $request->quantite
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au pack!');
    }

    // Remove product from service/pack
    public function removeServiceItem($id)
    {
        if (!$this->isAuthenticated()) {
            return response()->json(['success' => false], 401);
        }

        ReservationServiceItem::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    // Get reservation details as JSON
    public function getReservation($id)
    {
        $reservation = Reservation::with(['service', 'photos', 'produits.images'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'reservation' => $reservation,
            'photos' => $reservation->photos->map(fn($p) => [
                'id' => $p->id,
                'url' => asset('storage/' . $p->chemin_photo)
            ]),
            'produits' => $reservation->produits->map(function($p) {
                // Parse notes format: "colorName|colorImageUrl"
                $notes = $p->pivot->notes ?? '';
                $parts = explode('|', $notes);
                $colorName = $parts[0] ?? '';
                $colorImage = $parts[1] ?? null;

                // If no color image stored, use first product image
                if (!$colorImage && $p->images->first()) {
                    $colorImage = asset('storage/' . $p->images->first()->chemin_image);
                }

                return [
                    'id' => $p->id,
                    'nom' => $p->nom,
                    'image' => $colorImage,
                    'notes' => $colorName
                ];
            })
        ]);
    }

    // ============ PRODUITS (COLORIS) ============

    // Add product to reservation
    public function addProduit(Request $request, $id)
    {
        if (!$this->isAuthenticated()) {
            return response()->json(['success' => false, 'error' => 'Non authentifié'], 401);
        }

        $reservation = Reservation::findOrFail($id);

        // Check if product already attached
        if (!$reservation->produits()->where('produit_id', $request->produit_id)->exists()) {
            $reservation->produits()->attach($request->produit_id, ['notes' => $request->notes ?? null]);
        }

        return response()->json(['success' => true]);
    }

    // Remove product from reservation
    public function removeProduit($reservationId, $produitId)
    {
        if (!$this->isAuthenticated()) {
            return response()->json(['success' => false, 'error' => 'Non authentifié'], 401);
        }

        $reservation = Reservation::findOrFail($reservationId);
        $reservation->produits()->detach($produitId);

        return response()->json(['success' => true]);
    }

    // ============ PUBLIC VIEW FOR WORKERS ============

    // Public view for workers (no password)
    public function publicView()
    {
        $reservations = Reservation::with(['service', 'photos', 'produits.images'])
            ->where('statut', '!=', 'annule')
            ->orderBy('date_reservation', 'asc')
            ->get();

        return view('planning.public', compact('reservations'));
    }

    // Update status from public view
    public function publicUpdateStatut(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = $request->statut;
        $reservation->save();

        return response()->json([
            'success' => true,
            'statut' => $reservation->statut,
            'statut_label' => $reservation->statut_label,
            'statut_color' => $reservation->statut_color
        ]);
    }

    // ============ DATES BLOQUEES ============

    // Get all blocked dates
    public function getDatesBloquees()
    {
        $dates = DateBloquee::orderBy('date', 'asc')->get();

        return response()->json($dates->map(function($d) {
            return [
                'id' => $d->id,
                'title' => $d->raison ?: 'Indisponible',
                'start' => $d->date->format('Y-m-d'),
                'allDay' => true,
                'backgroundColor' => '#6c757d',
                'borderColor' => '#6c757d',
                'classNames' => ['blocked-date'],
                'extendedProps' => [
                    'type' => 'blocked',
                    'raison' => $d->raison
                ]
            ];
        }));
    }

    // Block a date
    public function bloquerDate(Request $request)
    {
        if (!$this->isAuthenticated()) {
            return response()->json(['success' => false, 'error' => 'Non authentifie'], 401);
        }

        $request->validate([
            'date' => 'required|date',
        ]);

        // Check if date already blocked
        $exists = DateBloquee::whereDate('date', $request->date)->exists();
        if ($exists) {
            return response()->json(['success' => false, 'error' => 'Cette date est deja bloquee'], 400);
        }

        $dateBloquee = DateBloquee::create([
            'date' => $request->date,
            'raison' => $request->raison ?? null,
        ]);

        return response()->json([
            'success' => true,
            'id' => $dateBloquee->id,
            'message' => 'Date bloquee avec succes'
        ]);
    }

    // Unblock a date
    public function debloquerDate($id)
    {
        if (!$this->isAuthenticated()) {
            return response()->json(['success' => false, 'error' => 'Non authentifie'], 401);
        }

        $date = DateBloquee::findOrFail($id);
        $date->delete();

        return response()->json(['success' => true, 'message' => 'Date debloquee']);
    }
}
