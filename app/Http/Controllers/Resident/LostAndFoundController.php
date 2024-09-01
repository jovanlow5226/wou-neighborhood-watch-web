<?php


namespace App\Http\Controllers\Resident;
use App\Http\Controllers\Resident\LostAndFoundController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DateTime;
Use App\http\Controllers\Controller;
use App\Models\LostItem;
use App\Models\Category;
use App\Models\User;


class LostAndFoundController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Store User Details
        // Create an array with user details
        $user_details = [
            'login_id' => $user->login_id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        $lostItems = LostItem::paginate(5); // Paginate with 10 items per page
        $categories = Category::all();
        return view('lost_and_found.index', compact('user_details','lostItems','categories'));
    }

    public function create()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Store User Details
        // Create an array with user details
        $user_details = [
            'login_id' => $user->login_id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        $categories = Category::all();
        return view('lost_and_found.create', compact('user_details','categories'));
    }

    public function store(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_info' => 'required|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('lost-items', 'public');
        }

        LostItem::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'image_path' => $imagePath,
            'contact_info' => $request->contact_info,
            'user_id' => $user->id,
        ]);

        return redirect()->route('lost_and_found.index')->with('success', 'Lost item reported successfully.');
    }

    public function show($id)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Store User Details
        // Create an array with user details
        $user_details = [
            'login_id' => $user->login_id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        $lostItem = LostItem::with('user')->findOrFail($id);
        return view('lost_and_found.show', compact('user_details','lostItem'));
    }

    public function search(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Store User Details
        // Create an array with user details
        $user_details = [
            'login_id' => $user->login_id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        $query = LostItem::query();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', "%{$request->keyword}%")
                  ->orWhere('description', 'LIKE', "%{$request->keyword}%");
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', "%{$request->location}%");
        }

        $lostItems = $query->get();

        return view('lost_and_found.search-results', compact('user_details','lostItems'));
    }

    public function markAsFound($lostItem)
    {
        // Logic to mark the lost item as "Found"
        $lostItem = LostItem::findOrFail($lostItem);
        $lostItem->update(['status' => 'Found']);

        return redirect()->route('lost_and_found.show', $lostItem->id)->with('success', 'Item marked as found successfully.');
    }
}
