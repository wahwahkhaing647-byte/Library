<?php

namespace App\Controller;

use App\Service\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Response\ApiResponse;

class UserController extends BaseController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $this->validateRequest(LoginRequest::class);

            $user = $this->userService->login($data);

            session_start();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;

            $_SESSION['success'] = 'Login successful! Welcome back.';

            $this->redirect(BASE_URL . '/Public/index.php?page=home');
        }

        $this->view('users/login', [
            'pageTitle' => 'Login',
            'section' => '',
            'hideSearch' => true,
            'error' => $_SESSION['error'] ?? []
        ]);

        unset($_SESSION['error']);
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $this->validateRequest(UserRequest::class);

            $this->userService->register($data);

            $_SESSION['success'] = 'Registration successful. Please login.';

            $this->redirect(BASE_URL . '/Public/index.php?page=login');
        }

        $this->view('users/register', [
            'pageTitle' => 'Register',
            'section' => '',
            'hideSearch' => true,
            'error' => $_SESSION['error'] ?? []
        ]);

        unset($_SESSION['error']);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(): void
    {
        $this->userService->logout();

        $this->redirect(BASE_URL . '/Public/index.php?page=login');
    }

    /*
    |--------------------------------------------------------------------------
    | USER LIST
    |--------------------------------------------------------------------------
    */
    public function index(): void
    {
        $users = $this->userService->getAllUsers();

        $this->view('users/index', [
            'response' => ApiResponse::success(
                $users,
                "Users fetched successfully"
            )
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SINGLE USER
    |--------------------------------------------------------------------------
    */
    public function show(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            $this->redirect(BASE_URL . '/Public/index.php?page=users');
        }

        $user = $this->userService->getUserById($id);

        if (!$user) {
            $this->redirect(BASE_URL . '/Public/index.php?page=users');
        }

        $this->view('users/show', [
            'pageTitle' => $user->name,
            'user' => $user
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'name' => $this->post('name'),
                'email' => $this->post('email'),
                'password' => $this->post('password')
            ];

            $this->userService->register($data);

            $_SESSION['success'] = 'User created successfully';

            $this->redirect(BASE_URL . '/Public/index.php?page=users');
        }

        $this->view('users/create', [
            'pageTitle' => 'Create User',
            'section' => ''
        ]);
    }
}