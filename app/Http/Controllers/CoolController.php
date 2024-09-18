<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Progress;
use App\Models\Publisher;
use App\Models\User;
use App\Traits\GeneralTraits;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CoolController extends Controller
{
    use GeneralTraits;

    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['except' => ['login', 'register', 'logout']]);
    }

    public function cool(Request $request)
    {
        $categories = $request->category;
        $category = [];

        foreach ($categories as $categoryName) {
            if (!$category[] = Category::where('name', $categoryName)
                ->first()) {
                $category[] = Category::create([
                    'name' => $categoryName
                ]);
            }
        }
        if (!$publisher = Publisher::where("name", $request->publisher)
            ->first()) {
            $publisher = Publisher::create([
                'name' => $request->publisher,
            ]);
        }
        if (!$author = Author::where("name", $request->author)
            ->first()) {
            $author = Author::create([
                'name' => $request->author,
            ]);
        }
        return [$category, $publisher, $author];
    }


    public function add(Request $data)
    {
        $book_ids = Progress::where('user_id', $data->user->id)
            -> where('ratio', '<', 100)
            -> get()
            -> pluck('book_id');

        $books = [];

        foreach($book_ids as $book_id)
        {
            $books[] = Book::where('id', $book_id)
                -> first();
        }

        return $books;
    }

    public function coool(Request $data)
    {

        return $data;
        $query = Book::query();

        // Apply filters based on provided search criteria
        if (!empty($data->title)) {
            $query->where('title', 'LIKE', "%{$data->title}%");
        }

        if (!empty($data->category)) {
            \Log::info("Searching by category: " . $data->category); // Add this line to log the category being searched
            $query->whereHas('categories', function ($q) use ($data) {
                \Log::info("Executing category filter"); // Log when the filter is applied
                $q->where('name', 'LIKE', "%{$data->category}%");
            });
        }

        if (!empty($data->author)) {
            $query->whereHas('author', function ($q) use ($data) {
                $q->where('name', 'LIKE', "%{$data->author}%");
            });
        }

        if (!empty($data->publisher)) {
            $query->whereHas('publisher', function ($q) use ($data) {
                $q->where('name', 'LIKE', "%{$data->publisher}%");
            });
        }

        // Execute the query with the applied filters
        return $query->get();
    }








    ////////////////

    /**
     * @throws ValidationException
     *
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();
        if(!$user)
        {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError(401, "ممنوع الوصول");
            }
            return $this->returnError(401, "Access Denied");
        }
        $token = Auth::attempt($credentials);

        if (!$token) {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError(401, 'غير مصرح');
            }
            return $this->returnError(401, "Unauthorized");
        }
        if($credentials['password'] != $user->password)
            throw ValidationException::withMessages([
                'password' => ['The password is incorrect'],
            ]);
        $token =  $user->createToken('token');
        Session::start();
        if($this->getCurrentLang() == 'ar')
        {
            return $this->returnData(200, 'token', $token->plainTextToken, 'تم تسجيل الدخول بنجاح');
        }
        return $this->returnData(200, 'token', $token->plainTextToken, "You've logged in successfully");
    }
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        $token = $user->createToken('token');

        if($this->getCurrentLang() == 'ar')
        {
            return $this->returnData(200, 'token', $token->plainTextToken, 'تم تسجيل الدخول بنجاح');
        }
        return $this->returnData(200, 'token', $token->plainTextToken, "You've registered successfully");
    }
}
