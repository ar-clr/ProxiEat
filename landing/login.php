<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paws Up - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../assets/css/core/variables.css?v=<?= time() ?>" rel="stylesheet">
    <link href="../assets/css/pages/login.css?v=<?= time() ?>" rel="stylesheet">
</head>
<body>
    <div class="login-page">

        <section class="login-page__panel login-page__panel--left" aria-label="Login form">
            <div class="login-auth">

                <div class="login-auth__greeting" id="greetingText"></div>

                <div class="login-auth__brand">
                    <div class="login-auth__logo">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h1 class="login-auth__title">Paws Up</h1>
                </div>

                <p class="login-auth__subtitle">Sign in to continue to your account</p>

                <form class="login-form" id="loginForm" action="#" method="POST" novalidate>

                    <div class="login-form__group">
                        <label class="login-form__label" for="loginEmail">Email</label>
                        <input class="login-form__input" type="email" id="loginEmail" name="email" placeholder="Enter your email" required autocomplete="email">
                    </div>

                    <div class="login-form__group">
                        <label class="login-form__label" for="loginPassword">Password</label>
                        <div class="login-form__password-wrapper">
                            <input class="login-form__input" type="password" id="loginPassword" name="password" placeholder="Enter your password" required autocomplete="current-password">
                            <button class="login-form__toggle" type="button" id="togglePassword" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="login-form__options">
                        <label class="login-form__remember">
                            <input class="login-form__checkbox" type="checkbox" id="rememberMe" name="remember">
                            <span>Remember Me</span>
                        </label>
                        <a class="login-form__forgot" href="#" id="forgotPasswordLink">Forgot Password?</a>
                    </div>

                    <button class="login-form__submit" type="submit">Login</button>

                    <div class="login-form__divider">
                        <span class="login-form__divider-text">OR</span>
                    </div>

                    <button class="login-form__google" type="button" id="googleLoginBtn">
                        <svg class="login-form__google-icon" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.3v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        <span>Continue with Google</span>
                    </button>

                    <p class="login-form__register">
                        Don't have an account? <a href="register.php" id="registerLink">Register</a>
                    </p>

                </form>

            </div>
        </section>

        <section class="login-page__panel login-page__panel--right" aria-label="Information panel">
            <div class="login-companion">

                <h2 class="login-companion__heading">Daily Pet Insights</h2>

                <p class="login-companion__description">Smart IoT feeding technology that keeps your pet healthy and well-fed.</p>

                <div class="login-companion__card" id="flashCardContainer"></div>

                <div class="login-companion__navigation">
                    <button class="login-companion__nav-btn" id="flashPrev" type="button" aria-label="Previous slide">
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <div class="login-companion__dots" id="flashDots"></div>

                    <button class="login-companion__nav-btn" id="flashNext" type="button" aria-label="Next slide">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

            </div>
        </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/landing/login.js?v=<?= time() ?>"></script>

</body>
</html>