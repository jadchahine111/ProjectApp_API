<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\VerifyEmailRequest; // Import the custom request
use App\Http\Requests\AdminLoginRequest; // Import the custom request
use App\Http\Requests\SignUpRequest;
use App\Models\Admin;

class AuthController extends Controller
{

    // Login API
    public function login(LoginRequest $request)
    {
        // Validate request using LoginRequest (validation handled automatically)

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Validate user existence and password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Check user status (email verification)
        if ($user->userStatus === 'notVerified') {
            // Send verification email
            $this->sendVerificationEmail($user);

            return response()->json(['error' => 'Email is not verified. A verification email has been sent to your email address.'], 403);
        }

        // Check registration status (admin approval)
        if ($user->registrationStatus === 'pending') {
            return response()->json(['error' => 'Your registration is pending admin approval.'], 403);
        }

        // Generate Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return response with token and user details
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    // Send Verification Email
    protected function sendVerificationEmail(User $user)
    {
        $verificationUrl = route('verify.email', ['email' => $user->email]); // Define this route

        Mail::send([], [], function ($message) use ($user, $verificationUrl) {
            $message->to($user->email)
                ->subject('Verify Your Email Address')
                ->setBody("Click the link below to verify your email: <a href='$verificationUrl'>$verificationUrl</a>", 'text/html');
        });
    }

    // Verify Email
    public function verifyEmail(VerifyEmailRequest $request)  // Type-hinting the custom request here
    {
        $email = $request->query('email');  // Get email from the query parameter
        $user = User::where('email', $email)->first();  // Find the user by email

        // Check if user exists
        if ($user) {
            $user->userStatus = 'verified';  // Update user status to verified
            $user->save();  // Save the changes to the database

            return response()->json(['message' => 'Email verified successfully!']);
        }

        return response()->json(['error' => 'Invalid email address.'], 404);
    }

    // Sign Up API
    public function signUp(SignUpRequest $request)
    {
        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'frontIdPic' => $request->frontIdPic,
            'backIdPic' => $request->backIdPic,
            'CV' => $request->CV,
            'skills' => $request->skills,
            'bio' => $request->bio,
            'linkedinURL' => $request->linkedinURL,
            'userStatus' => 'notVerified',  // Initially set as notVerified
            'registrationStatus' => 'pending', // Initially set as pending
        ]);

        // Send verification email to the user
        $this->sendVerificationEmail($user);

        // Return the user resource response
        return response()->json([
            'message' => 'User registered successfully! A verification email has been sent.',
            'user' => new UserResource($user),
        ], 201);
    }
    
        // Login API
        public function loginAdmin(AdminLoginRequest $request)
        {
            // Validate request using LoginRequest (validation handled automatically)
    
            // Find user by email
            $admin = Admin::where('username', $request->username)->first();
    
            // Validate user existence and password
            if (!$admin || !Hash::check($request->password, $admin->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
    
            // Generate Sanctum token
            $token = $admin->createToken('AdminAuthToken')->plainTextToken;
    
            // Return response with token and user details
            return response()->json([
                'message' => 'Admin Login successful',
                'token' => $token,
            ]);
        }
}
