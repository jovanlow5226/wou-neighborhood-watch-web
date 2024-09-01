<?php
namespace App\Http\Controllers\Management;
use App\Http\Controllers\Management\LostAndFoundManagementController;
Use App\http\Controllers\Controller;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class LostAndFoundManagementController extends Controller
{
    // Function to show dashboard with filters and lists
    public function index(Request $request)
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

        $query = LostItem::with(['user', 'category']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(5);
        $categories = Category::all();

        return view('management_modules/lost_and_found/index', compact('user_details', 'items', 'categories'));
    }

    // Function to update the status of a lost item
    public function updateStatus(Request $request, $id)
    {
        $item = LostItem::findOrFail($id);
        $item->status = $request->status; // ensure 'status' is validated or sanitized
        $item->save();

        return redirect()->back()->with('success', 'Item status updated successfully.');
    }

    public function showLostItem($id)
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
        $lostItem = LostItem::with('category', 'user')->findOrFail($id);
        return view('management_modules/lost_and_found/show_lost_item', compact('user_details', 'lostItem'));
    }

    public function search(Request $request)
    {
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

        $lostItems = $query->paginate(10);

        return view('lost_and_found.search_results', compact('lostItems'));
    }

    public function markAsFound($id)
    {
        $lostItem = LostItem::findOrFail($id);
        $lostItem->update(['status' => 'Found']);
        return redirect()->route('management_modules/lost_and_found/index')->with('success', 'Item marked as found successfully.');
    }

    public function createLostItem()
    {
        $categories = Category::all();
        return view('management_modules/lost_and_found/create_lost_item', compact('categories'));
    }

    public function storeLostItem(Request $request)
    {
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
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('management_modules/lost_and_found/index')->with('success', 'Lost item reported successfully.');
    }

    public function createFoundItem()
    {
        $categories = Category::all();
        return view('management_modules/lost_and_found/create_found_item', compact('categories'));
    }

    public function storeFoundItem(Request $request)
    {
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
            $imagePath = $request->file('image')->store('found-items', 'public');
        }

        FoundItem::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'image_path' => $imagePath,
            'contact_info' => $request->contact_info,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('management_modules/lost_and_found/index')->with('success', 'Found item recorded successfully.');
    }
}
