<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SpaceController extends Controller
{
    public function index()
    {
        $spaces = Space::latest()->get();
        return view('admin.spaces.index', compact('spaces'));
    }

    public function create()
    {
        return view('admin.spaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'days' => 'required',
            'capacity' => 'required',
            'location' => 'required',
            'type' => 'required',
        ]);
        $days = $request->days;
      
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['availability' => $days]);
      //  return request()->all();
        $space = Space::create($request->all());


        return redirect()->route('spaces.index')->with('success', 'Space created successfully!');
    }

    public function show($id)
    {
        $space = Space::findOrFail($id);
        return view('admin.spaces.show', compact('space'));
    }

    public function edit($id)
    {
        $space = Space::findOrFail($id);
        return view('admin.spaces.edit', compact('space'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'days' => 'required',
            'capacity' => 'required',
            'location' => 'required',
            'type' => 'required',
        ]);
        $days = $request->days;
        $request->merge(['availability' => $days]);
       
        $space = Space::findOrFail($id);
     

        $space->update($request->all());

        return redirect()->route('spaces.index')->with('success', 'Space updated successfully!');
    }

    public function destroy($id)
    {
        $space = Space::findOrFail($id);
        $space->delete();
        return redirect()->route('spaces.index')->with('success', 'Space deleted successfully!');
    }
}

