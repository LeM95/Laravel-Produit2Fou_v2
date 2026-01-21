<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('videos')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return redirect('/30032006')->with('success', 'Service créé!');
    }

    public function edit($id)
    {
        $service = Service::with('videos')->findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect('/30032006')->with('success', 'Service mis à jour!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        foreach ($service->videos as $video) {
            Storage::disk('public')->delete($video->chemin_video);
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
        }

        $service->delete();

        return redirect('/30032006')->with('success', 'Service supprimé!');
    }

    public function storeVideo(Request $request, $serviceId)
    {
        $validated = $request->validate([
            'titre' => 'required|max:255',
            'description' => 'nullable',
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ordre' => 'nullable|integer',
        ]);

        $validated['service_id'] = $serviceId;

        if ($request->hasFile('video')) {
            $validated['chemin_video'] = $request->file('video')->store('videos', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Video::create($validated);

        return redirect()->route('services.edit', $serviceId)->with('success', 'Vidéo ajoutée!');
    }

    public function destroyVideo($id)
    {
        $video = Video::findOrFail($id);
        $serviceId = $video->service_id;
        $video->delete();

        return redirect()->route('services.edit', $serviceId)->with('success', 'Vidéo supprimée!');
    }
}
