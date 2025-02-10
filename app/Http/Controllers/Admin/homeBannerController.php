<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeBanner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class homeBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = HomeBanner::all();
        return view('admin.HomeBanner.home_banners', compact('data'));
    }

    /**
     * Store or update a banner.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id'    => 'nullable|integer',
            'text'  => 'required|string|max:255',
            'link'  => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        }

        // Find existing banner or create a new one
        $banner = $request->id ? HomeBanner::find($request->id) : new HomeBanner();

        if (!$banner) {
            return back()->with('error', 'Banner not found.');
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($banner->image) { 
                Storage::delete('public/images/' . $banner->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $imageName);
            $banner->image = $imageName;
        }

        $banner->text = $request->text;
        $banner->link = $request->link;
        $banner->save();
 
        return back()->with(['success' => 'Successfully updated!', 'reload' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
    }
}
