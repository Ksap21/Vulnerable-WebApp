<?php
// Start session to maintain user state and security tokens
session_start();

// Generate CSRF token for form protection if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check for dark mode preference in cookie
$darkMode = isset($_COOKIE['dark_mode']) && $_COOKIE['dark_mode'] === 'true';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Banking Portal | Login</title>
    <style>
        /* Base Styles */
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --dark: #212529;
            --light: #f8f9fa;
            --danger: #e63946;
            --success: #2a9d8f;
            --transition: all 0.3s ease;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: <?php echo $darkMode ? '#121212' : '#f5f7fa'; ?>;
            color: <?php echo $darkMode ? '#f0f0f0' : '#333'; ?>;
            line-height: 1.6;
            transition: var(--transition);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        /* Container Styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Login Card */
        .login-card {
            background: <?php echo $darkMode ? '#1e1e1e' : '#fff'; ?>;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 450px;
            margin: 0 auto;
            transition: var(--transition);
            border: <?php echo $darkMode ? '1px solid #333' : 'none'; ?>;
            transform: translateY(0);
            opacity: 1;
            animation: fadeInUp 0.6s cubic-bezier(0.39, 0.575, 0.565, 1) both;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Header Styles */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: <?php echo $darkMode ? '#aaa' : '#666'; ?>;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: <?php echo $darkMode ? '#ddd' : '#555'; ?>;
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid <?php echo $darkMode ? '#444' : '#ddd'; ?>;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background: <?php echo $darkMode ? '#2a2a2a' : '#fff'; ?>;
            color: <?php echo $darkMode ? '#fff' : '#333'; ?>;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        /* Button Styles */
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
        }
        
        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        /* Utility Classes */
        .text-center {
            text-align: center;
        }
        
        .mt-3 {
            margin-top: 1rem;
        }
        
        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .alert-danger {
            background-color: rgba(230, 57, 70, 0.1);
            border-left: 4px solid var(--danger);
            color: var(--danger);
        }
        
        .alert-success {
            background-color: rgba(42, 157, 143, 0.1);
            border-left: 4px solid var(--success);
            color: var(--success);
        }
        
        /* Dark Mode Toggle */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: <?php echo $darkMode ? '#333' : '#e9ecef'; ?>;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        
        .theme-toggle:hover {
            transform: scale(1.1);
        }
        
        .theme-toggle i {
            font-size: 1.2rem;
            color: <?php echo $darkMode ? '#ffd700' : '#666'; ?>;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem;
            }
            
            .login-header h1 {
                font-size: 1.5rem;
            }
        }
        
        /* Floating Animation */
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="<?php echo $darkMode ? 'dark-mode' : ''; ?>">
    <!-- Dark Mode Toggle Button -->
    <button class="theme-toggle" onclick="toggleDarkMode()">
        <i class="<?php echo $darkMode ? 'fas fa-sun' : 'fas fa-moon'; ?>"></i>
    </button>

    <div class="container">
        <!-- Login Card -->
        <div class="login-card">
            <!-- Login Header with Logo -->
            <div class="login-header">
                <div style="margin-bottom: 1rem;" class="floating">
                    <i class="fas fa-unlock-alt" style="font-size: 3rem; color: var(--primary);"></i>
                </div>
                <h1>Secure Banking Portal</h1>
                <p>Enter your credentials to access your account</p>
            </div>
            
            <!-- Error/Success Messages -->
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> 
                    <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['level_complete'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> 
                    <?php echo htmlspecialchars($_SESSION['level_complete']); ?>
                    <?php unset($_SESSION['level_complete']); ?>
                </div>
            <?php endif; ?>
            
            <!-- Login Form -->
            <form action="login.php" method="POST" autocomplete="off">
                <!-- Username Field -->
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           class="form-control" 
                           placeholder="Enter your username" 
                           required
                           autofocus>
                </div>
                
                <!-- Password Field -->
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Enter your password" 
                           required>
                </div>
                
                <!-- CSRF Protection -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                
                <!-- Submit Button -->
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
                
                <!-- Forgot Password Link -->
                <div class="text-center mt-3">
                    <a href="#" style="color: var(--primary); text-decoration: none;">
                        <i class="fas fa-question-circle"></i> Forgot password?
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        /**
         * Toggle dark mode and save preference in cookie
         */
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            document.cookie = `dark_mode=${isDarkMode}; path=/; max-age=${60*60*24*365}`;
            
            // Update icon
            const icon = document.querySelector('.theme-toggle i');
            icon.classList.toggle('fa-sun');
            icon.classList.toggle('fa-moon');
        }
        
        /**
         * Add animation to input fields on focus
         */
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentNode.style.transform = 'scale(1)';
            });
        });
        
        /**
         * Add ripple effect to buttons
         */
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn')) {
                const btn = e.target;
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                
                const diameter = Math.max(btn.clientWidth, btn.clientHeight);
                const radius = diameter / 2;
                
                ripple.style.width = ripple.style.height = `${diameter}px`;
                ripple.style.left = `${e.clientX - (btn.getBoundingClientRect().left + radius)}px`;
                ripple.style.top = `${e.clientY - (btn.getBoundingClientRect().top + radius)}px`;
                
                btn.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }
        });
    </script>
</body>
</html>