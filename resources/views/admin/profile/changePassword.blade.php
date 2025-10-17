@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <!-- Page Header -->
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Change Password</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin#dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('admin#viewProfile')}}" class="text-decoration-none">
                                    <i class="fas fa-user me-1"></i> Profile
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-key me-1"></i> Change Password
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-key me-2"></i> Change Password
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin#updatePassword')}}" method="POST" id="changePasswordForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Current Password -->
                                        <div class="mb-4">
                                            <label for="current_password" class="form-label fw-bold">
                                                <i class="fas fa-lock me-1"></i> Current Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password"
                                                       id="current_password"
                                                       name="current_password"
                                                       class="form-control @error('current_password') is-invalid @enderror"
                                                       placeholder="Enter your current password">
                                                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                                    <i class="fas fa-eye" id="currentPasswordIcon"></i>
                                                </button>
                                                @error('current_password')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- New Password -->
                                        <div class="mb-4">
                                            <label for="new_password" class="form-label fw-bold">
                                                <i class="fas fa-lock me-1"></i> New Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password"
                                                       id="new_password"
                                                       name="new_password"
                                                       class="form-control @error('new_password') is-invalid @enderror"
                                                       placeholder="Enter your new password">
                                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                                    <i class="fas fa-eye" id="newPasswordIcon"></i>
                                                </button>
                                                @error('new_password')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Confirm New Password -->
                                        <div class="mb-4">
                                            <label for="confirm_password" class="form-label fw-bold">
                                                <i class="fas fa-lock me-1"></i> Confirm New Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password"
                                                       id="confirm_password"
                                                       name="confirm_password"
                                                       class="form-control @error('confirm_password') is-invalid @enderror"
                                                       placeholder="Confirm your new password">
                                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                    <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                                </button>
                                                @error('confirm_password')
                                                    <div class="invalid-feedback">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Strength Indicator -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-shield-alt me-1"></i> Password Strength
                                    </label>
                                    <div class="progress mb-2" style="height: 8px;">
                                        <div class="progress-bar" id="passwordStrengthBar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted" id="passwordStrengthText">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Start typing to see password strength
                                    </small>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('admin#viewProfile') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Profile
                                    </a>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Change Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Password Requirements Card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-shield-alt me-2"></i> Password Requirements
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="fw-bold text-primary">
                                    <i class="fas fa-check-circle me-1"></i> Your password must contain:
                                </h6>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>
                                    အနည်းဆုံး စာလုံး <strong>၈</strong> လုံးရှိသင့်သည်။
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>
                                    At least one uppercase letter (A-Z)
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>
                                    At least one lowercase letter (a-z)
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>
                                    At least one number (0-9)
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>
                                    At least one special character (!@#$%^&*)
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Security Tips Card -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-lightbulb me-2"></i> Security Tips
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Keep your password secure:</strong>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Use a unique password
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Don't share with anyone
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Change regularly
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Avoid common words
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Password Toggle and Strength Check -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            function setupPasswordToggle(inputId, toggleId, iconId) {
                const input = document.getElementById(inputId);
                const toggle = document.getElementById(toggleId);
                const icon = document.getElementById(iconId);

                toggle.addEventListener('click', function() {
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }

            setupPasswordToggle('current_password', 'toggleCurrentPassword', 'currentPasswordIcon');
            setupPasswordToggle('new_password', 'toggleNewPassword', 'newPasswordIcon');
            setupPasswordToggle('confirm_password', 'toggleConfirmPassword', 'confirmPasswordIcon');

            // Password strength checker
            const newPasswordInput = document.getElementById('new_password');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');

            newPasswordInput.addEventListener('input', function() {
                const password = this.value;
                const strength = checkPasswordStrength(password);
                updateStrengthIndicator(strength);
            });

            function checkPasswordStrength(password) {
                let score = 0;
                let feedback = [];

                if (password.length >= 8) score += 1;
                else feedback.push('At least 8 characters');

                if (/[A-Z]/.test(password)) score += 1;
                else feedback.push('Uppercase letter');

                if (/[a-z]/.test(password)) score += 1;
                else feedback.push('Lowercase letter');

                if (/[0-9]/.test(password)) score += 1;
                else feedback.push('Number');

                if (/[^A-Za-z0-9]/.test(password)) score += 1;
                else feedback.push('Special character');

                return { score, feedback };
            }

            function updateStrengthIndicator(strength) {
                const percentage = (strength.score / 5) * 100;
                strengthBar.style.width = percentage + '%';

                if (strength.score <= 1) {
                    strengthBar.className = 'progress-bar bg-danger';
                    strengthText.textContent = 'Very Weak';
                    strengthText.className = 'text-danger';
                } else if (strength.score <= 2) {
                    strengthBar.className = 'progress-bar bg-warning';
                    strengthText.textContent = 'Weak';
                    strengthText.className = 'text-warning';
                } else if (strength.score <= 3) {
                    strengthBar.className = 'progress-bar bg-info';
                    strengthText.textContent = 'Fair';
                    strengthText.className = 'text-info';
                } else if (strength.score <= 4) {
                    strengthBar.className = 'progress-bar bg-primary';
                    strengthText.textContent = 'Good';
                    strengthText.className = 'text-primary';
                } else {
                    strengthBar.className = 'progress-bar bg-success';
                    strengthText.textContent = 'Strong';
                    strengthText.className = 'text-success';
                }
            }
        });
    </script>
@endsection
