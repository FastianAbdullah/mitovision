@extends('layouts.auth')

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="row mb-4">
                <div class="col">
                    <div data-mdb-input-init class="form-outline">
                        <input type="text" id="form3Example1" name="name" class="form-control" />
                        <label class="form-label" for="form3Example1">First name</label>
                    </div>
                </div>
                <div class="col">
                    <div data-mdb-input-init class="form-outline">
                        <input type="text" id="form3Example2" name="last_name" class="form-control" />
                        <label class="form-label" for="form3Example2">Last name</label>
                    </div>
                </div>
            </div>

            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="email" id="form3Example3" name="email" class="form-control" />
                <label class="form-label" for="form3Example3">Email address</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" id="form3Example4" name="password" class="form-control" />
                <label class="form-label" for="form3Example4">Password</label>
            </div>

            <!-- Confirm Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" id="form3Example5" name="password_confirmation" class="form-control" />
                <label class="form-label" for="form3Example5">Confirm Password</label>
            </div>

            <!-- Checkbox -->
            <div class="form-check d-flex justify-content-center mb-4">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" name="subscribe" checked />
                <label class="form-check-label" for="form2Example33">
                    Subscribe to our newsletter
                </label>
            </div>

            <!-- Submit button -->
            <button type="submit" data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign up</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>or sign up with:</p>
                <button data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
                    <i class="fab fa-facebook-f"></i>
                </button>

                <button data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
                    <i class="fab fa-google"></i>
                </button>

                <button data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
                    <i class="fab fa-twitter"></i>
                </button>

                <button data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
                    <i class="fab fa-github"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="path/to/mdb-ui-kit.min.js"></script>
<script>
    import { Input, Ripple, initMDB } from "mdb-ui-kit";

    initMDB({ Input, Ripple });
</script>
