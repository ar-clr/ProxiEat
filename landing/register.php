<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paws Up - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../assets/css/core/variables.css?v=<?= time() ?>" rel="stylesheet">
    <link href="../assets/css/pages/register.css?v=<?= time() ?>" rel="stylesheet">
</head>
<body>
    <div class="login-page">

        <section class="login-page__panel login-page__panel--left" aria-label="Registration form">
            <div class="login-auth">

                <div class="login-auth__greeting" id="greetingText"></div>

                <div class="login-auth__brand">
                    <div class="login-auth__logo">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h1 class="login-auth__title">Paws Up</h1>
                </div>

                <p class="login-auth__subtitle">Create your Paws Up account</p>

                <form class="login-form" id="registerForm" action="#" method="POST" novalidate>

                    <div class="login-form__helper">* Required fields</div>

                    <div class="login-form__row">
                        <div class="login-form__group">
                            <label class="login-form__label" for="registerFirstName">First Name <span class="required-asterisk" aria-hidden="true">*</span></label>
                            <input class="login-form__input" type="text" id="registerFirstName" name="firstName" placeholder="Enter your first name" required autocomplete="given-name">
                        </div>

                        <div class="login-form__group">
                            <label class="login-form__label" for="registerLastName">Last Name <span class="required-asterisk" aria-hidden="true">*</span></label>
                            <input class="login-form__input" type="text" id="registerLastName" name="lastName" placeholder="Enter your last name" required autocomplete="family-name">
                        </div>
                    </div>

                    <div class="login-form__group">
                        <label class="login-form__label" for="registerEmail">Email Address <span class="required-asterisk" aria-hidden="true">*</span></label>
                        <input class="login-form__input" type="email" id="registerEmail" name="email" placeholder="Enter your email" required autocomplete="email">
                    </div>

                    <div class="login-form__row">
                        <div class="login-form__group">
                            <label class="login-form__label" for="registerPhone">Phone Number <span class="required-asterisk" aria-hidden="true">*</span></label>
                            <div class="login-form__phone-wrapper">
                                <span class="login-form__phone-prefix" aria-hidden="true"><b>+63</b></span>
                                <input class="login-form__input login-form__input--phone" type="tel" id="registerPhone" name="phone" placeholder="9123456789" required inputmode="numeric">
                            </div>
                        </div>

                        <div class="login-form__group">
                            <label class="login-form__label" for="registerBirthday">Birthday <span class="required-asterisk" aria-hidden="true">*</span></label>
                            <input class="login-form__input" type="date" id="registerBirthday" name="birthday" required>
                        </div>
                    </div>

                    <div class="login-form__group">
                        <label class="login-form__label" for="registerPassword">Password <span class="required-asterisk" aria-hidden="true">*</span></label>
                        <div class="login-form__password-wrapper">
                            <input class="login-form__input" type="password" id="registerPassword" name="password" placeholder="Create a password" required autocomplete="new-password">
                            <button class="login-form__toggle" type="button" id="togglePassword" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                            <div class="login-form__tooltip" id="passwordTooltip" role="tooltip" aria-hidden="true">
                                <div class="login-form__tooltip-arrow"></div>
                                <ul class="login-form__tooltip-list">
                                    <li class="login-form__tooltip-item" data-requirement="length">At least 8 characters</li>
                                    <li class="login-form__tooltip-item" data-requirement="uppercase">One uppercase letter</li>
                                    <li class="login-form__tooltip-item" data-requirement="lowercase">One lowercase letter</li>
                                    <li class="login-form__tooltip-item" data-requirement="number">One number</li>
                                    <li class="login-form__tooltip-item" data-requirement="special">One special character</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="login-form__group">
                        <label class="login-form__label" for="registerConfirmPassword">Confirm Password <span class="required-asterisk" aria-hidden="true">*</span></label>
                        <div class="login-form__password-wrapper">
                            <input class="login-form__input" type="password" id="registerConfirmPassword" name="confirmPassword" placeholder="Confirm your password" required autocomplete="new-password">
                            <button class="login-form__toggle" type="button" id="toggleConfirmPassword" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                            <span class="login-form__confirm-message" id="confirmMessage" aria-live="polite"></span>
                        </div>
                    </div>

                    <div class="login-form__terms">
                        <input type="checkbox" id="termsCheckbox" required>
                        <label for="termsCheckbox">I agree to the <a href="#" class="login-form__terms-link" data-modal="legalModal">Terms and Conditions</a> and <a href="#" class="login-form__terms-link" data-modal="legalModal">Privacy Policy</a></label>
                    </div>

                    <button class="login-form__submit" type="submit">Create Account</button>

                    <div class="login-form__divider">
                        <span class="login-form__divider-text">OR</span>
                    </div>

                    <button class="login-form__google" type="button" id="googleRegisterBtn">
                        <svg class="login-form__google-icon" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.3v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        <span>Continue with Google</span>
                    </button>

                    <p class="login-form__register">
                        Already have an account? <a href="login.php" id="loginLink">Login</a>
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

    <!-- Legal Modal -->
    <div class="modal-overlay" id="legalModal" aria-hidden="true">
        <div class="modal" role="dialog" aria-labelledby="legalModalTitle" aria-modal="true">
            <div class="modal__header">
                <h3 id="legalModalTitle">Legal Information</h3>
                <button class="modal__close" type="button" aria-label="Close modal" id="closeModal">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="modal__tabs" role="tablist" aria-label="Legal sections">
                <button class="modal__tab is-active" role="tab" aria-selected="true" aria-controls="tab-terms" id="tab-terms-btn" type="button">Terms</button>
                <button class="modal__tab" role="tab" aria-selected="false" aria-controls="tab-privacy" id="tab-privacy-btn" type="button">Privacy</button>
                <button class="modal__tab" role="tab" aria-selected="false" aria-controls="tab-proxie" id="tab-proxie-btn" type="button">ProxiE AI</button>
                <button class="modal__tab" role="tab" aria-selected="false" aria-controls="tab-proxieat" id="tab-proxieat-btn" type="button">ProxiEat</button>
            </div>
            <div class="modal__body">
                <div class="modal__tab-panel is-active" id="tab-terms" role="tabpanel" aria-labelledby="tab-terms-btn">
                    <h4>Terms and Conditions</h4>
                    <p><strong>Acceptance of Terms</strong><br>
                    By accessing or using Paws Up, you agree to be bound by these Terms and Conditions. If you do not agree, please do not use the platform.</p>

                    <p><strong>Platform Services</strong><br>
                    Paws Up is a web-based appointment and veterinary services management platform developed for Consult A Vet – Tandang Sora Branch. It includes ProxiEat, an IoT smart pet feeder integration, and ProxiE, an AI-powered chatbot for pet care guidance and platform assistance.</p>

                    <p><strong>User Responsibilities</strong><br>
                    You agree to provide accurate information, keep your account secure, and use the platform only for lawful purposes. You are responsible for all activity under your account.</p>

                    <p><strong>Appointment Policies</strong><br>
                    Appointments are subject to availability. Please arrive on time for scheduled consultations. Cancellations should be made at least 24 hours in advance when possible.</p>

                    <p><strong>Medical Information Disclaimer</strong><br>
                    Any information provided through Paws Up, including AI-generated guidance from ProxiE, is for general informational purposes only. It does not replace professional veterinary advice, diagnosis, or treatment. Always consult a licensed veterinarian for medical concerns.</p>

                    <p><strong>Intellectual Property</strong><br>
                    All content, features, and functionality of Paws Up, including text, graphics, logos, and software, are the exclusive property of Consult A Vet – Tandang Sora Branch and its affiliates. Unauthorized use is prohibited.</p>

                    <p><strong>Limitation of Liability</strong><br>
                    Paws Up is provided on an "as is" basis. We do not guarantee uninterrupted or error-free service. To the fullest extent permitted by law, Consult A Vet – Tandang Sora Branch shall not be liable for indirect, incidental, or consequential damages arising from your use of the platform.</p>

                    <p><strong>Updates to these Terms</strong><br>
                    We may revise these Terms from time to time. Continued use of Paws Up after changes are posted constitutes your acceptance of the updated Terms.</p>
                </div>

                <div class="modal__tab-panel" id="tab-privacy" role="tabpanel" aria-labelledby="tab-privacy-btn" hidden>
                    <h4>Privacy Policy</h4>
                    <p><strong>Information We Collect</strong><br>
                    We collect information you provide directly, such as your name, email, phone number, and pet details. We may also collect usage data to improve the platform experience.</p>

                    <p><strong>How Information Is Used</strong><br>
                    Your information is used to manage appointments, deliver services, communicate updates, and improve Paws Up. ProxiE may use your inputs to provide pet care guidance within the platform.</p>

                    <p><strong>Data Protection</strong><br>
                    We implement reasonable security measures to protect your personal information. However, no method of transmission over the internet or electronic storage is 100% secure.</p>

                    <p><strong>Information Sharing</strong><br>
                    We do not sell or rent your personal information. Data may be shared with trusted service providers who assist in platform operations, or when required by law.</p>

                    <p><strong>Data Retention</strong><br>
                    We retain your information only as long as necessary to provide services and comply with legal obligations. You may request account deletion by contacting our support team.</p>

                    <p><strong>User Rights</strong><br>
                    You have the right to access, correct, or delete your personal data. You may also opt out of non-essential communications at any time.</p>
                </div>

                <div class="modal__tab-panel" id="tab-proxie" role="tabpanel" aria-labelledby="tab-proxie-btn" hidden>
                    <h4>AI Assistant Disclaimer</h4>
                    <p>ProxiE provides general pet care guidance and platform assistance through artificial intelligence. It is not a substitute for professional veterinary advice, diagnosis, or treatment. Always consult a licensed veterinarian for medical concerns about your pet.</p>
                </div>

                <div class="modal__tab-panel" id="tab-proxieat" role="tabpanel" aria-labelledby="tab-proxieat-btn" hidden>
                    <h4>Smart Feeder Disclaimer</h4>
                    <p>ProxiEat assists with scheduled feeding through IoT integration. Pet owners remain responsible for monitoring their pets and ensuring proper nutrition. Paws Up is not liable for interruptions caused by internet issues, power outages, or hardware malfunction.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/landing/register.js?v=<?= time() ?>"></script>

</body>
</html>
